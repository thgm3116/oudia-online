<?php
namespace App\Controller;

use App\Form\DiaFileUploadForm;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\Controller\Component\DiaFileImporterComponent;

/**
 * Dia Controller
 */
class DiaController extends AppController
{
    public $components = ['DiaFileImporter'];

    /**
     * Top page method
     */
    public function index()
    {
        $this->set('title', 'Diagram View' . self::TITLE_POSTFIX);
        $this->set('h1', 'Diagram View');
        $this->set('is_dia_view_link_enabled', false);

        $dia_groups = TableRegistry::get('DiaGroup')->find()->contain('dia_file');
        $this->set('dia_groups', $dia_groups);

        $upload_form = new DiaFileUploadForm();
        $this->set('upload_form', $upload_form);

        if (empty($this->request->data)) {
            return;
        }

        $tmp_file = $this->request->data['diafile']['tmp_name'];
        if (!empty($tmp_file)) {
            $this->DiaFileImporter->import($tmp_file, $this->request->data['diafile']['name']);
        }
    }

    /**
     * Default View method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewDefault()
    {
        $TrainTable = TableRegistry::get('Train');
        $dia_group_id = (int)$this->request->param('dia_group_id');
        $distance = $this->request->param('distance');
        $train_result = $TrainTable->find()
            ->contain(['dia', 'train_type'])
            ->where(['dia_group_id' => $dia_group_id, 'distance' => $distance])
            ->order(['Train.id ASC'])
            ->all();

        $DiaGroupTable = TableRegistry::get('DiaGroup');
        $dia_group_result = $DiaGroupTable->find()
            ->contain('dia_file')
            ->where(['DiaGroup.id' => $dia_group_id])
            ->last()
            ->toArray();

        $StationTable = TableRegistry::get('Station');
        $station_result = $StationTable->find()
            ->where(['dia_file_id' => $dia_group_result['dia_file_id']])
            ->all()
            ->toArray();

        $distance_japanese = '下り';
        $opposite_distance = 'nobori';
        $opposite_distance_japanese = '上り';
        if ($distance === 'nobori') {
            $distance_japanese = '上り';
            $opposite_distance = 'kudari';
            $opposite_distance_japanese = '下り';
            rsort($station_result);
        }

        $this->set('title', 'Diagram View (Default)' . self::TITLE_POSTFIX);
        $this->set('h1', 'Diagram View (Default)');
        $this->set('is_dia_view_link_enabled', false);

        $this->set('distance', $distance);
        $this->set('distance_japanese', $distance_japanese);
        $this->set('opposite_distance', $opposite_distance);
        $this->set('opposite_distance_japanese', $opposite_distance_japanese);
        $this->set('dia_and_trains', $train_result);
        $this->set('stations', $station_result);
        $this->set('dia_file', $dia_group_result['dia_file']);
        $this->set('dia_group_id', $dia_group_result['id']);
        $this->set('dia_group_name', $dia_group_result['name']);
    }

    /**
     * Station View method
     *
     * @param string|null $station_id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewStation()
    {
        $dia_group_id = (int)$this->request->param('dia_group_id');
        $distance = $this->request->param('distance');
        $station_id = $this->request->param('station_id');

        $DiaTable = TableRegistry::get('dia');
        $departure_time_condition = null;
        $dia_result = $DiaTable->find()
            ->contain(['station', 'train', 'train.train_type'])
            ->where([
                'dia.status' => 1,
                'dia.isLastDia IS NOT ' => 1,
                // station.statusはとりあえず見なくてもおｋかな・・・？
                'station.id' => $station_id,
                'train.dia_group_id' => $dia_group_id,
                'train.distance' => $distance,
                'train.status' => 1,
            ])
            ->select([
                'dia.departureTime',
                'dia.arrivalTime',
                'dia.type',
                'dia.isFirstDia',
                'train.id',
                'train.identification_id',
                'train.distance',
                'train.bikou',
                'train_type.name',
                'train_type.shortName',
                'train_type.timetableColor',
                'train_type.timetableFont',
            ])
            ->all();

        //where IS NOT 空文字 がうまく動かないのでここでフィルタリング
        $filtered_dia_result = [];
        foreach ($dia_result as $dia) {
            if ($dia['departureTime'] !== '') {
                $filtered_dia_result[] = $dia;
            }
        }
        $dia_result = $filtered_dia_result;
        unset($filtered_dia_result);

        // 時間ごとに区切った配列に変える
        $dia_in_hour_array = [];
        $max_train_number = 0;
        for ($i=0; $i < 24; $i++) {
            $tmp_dia_in_hour = [];
            $hour = $i * 100;
            foreach ($dia_result as $key => $dia) {
                if ($dia['departureTime'] === '2') {
                    continue;
                }

                $departure_time = (int)$dia['departureTime'];
                if ($departure_time - $hour >= 100) {
                    continue;
                }

                $tmp_dia_in_hour[] = $dia;
                unset ($dia_result[$key]);
            }
            // 格納前に、その駅におけるdepartureTime昇順に切り替える
            sort($tmp_dia_in_hour);

            $dia_in_hour_array[$i] = $tmp_dia_in_hour;


            // 後述の要素数補完のため、時間あたりの列車数の最大値を計測して保存する
            $train_number = count($tmp_dia_in_hour);
            if ($train_number > $max_train_number) {
                $max_train_number = $train_number;
            }
        }

        // 時間あたりの列車数の最大値に各要素の数を合わせる
        foreach ($dia_in_hour_array as $key => $dia_in_hour) {
            $current_train_number = count($dia_in_hour);
            for($i=$current_train_number; $i < $max_train_number; $i++) {
                $dia_in_hour_array[$key][] = ['departureTime' => ''];
            }
        }

        // DIA_VIEW_OFFSET時を先頭に持ってくる。
        // @todo DIA_VIEW_OFFSETはリファクタリング時にどこか適切な場所に移動する。
        define('DIA_VIEW_OFFSET', 4);
        for ($i=0; $i<DIA_VIEW_OFFSET; $i++) {
            $shifted_array = $dia_in_hour_array[$i];
            unset ($dia_in_hour_array[$i]);
            array_push($dia_in_hour_array, $shifted_array);
        }

        $DiaGroupTable = TableRegistry::get('DiaGroup');
        $dia_group_result = $DiaGroupTable->find()
            ->contain('dia_file')
            ->where(['DiaGroup.id' => $dia_group_id])
            ->last()
            ->toArray();

        $StationTable = TableRegistry::get('Station');
        $station_result = $StationTable->find()
            ->where(['id' => $station_id])
            ->select(['id', 'name'])
            ->last()
            ->toArray();

        $distance_japanese = '下り';
        $opposite_distance = 'nobori';
        $opposite_distance_japanese = '上り';
        if ($distance === 'nobori') {
            $distance_japanese = '上り';
            $opposite_distance = 'kudari';
            $opposite_distance_japanese = '下り';
        }

        $this->set('title', 'Diagram View (Station)' . self::TITLE_POSTFIX);
        $this->set('h1', 'Diagram View (Station)');
        $this->set('is_dia_view_link_enabled', true);

        $this->set('dia_file', $dia_group_result['dia_file']);
        $this->set('dia_group_id', $dia_group_id);
        $this->set('dia_group_name', $dia_group_result['name']);
        $this->set('distance', $distance);
        $this->set('distance_japanese', $distance_japanese);
        $this->set('opposite_distance', $opposite_distance);
        $this->set('opposite_distance_japanese', $opposite_distance_japanese);
        $this->set('dia_in_hour_array', $dia_in_hour_array);
        $this->set('station_id', $station_result['id']);
        $this->set('station_name', $station_result['name']);
        $this->set('max_train_number', $max_train_number);
    }

    /**
     * Train View method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewTrain()
    {
        $dia_group_id = (int)$this->request->param('dia_group_id');
        $distance = $this->request->param('distance');
        $train_id = $this->request->param('train_id');

        $TrainTable = TableRegistry::get('train');
        $train_result = $TrainTable->find()
            ->contain([
                'dia',
                'train_type'
            ])
            ->where(['train.id' => $train_id])
            ->last()
            ->toArray();

        $DiaGroupTable = TableRegistry::get('DiaGroup');
        $dia_group_result = $DiaGroupTable->find()
            ->contain('dia_file')
            ->where(['DiaGroup.id' => $dia_group_id])
            ->last()
            ->toArray();

        $StationTable = TableRegistry::get('Station');
        $station_result = $StationTable->find()
            ->where(['dia_file_id' => $dia_group_result['dia_file']['id']])
            ->select(['id', 'name'])
            ->all()
            ->toArray();

        $distance_japanese = '下り';
        if ($distance === 'nobori') {
            $distance_japanese = '上り';
            rsort($station_result);
        }

        $this->set('title', 'Diagram View (Train)' . self::TITLE_POSTFIX);
        $this->set('h1', 'Diagram View (Train)');
        $this->set('is_dia_view_link_enabled', true);

        $this->set('dia_file', $dia_group_result['dia_file']);
        $this->set('dia_group_id', $dia_group_id);
        $this->set('dia_group_name', $dia_group_result['name']);
        $this->set('distance_japanese', $distance_japanese);
        $this->set('distance', $distance);

        $this->set('stations', $station_result);
        $this->set('train_dia_array', $train_result);
    }
}
