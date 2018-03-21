<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiaFileTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiaFileTable Test Case
 */
class DiaFileTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DiaFileTable
     */
    public $DiaFile;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dia_file'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DiaFile') ? [] : ['className' => DiaFileTable::class];
        $this->DiaFile = TableRegistry::get('DiaFile', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DiaFile);

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
