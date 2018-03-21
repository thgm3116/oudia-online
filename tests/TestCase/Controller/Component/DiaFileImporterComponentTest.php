<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\DiaFileImporterComponent;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\DiaFileImporterComponent Test Case
 */
class DiaFileImporterComponentTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dia',
        'app.station',
        'app.dia_file',
        'app.dia_group',
        'app.train',
        'app.train_type'
    ];

    /** @var  */
    private $__dia;
    /** @var  */
    private $__dia_file;
    /** @var  */
    private $__dia_group;
    /** @var  */
    private $__station;
    /** @var  */
    private $__train;
    /** @var  */
    private $__train_type;

    /**
     * Test subject
     *
     * @var \App\Controller\Component\DiaFileImporterComponent
     */
    public $DiaFileImporter;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->DiaFileImporter = new DiaFileImporterComponent($registry);

        $this->__dia = TableRegistry::get('dia');
        $this->__dia_file = TableRegistry::get('dia_file');
        $this->__dia_group = TableRegistry::get('dia_group');
        $this->__station = TableRegistry::get('station');
        $this->__train = TableRegistry::get('train');
        $this->__train_type = TableRegistry::get('train_type');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->__dia);
        unset($this->__dia_file);
        unset($this->__dia_group);
        unset($this->__station);
        unset($this->__train);
        unset($this->__train_type);
        unset($this->DiaFileImporter);

        parent::tearDown();
    }

    /**
     * @return void
     */
    private function __importSampleFile()
    {
        return $this->DiaFileImporter->import(TESTS . 'TestCase/Controller/Component/sample.oud', 'sample.oud');
    }

    /**
     * @test
     *
     * @return void
     */
    public function import_フォーマットの誤っていないoudファイルをエラー無く読み込める()
    {
        $result = $this->__importSampleFile();
        // エラー無くreturnされればOKとするので、returnのカウント配列がちゃんと帰ってきてればOKとする。
        $this->assertSame(5, count($result));
    }

    /**
     * @test
     *
     * @return void
     */
    public function import_dia_fileを正常に登録できているか()
    {
        $this->__importSampleFile();

        // dia_fileを正常に登録できているか
        $filename = 'sample.oud';
        $dia_file = $this->__dia_file->find()->where(['id' => 2, 'filename' => $filename])->select(['id', 'filename'])->last();
        $this->assertSame(2, $dia_file->id);
        $this->assertSame($filename, $dia_file->filename);
    }

    /**
     * @test
     *
     * @return void
     */
    public function import_dia_groupを正常に登録できているか()
    {
        $this->__importSampleFile();

        // dia_groupを正常に登録できているか
        $dia_group = $this->__dia_group->find()->select(['id'])->all();
        // fixtureでデフォルト1件にファイルで2件の合計3件になってるはず
        $this->assertSame(3, $dia_group->count());
    }

    /**
     * @test
     *
     * @return void
     */
    public function import_stationを正常に登録できているか()
    {
        $this->__importSampleFile();

        // stationを正常に登録できているか
        $station = $this->__station->find()->select(['id'])->all();
        // fixtureでデフォルト1件にファイルで5件の合計6件になってるはず
        $this->assertSame(6, $station->count());
    }

    /**
     * @test
     *
     * @return void
     */
    public function import_diaを正常に登録できているか()
    {
        $this->__importSampleFile();

        // diaを正常に登録できているか
        $station = $this->__dia->find()->select(['id'])->all();
        // fixtureでデフォルト1件にファイルで24件の合計25件になってるはず
        $this->assertSame(31, $station->count());
    }

    /**
     * @test
     *
     * @return void
     */
    public function import_trainを正常に登録できているか()
    {
        $this->__importSampleFile();

        // trainを正常に登録できているか
        $train = $this->__train->find()->select(['id'])->all();
        // fixtureでデフォルト1件にファイルで6件の合計7件になってるはず
        $this->assertSame(7, $train->count());
    }

    /**
     * @test
     *
     * @return void
     */
    public function import_train_typeを正常に登録できているか()
    {
        $this->__importSampleFile();

        // trainを正常に登録できているか
        $train_type = $this->__train_type->find()->select(['id'])->all();
        // fixtureでデフォルト1件にファイルで5件の合計6件になってるはず
        $this->assertSame(6, $train_type->count());
    }

}
