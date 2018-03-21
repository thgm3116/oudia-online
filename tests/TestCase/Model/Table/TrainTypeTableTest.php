<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainTypeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainTypeTable Test Case
 */
class TrainTypeTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainTypeTable
     */
    public $TrainType;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.train_type',
        'app.dia_files'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TrainType') ? [] : ['className' => TrainTypeTable::class];
        $this->TrainType = TableRegistry::get('TrainType', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TrainType);

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
