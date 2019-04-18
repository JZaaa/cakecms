<?php
namespace Admin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoutersFixture
 */
class RoutersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '路由表', 'autoIncrement' => true, 'precision' => null],
        'parent_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '父id', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '名称', 'precision' => null, 'fixed' => null],
        'router' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '路由,Plugin.Model.Action', 'precision' => null, 'fixed' => null],
        'sort' => ['type' => 'tinyinteger', 'length' => 2, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '排序', 'precision' => null],
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
                'name' => 'Lorem ipsum dolor ',
                'router' => 'Lorem ipsum dolor sit amet',
                'sort' => 1
            ],
        ];
        parent::init();
    }
}
