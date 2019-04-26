<?php
namespace Admin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SiteMenusFixture
 */
class SiteMenusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'site_menus';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '网站栏目表', 'autoIncrement' => true, 'precision' => null],
        'parent_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '栏目名称', 'precision' => null, 'fixed' => null],
        'subname' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '别名', 'precision' => null, 'fixed' => null],
        'pic' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'banner图', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'tinyinteger', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '类型,1:单页, 2:列表', 'precision' => null],
        'status' => ['type' => 'tinyinteger', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '状态,1:显示，2:隐藏', 'precision' => null],
        'link' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '外链', 'precision' => null, 'fixed' => null],
        'sort' => ['type' => 'tinyinteger', 'length' => 2, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '排序', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'parent_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'subname' => 'Lorem ipsum dolor sit amet',
                'pic' => 'Lorem ipsum dolor sit amet',
                'type' => 1,
                'status' => 1,
                'link' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
                'created' => '2019-04-23 13:53:39',
                'modified' => '2019-04-23 13:53:39'
            ],
        ];
        parent::init();
    }
}
