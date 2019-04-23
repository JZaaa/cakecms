<?php
namespace Admin\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BannersFixture
 */
class SlidersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '轮播图', 'autoIncrement' => true, 'precision' => null],
        'tag' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '标签，用于区分组', 'precision' => null, 'fixed' => null],
        'pic' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '图片地址', 'precision' => null, 'fixed' => null],
        'url' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '跳转链接', 'precision' => null, 'fixed' => null],
        'title' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '标题', 'precision' => null, 'fixed' => null],
        'sub' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '描述', 'precision' => null, 'fixed' => null],
        'sort' => ['type' => 'tinyinteger', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '排序', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
                'tag' => 'Lorem ipsum dolor ',
                'pic' => 'Lorem ipsum dolor sit amet',
                'url' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'sub' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
                'created' => '2019-04-19 14:47:25'
            ],
        ];
        parent::init();
    }
}
