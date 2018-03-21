<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Dia', 'action' => 'index']);

    $routes->connect(
        '/dia/diagroup_:dia_group_id/:distance/station_:station_id',
        ['controller' => 'Dia', 'action' => 'viewStation'],
        ['dia_group_id' => '\d+', 'distance' => '.*', 'station_id' => '\d+']
    );
    $routes->connect(
        '/dia/diagroup_:dia_group_id/:distance/train_:train_id',
        ['controller' => 'Dia', 'action' => 'viewTrain'],
        ['dia_group_id' => '\d+', 'distance' => '.*', 'train_id' => '\d+']
    );
    $routes->connect(
        '/dia/diagroup_:dia_group_id/:distance',
        ['controller' => 'Dia', 'action' => 'viewDefault'],
        ['dia_group_id' => '\d+', 'distance' => '.*']
    );

    $routes->connect('/search', ['controller' => 'Search', 'action' => 'index']);

    $routes->connect('/info', ['controller' => 'Info', 'action' => 'index']);

    $routes->fallbacks(DashedRoute::class);
});

Plugin::routes();
