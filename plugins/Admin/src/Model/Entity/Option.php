<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Option Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string $key_field
 * @property string|null $value_field
 * @property string $group
 */
class Option extends Entity
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
        'key_field' => true,
        'value_field' => true,
        'tag' => true
    ];
}
