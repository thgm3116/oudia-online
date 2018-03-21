<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Dia Model
 *
 * @property \App\Model\Table\StationTable|\Cake\ORM\Association\BelongsTo $station
 * @property \App\Model\Table\TrainTable|\Cake\ORM\Association\BelongsTo $train
 *
 * @method \App\Model\Entity\Dia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Dia newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Dia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Dia|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Dia[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Dia findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiaTable extends Table
{
    const STATUS_DELETED = 0;
    const STATUS_OPEN = 1;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('dia');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('station', [
            'foreignKey' => 'station_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('train', [
            'foreignKey' => 'train_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['station_id'], 'station'));
        $rules->add($rules->existsIn(['train_id'], 'train'));

        return $rules;
    }

    /**
     * @param array $dia
     * @param string $distance
     * @param int $train_id
     * @param int $dia_file_id
     * @return \App\Model\Entity\Dia
     */
    public function getEntities(array $dia, $distance, $train_id, $dia_file_id)
    {
        $station_array = $this->station->find('all', ['fields' => ['id', 'name']])
            ->where(['dia_file_id' => $dia_file_id])
            ->all()
            ->toArray();

        $sorted_station_array = $this->__getStationIdArray($station_array, $distance);

        $dia_array = [];
        foreach ($sorted_station_array as $key => $station) {
            $dia_array[$station->id] = (isset($dia[$key])) ? $dia[$key] : '';
        }
        
        foreach ($dia_array as $station_id => $dia) {
            // typeを分離する
            $type_splitted_dia = explode(';', $dia);
            if (isset($type_splitted_dia[1])) {
                $type = $type_splitted_dia[0];
                $dia = $type_splitted_dia[1];
            } else {
                $type = 0;
            }

            //departureTimeとarrivalTimeを分離する
            $departure_and_arrival_splitted_dia = explode('/', $dia);
            if (isset($departure_and_arrival_splitted_dia[1])) {
                $departureTime = $departure_and_arrival_splitted_dia[1];
                $arrivalTime = $departure_and_arrival_splitted_dia[0];
            } else {
                $departureTime = $dia;
                $arrivalTime = '';
            }

            // 始発駅のダイヤであれば、始発駅フラグを1にする
            $is_first_dia = 0;
            if (
                !empty($dia) && (
                    ($distance === 'Kudari' && empty($dia_array[$station_id - 1])) ||
                    ($distance === 'Nobori' && empty($dia_array[$station_id + 1]))
                )
            ) {
                $is_first_dia = 1;
            }

            // 終着駅のダイヤであれば、終着駅フラグを1にする
            $is_last_dia = 0;
            if (
                !empty($dia) && (
                    ($distance === 'Kudari' && empty($dia_array[$station_id + 1])) ||
                    ($distance === 'Nobori' && empty($dia_array[$station_id - 1]))
                )
            ) {
                $is_last_dia = 1;
            }

            $data[] = [
                'station_id' => $station_id,
                'train_id' => $train_id,
                'departureTime' => $departureTime,
                'arrivalTime' => $arrivalTime,
                'isFirstDia' => $is_first_dia,
                'isLastDia' => $is_last_dia,
                'type' => $type,
                'status' => self::STATUS_OPEN,
            ];
        }
        
        return $this->newEntities($data);
    }

    private function __getStationIdArray(array $station_array, $distance)
    {
        if ($distance === 'Nobori') {
            rsort($station_array);
        }

        return $station_array;
    }
}
