<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TrainType Model
 *
 * @property \App\Model\Table\DiaFilesTable|\Cake\ORM\Association\BelongsTo $DiaFiles
 *
 * @method \App\Model\Entity\TrainType get($primaryKey, $options = [])
 * @method \App\Model\Entity\TrainType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TrainType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TrainType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrainType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TrainType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TrainType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TrainTypeTable extends Table
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

        $this->setTable('train_type');
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
            ->scalar('timetableColor')
            ->maxLength('timetableColor', 255)
            ->requirePresence('timetableColor', 'create')
            ->notEmpty('timetableColor');

        $validator
            ->scalar('timetableFont')
            ->maxLength('timetableFont', 255)
            ->requirePresence('timetableFont', 'create')
            ->notEmpty('timetableFont');

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
     * @param array $categorised_contents_array
     * @return \App\Model\Entity\TrainType
     */
    public function getEntityFromCategorisedContentsArray(array $categorised_contents_array)
    {
        $data = [
            'name' => $categorised_contents_array['Syubetsumei'],
            'shortName' => (isset($categorised_contents_array['Ryakusyou'])) ? $categorised_contents_array['Ryakusyou'] : '',
            'timetableColor' => $categorised_contents_array['JikokuhyouMojiColor'],
            'timetableFont' => $categorised_contents_array['JikokuhyouFontIndex'],
            'idInFile' => $categorised_contents_array['idInFile'],
            'dia_file_id' => $categorised_contents_array['dia_file_id'],
            'status' => self::STATUS_OPEN,
        ];

        return $this->newEntity($data);
    }
}
