<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string|null $plugin
 * @property string $controller
 * @property string $action
 * @property string|null $params
 * @property string|null $url
 * @property int $sort
 *
 * @property \Admin\Model\Entity\ParentMenu $parent_menu
 * @property \Admin\Model\Entity\ChildMenu[] $child_menus
 */
class Menu extends Entity
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
        'name' => true,
        'plugin' => true,
        'controller' => true,
        'action' => true,
        'params' => true,
        'url' => true,
        'sort' => true,
        'parent_menu' => true,
        'child_menus' => true
    ];
}
