<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property int $id
 * @property int $site_menu_id
 * @property string $title
 * @property string|null $color
 * @property string|null $subtitle
 * @property string|null $author
 * @property string|null $source
 * @property \Cake\I18n\FrozenTime|null $date
 * @property string|null $thmub
 * @property string|null $content
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property int $status
 * @property int $istop
 * @property int|null $visit
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \Admin\Model\Entity\SiteMenu $site_menu
 */
class Article extends Entity
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
        'site_menu_id' => true,
        'title' => true,
        'color' => true,
        'subtitle' => true,
        'abstract' => true,
        'author' => true,
        'source' => true,
        'date' => true,
        'thumb' => true,
        'content' => true,
        'seo_keywords' => true,
        'seo_description' => true,
        'status' => true,
        'istop' => true,
        'visit' => true,
        'created' => true,
        'modified' => true,
        'site_menu' => true
    ];
}
