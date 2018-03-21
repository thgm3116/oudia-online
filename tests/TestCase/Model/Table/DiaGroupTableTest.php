<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiaGroupTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiaGroupTable Test Case
 */
class DiaGroupTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DiaGroupTable
     */
    public $DiaGroup;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dia_group',
        'app.dia_file',
        'app.train',
        'app.train_type',
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
        $config = TableRegistry::exists('DiaGroup') ? [] : ['className' => DiaGroupTable::class];
        $this->DiaGroup = TableRegistry::get('DiaGroup', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DiaGroup);

        parent::tearDown();
    }

    /**
     * @test
     *
     * @return void
     */
    public function getEntity_dia_file_idとnameを与えるとDiaGroupEntityを返す()
    {
        $dia_file_id = 1;
        $name = '平日';
        $entity = $this->DiaGroup->getEntity($dia_file_id, $name);

        $this->assertSame('App\Model\Entity\DiaGroup', get_class($entity));
    }
}
