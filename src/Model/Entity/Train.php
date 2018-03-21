<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Train Entity
 *
 * @property int $id
 * @property string $identification_id
 * @property int $train_type_id
 * @property string $distance
 * @property string $bikou
 * @property int $dia_group_id
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $Created
 * @property \Cake\I18n\FrozenTime $updated
 */
class Train extends Entity
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
        'identification_id' => true,
        'train_type_id' => true,
        'distance' => true,
        'bikou' => true,
        'dia_group_id' => true,
        'status' => true,
        'created' => true,
        'updated' => true,
    ];
}
