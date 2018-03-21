<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * DiaFileImporter component
 */
class DiaFileImporterComponent extends Component
{
    /** @var string */
    private $__filename;
    /** @var int */
    private $__dia_file_id;
    /** @var int */
    private $__dia_group_id;

    /**
     * @param string $tmp_file_path
     * @param string $filename
     * @return array|bool $result
     */
    public function import($tmp_file_path, $filename)
    {
        $this->__filename = h(trim($filename));
        $this->saveDiaFile();

        $contents_array = file(h(trim($tmp_file_path)));
        mb_convert_variables('UTF-8', 'Shift-JIS', $contents_array);

        $exploded_contents_array = $this->__getExplodedContents($contents_array);

        $categorised_contents_array = $this->__getCategorisedContents($exploded_contents_array);

        $result = $this->__importContents($categorised_contents_array);

        return $result;
    }

    /**
     * @param array $contents_array
     * @return array $exploded_contents_array
     */
    private function __getExplodedContents(array $contents_array)
    {
        $exploded_contents_array = [];
        $tmp = [];
        // 1行目は作成したバージョン情報なので削除
        array_shift($contents_array);
        foreach ($contents_array as $contents) {
            $contents = trim($contents);
            if ($contents === '.') {
                $exploded_contents_array[] = $tmp;
                $tmp = [];
            } else {
                $tmp[] = $contents;
            }
        }

        return $exploded_contents_array;
    }

    /**
     * @param array $exploded_contents_array
     * @return array $categorised_contents_array
     */
    private function __getCategorisedContents(array $exploded_contents_array)
    {
        $categorised_contents_array = [];
        foreach ($exploded_contents_array as $contents_array) {
            $tmp = [];
            $tmp_dia = [];
            foreach ($contents_array as $contents) {
                // Dia.がRessya.とかぶっているので、Dia.の時だけ追加の処理を入れる
                if ($contents === 'Dia.') {
                    $tmp_dia['target'] = $contents;
                    continue;
                } elseif ($contents === 'Kudari.' || $contents === 'Nobori.') {
                    continue;
                } elseif (preg_match('/^DiaName=/', $contents)) {
                    $elements = explode('=', $contents);
                    $tmp_dia[$elements[0]] = $elements[1];
                    continue;
                }

                if (strpos($contents, '.') && !strpos($contents, '=')) {
                    $tmp['target'] = $contents;
                } else {
                    $elements = explode('=', $contents);
                    $tmp[$elements[0]] = $elements[1];
                }
            }
            if (!empty($tmp_dia)) {
                $categorised_contents_array[] = $tmp_dia;
            }
            $categorised_contents_array[] = $tmp;
        }

        return $categorised_contents_array;
    }

    /**
     * @return bool|\Cake\Datasource\EntityInterface|false|mixed
     */
    private function saveDiaFile()
    {
        $DiaFileTable = TableRegistry::get('DiaFile');
        $DiaFileEntity = $DiaFileTable->newEntity();
        $DiaFileEntity->filename = $this->__filename;
        $DiaFileEntity->status = 1;
        $result = $DiaFileTable->save($DiaFileEntity);

        // DiaFile_idをプロパティにセットする
        $this->__dia_file_id = $result->get('id');

        return $result;
    }

    /**
     * @param array $categorised_contents_array
     */
    private function __importContents (array $categorised_contents_array)
    {
        $dia_count = 0;
        $dia_group_count = 0;
        $station_count = 0;
        $train_count = 0;
        $train_type_count = 0;

        $train_type_index = 0;
        foreach ($categorised_contents_array as $contents_array) {
            $contents_array['dia_file_id'] = $this->__dia_file_id;

            if (empty($contents_array['target'])) {
                continue;
            }

            switch($contents_array['target']) {
                case 'Dia.':
                    $DiaGroupTable = TableRegistry::get('DiaGroup');
                    $DiaGroupEntity = $DiaGroupTable->getEntity($this->__dia_file_id, $contents_array['DiaName']);
                    $dia_group_result = $DiaGroupTable->save($DiaGroupEntity);
                    $this->__dia_group_id = $dia_group_result->get('id');
                    $dia_group_count++;
                    break;
                case 'Eki.':
                    $StationTable = TableRegistry::get('Station');
                    $StationEntity = $StationTable->getEntityFromCategorisedContentsArray($contents_array);
                    $StationTable->save($StationEntity);
                    $station_count++;
                    break;
                case 'Ressya.':
                    $TrainTable = TableRegistry::get('Train');
                    $contents_array['dia_group_id'] = $this->__dia_group_id;
                    $TrainEntity = $TrainTable->getEntityFromCategorisedContentsArray($contents_array);
                    $train_result = $TrainTable->save($TrainEntity);
                    $train_id = $train_result->get('id');
                    $train_count++;

                    $spritted_dia_array = explode(',', $contents_array['EkiJikoku']);
                    $DiaTable = TableRegistry::get('Dia');
                    $DiaEntities = $DiaTable->getEntities(
                        $spritted_dia_array,
                        $contents_array['Houkou'],
                        $train_id,
                        $this->__dia_file_id
                    );
                    foreach ($DiaEntities as $DiaEntity) {
                        $DiaTable->save($DiaEntity);
                        $dia_count++;
                    }
                    break;
                case 'Ressyasyubetsu.':
                    $contents_array['idInFile'] = $train_type_index;
                    $train_type_index++;

                    $TrainTypeTable = TableRegistry::get('TrainType');
                    $TrainTypeEntity = $TrainTypeTable->getEntityFromCategorisedContentsArray($contents_array);
                    $TrainTypeTable->save($TrainTypeEntity);
                    $train_type_count++;
                    break;
            }
        }

        return [$dia_count, $dia_group_count, $station_count, $train_count, $train_type_count];
    }
}
