<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * SiteMenu Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string|null $subname
 * @property string|null $pic
 * @property int $type
 * @property int $status
 * @property string|null $link
 * @property int $sort
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Admin\Model\Entity\ParentSiteMenu $parent_site_menu
 * @property \Admin\Model\Entity\Article[] $articles
 * @property \Admin\Model\Entity\ChildSiteMenu[] $child_site_menus
 */
class SiteMenu extends Entity
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
        'subname' => true,
        'pic' => true,
        'type' => true,
        'status' => true,
        'link' => true,
        'custom_url' => true,
        'list_tpl' => true,
        'content_tpl' => true,
        'sort' => true,
        'created' => true,
        'modified' => true,
        'parent_site_menu' => true,
        'articles' => true,
        'child_site_menus' => true
    ];
}
