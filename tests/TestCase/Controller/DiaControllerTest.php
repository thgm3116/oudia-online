<?php
namespace App\Test\TestCase\Controller;

use App\Controller\DiaController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\DiaController Test Case
 */
class DiaControllerTest extends IntegrationTestCase
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

    /**
     * Test index method
     *
     * @test
     *
     * @return void
     */
    public function index_引数が何もなければフォームを正常に表示する()
    {
        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('<input type="file" name="diafile" required="required">');
        $this->assertResponseContains('<input type="submit" class="btn btn-default" value="Submit"/>');
    }
}
