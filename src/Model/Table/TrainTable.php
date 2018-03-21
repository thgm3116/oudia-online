<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Train Model
 *
 * @property \App\Model\Table\TrainTypesTable|\Cake\ORM\Association\BelongsTo $TrainTypes
 * @property \App\Model\Table\DiaFilesTable|\Cake\ORM\Association\BelongsTo $DiaFiles
 *
 * @method \App\Model\Entity\Train get($primaryKey, $options = [])
 * @method \App\Model\Entity\Train newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Train[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Train|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Train patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Train[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Train findOrCreate($search, callable $callback = null, $options = [])
 */
class TrainTable extends Table
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

        $this->setTable('train');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('train_type', [
            'foreignKey' => 'train_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('dia_file', [
            'foreignKey' => 'dia_file_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('dia');
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
            ->scalar('distance')
            ->maxLength('distance', 6)
            ->requirePresence('distance', 'create')
            ->notEmpty('distance');

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
        //$rules->add($rules->existsIn(['train_type_id'], 'train_type'));
        $rules->add($rules->existsIn(['dia_file_id'], 'dia_file'));

        return $rules;
    }

    /**
     * @param array $categorised_contents_array
     * @return \App\Model\Entity\Train
     */
    public function getEntityFromCategorisedContentsArray(array $categorised_contents_array)
    {
        $train_type_array = $this->train_type->find('all')
            ->where([
                'dia_file_id' => $categorised_contents_array['dia_file_id'],
                'idInFile' => $categorised_contents_array['Syubetsu'],
            ])
            ->first()
            ->toArray();

        $data = [
            'identification_id' => (array_key_exists('Ressyabangou', $categorised_contents_array)) ?
                $categorised_contents_array['Ressyabangou'] :
                '',
            'train_type_id' => $train_type_array['id'],
            'distance' => $categorised_contents_array['Houkou'],
            'bikou' => (array_key_exists('Bikou', $categorised_contents_array)) ?
                $categorised_contents_array['Bikou'] :
                '',
            // 新規登録時にはまだdiaが登録されていないので、とりあえず0にする。
            'last_station_id' => 0,
            'dia_group_id' => $categorised_contents_array['dia_group_id'],
            'dia_file_id' => $categorised_contents_array['dia_file_id'],
            'status' => self::STATUS_OPEN,
        ];

        return $this->newEntity($data);
    }
}
