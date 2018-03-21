<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiaTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiaTable Test Case
 */
class DiaTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DiaTable
     */
    public $Dia;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dia',
        'app.station',
        'app.train'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Dia') ? [] : ['className' => DiaTable::class];
        $this->Dia = TableRegistry::get('Dia', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dia);

        parent::tearDown();
    }
}
