<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize'=> 'Controller',
            'loginRedirect' => [
                'controller' => 'applications',
                'action' => 'view'
                ],
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                        ]
                    ]
                ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
                ]
        ]);

        // Allow the display action so our pages controller
        // continues to work.
        $this->Auth->allow(['display']);
    }

/**
*    public function initialize()
*{
*    $this->loadComponent('Flash');
*    $this->loadComponent('Auth', [
*        'authorize' => ['Controller'], // Added this line
*        'loginRedirect' => [
*            'controller' => 'Articles',
*            'action' => 'index'
*        ],
*        'logoutRedirect' => [
*            'controller' => 'Pages',
*            'action' => 'display',
*            'home'
*        ]
*    ]);
*}
**/

    public function isAuthorized($user)
    {
        // Admin can access every action
        if (isset($user['admin']) && $user['admin'] === 1) {
            return true;
        }

        $action = $this->request->params['action'];

        // The add and index actions are always allowed.
        //if (in_array($action, ['add'])) {
        //    return true;
        //}

        //Alternate Method
        //if ($this->request->action === 'add') {
        //        return true;
        //    }

        // All other actions require an id.
        if (empty($this->request->params['pass'][0])) {
            return true;
        }

        //return parent::isAuthorized($user);

        return false;
    }
}


