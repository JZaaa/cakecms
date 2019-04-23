<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\SlidersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\BannersTable Test Case
 */
class SlidersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\SlidersTable
     */
    public $Banners;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Admin.Banners'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Banners') ? [] : ['className' => SlidersTable::class];
        $this->Banners = TableRegistry::getTableLocator()->get('Banners', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Banners);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
