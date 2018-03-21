<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StationTable Test Case
 */
class StationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StationTable
     */
    public $Station;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.station',
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
        $config = TableRegistry::exists('Station') ? [] : ['className' => StationTable::class];
        $this->Station = TableRegistry::get('Station', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Station);

        parent::tearDown();
    }

    /**
     * @test
     *
     * @return void
     */
    public function getEntityFromCategorisedContentsArray_カテゴリ別にされた配列を渡すとStationEntityを返す()
    {
        $categorized_contents_array = [
            'Ekimei' => '川越市',
            'Ekijikokukeisiki' => 'Jikokukeisiki_Hatsuchaku',
            'Ekikibo' => 'Ekikibo_Syuyou',
            'dia_file_id' => 1,
        ];

        $entity = $this->Station->getEntityFromCategorisedContentsArray($categorized_contents_array);

        $this->assertSame('App\Model\Entity\Station', get_class($entity));
    }

}
