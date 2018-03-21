<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TrainType Entity
 *
 * @property int $id
 * @property string $name
 * @property string $shortName
 * @property string $timetableColor
 * @property string $timetableFont
 * @property int $dia_file_id
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $update
 *
 * @property \App\Model\Entity\DiaFile $dia_file
 */
class TrainType extends Entity
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
        'name' => true,
        'shortName' => true,
        'timetableColor' => true,
        'timetableFont' => true,
        'idInFile' => true,
        'dia_file_id' => true,
        'status' => true,
        'created' => true,
        'update' => true,
    ];
}
