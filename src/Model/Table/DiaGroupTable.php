<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DiaGroup Model
 *
 * @property \App\Model\Table\DiaFilesTable|\Cake\ORM\Association\BelongsTo $dia_file
 * @property \App\Model\Table\TrainTable|\Cake\ORM\Association\HasMany $train
 *
 * @method \App\Model\Entity\DiaGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\DiaGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DiaGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DiaGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DiaGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DiaGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DiaGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiaGroupTable extends Table
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

        $this->setTable('dia_group');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('dia_file', [
            'foreignKey' => 'dia_file_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('train', [
            'foreignKey' => 'dia_group_id'
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
        $rules->add($rules->existsIn(['dia_file_id'], 'dia_file'));

        return $rules;
    }

    /**
     * @param int $dia_file_id
     * @param string $name
     *
     * @return \App\Model\Entity\DiaGroup
     */
    public function getEntity($dia_file_id, $name)
    {
        $data = [
            'dia_file_id' => $dia_file_id,
            'name' => $name,
            'status' => self::STATUS_OPEN,
        ];

        return $this->newEntity($data);
    }
    
    /**
     * @param int $id
     * @return array
     */
    public function getDiaGroup($id)
    {
        if (empty($id)) {
            return [];
        }
        
        return $this->find()
            ->contain('dia_file')
            ->where(['DiaGroup.id' => $id])
            ->last()
            ->toArray();
    }
}
