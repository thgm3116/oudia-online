<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DiaGroup Entity
 *
 * @property int $id
 * @property int $dia_file_id
 * @property string $name
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $updated
 *
 * @property \App\Model\Entity\DiaFile $dia_file
 * @property \App\Model\Entity\Train[] $train
 */
class DiaGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'dia_file_id' => true,
        'name' => true,
        'status' => true,
        'created' => true,
        'updated' => true
    ];
}
