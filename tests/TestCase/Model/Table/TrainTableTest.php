<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainTable Test Case
 */
class TrainTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainTable
     */
    public $Train;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.train',
        'app.identifications',
        'app.dias',
        'app.train_types',
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
        $config = TableRegistry::exists('Train') ? [] : ['className' => TrainTable::class];
        $this->Train = TableRegistry::get('Train', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Train);

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
