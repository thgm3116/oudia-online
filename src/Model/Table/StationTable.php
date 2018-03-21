<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Station Model
 *
 * @property \App\Model\Table\DiaFilesTable|\Cake\ORM\Association\BelongsTo $DiaFiles
 *
 * @method \App\Model\Entity\Station get($primaryKey, $options = [])
 * @method \App\Model\Entity\Station newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Station[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Station|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Station patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Station[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Station findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StationTable extends Table
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

        $this->setTable('station');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('dia_file', [
            'foreignKey' => 'dia_file_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('scale')
            ->maxLength('scale', 255)
            ->requirePresence('scale', 'create')
            ->notEmpty('scale');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /**
     * @param array $categorised_contents_array
     *
     * @return \App\Model\Entity\Station
     */
    public function getEntityFromCategorisedContentsArray(array $categorised_contents_array)
    {
        $data = [
            'name' => $categorised_contents_array['Ekimei'],
            'type' => $categorised_contents_array['Ekijikokukeisiki'],
            'scale' => $categorised_contents_array['Ekikibo'],
            'dia_file_id' => $categorised_contents_array['dia_file_id'],
            'status' => self::STATUS_OPEN,
        ];

        return $this->newEntity($data);
    }
}
