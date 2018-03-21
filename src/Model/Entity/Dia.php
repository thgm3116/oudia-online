<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dia Entity
 *
 * @property int $id
 * @property int $sation_id
 * @property int $train_id
 * @property string $departureTime
 * @property string $arrivalTime
 * @property int $type
 * @property int $isFirstDia
 * @property int $isLastDia
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $updated
 *
 * @property \App\Model\Entity\Station $station
 * @property \App\Model\Entity\Train $train
 */
class Dia extends Entity
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
        'station_id' => true,
        'train_id' => true,
        'departureTime' => true,
        'arrivalTime' => true,
        'isFirstDia' => true,
        'isLastDia' => true,
        'status' => true,
        'created' => true,
        'updated' => true,
    ];
}
