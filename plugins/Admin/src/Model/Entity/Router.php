<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Router Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property string|null $name
 * @property string $router
 * @property int $sort
 *
 * @property \Admin\Model\Entity\ParentRouter $parent_router
 * @property \Admin\Model\Entity\ChildRouter[] $child_routers
 */
class Router extends Entity
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
        'parent_id' => true,
        'level' => true,
        'name' => true,
        'router' => true,
        'sort' => true,
        'parent_router' => true,
        'child_routers' => true
    ];
}
