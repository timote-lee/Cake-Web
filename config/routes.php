<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
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

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
 * So you can use `$this` to reference the application class instance
 * if required.
 */
return function (RouteBuilder $routes): void 
{
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/',  ['prefix' => 'Auth', 'controller' => 'Login'], function(RouteBuilder $routes)
    {
        $routes->get('/', ['action' => 'showLoginForm'], 'login.form');

        $routes->post('/login', ['action' => 'login'], 'login');
        $routes->post('/logout', ['action' => 'logout'], 'logout');
    });

    $routes->scope('/register',  ['prefix' => 'Auth', 'controller' => 'Register'], function(RouteBuilder $routes)
    {
        $routes->get('/', ['action' => 'showRegisterForm'], 'register.form');

        $routes->post('/', ['action' => 'register'], 'register');
    });

    $routes->scope('/email',  ['prefix' => 'Auth', 'controller' => 'Email'], function(RouteBuilder $routes)
    {
        $routes->post('/send', ['action' => 'send'], 'email.send');
    });

    $routes->scope('/me', ['controller' => 'Users'],  function(RouteBuilder $routes)
    {
        $routes->get('/', ['action' => 'show'], 'users.show');
        $routes->get('/edit', ['action' => 'edit'], 'users.edit');
        $routes->get('/password', ['action' => 'changePassword'], 'users.password');

        $routes->post('/update', ['action' => 'update'], 'users.update');
        $routes->post('/password/update', ['action' => 'updatePassword'], 'users.password.update');
    }); 

    $routes->get('/home', ['controller' => 'Home', 'action' => 'index'], 'home');
};
