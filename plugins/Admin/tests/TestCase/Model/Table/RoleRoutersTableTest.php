<?php
namespace Admin\Test\TestCase\Model\Table;

use Admin\Model\Table\RoleRoutersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Admin\Model\Table\RoleRoutersTable Test Case
 */
class RoleRoutersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Admin\Model\Table\RoleRoutersTable
     */
    public $RoleRouters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Admin.RoleRouters',
        'plugin.Admin.Roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RoleRouters') ? [] : ['className' => RoleRoutersTable::class];
        $this->RoleRouters = TableRegistry::getTableLocator()->get('RoleRouters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RoleRouters);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
