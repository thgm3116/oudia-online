<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Info Controller
 */
class InfoController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->set('title', 'Info' . self::TITLE_POSTFIX);
        $this->set('h1', 'Info');
        $this->set('is_dia_view_link_enabled', false);
    }
}
