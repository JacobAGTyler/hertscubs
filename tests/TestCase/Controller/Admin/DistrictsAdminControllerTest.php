<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\DistrictsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Admin\Admin/DistrictsController Test Case
 */
class DistrictsAdminControllerTest extends IntegrationTestCase
{

    public $fixtures = [
        'app.districts',
        'app.auth_roles',
    ];

    public function testIndexUnauthenticatedFails()
    {
        // No session data set.
        $this->get('/admin/districts');

        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function testIndexUnauthorisedFails()
    {
        $this->session(['Auth.User.auth_role_id' => 1]);

        $this->get('/admin/districts');

        $this->assertResponseSuccess();

        $this->assertRedirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'user-home']);
    }



    public function testAddUnauthorisedFails()
    {
        $this->session(['Auth.User.auth_role_id' => 1]);

        $this->get('/admin/districts/add');

        $this->assertResponseSuccess();

        $this->assertRedirect(['prefix' => false, 'controller' => 'Landing', 'action' => 'user-home']);
    }

    public function testAddAuthorisedLoads()
    {
        $this->session(['Auth.User.auth_role_id' => 2]);

        $this->get('/admin/districts/add');

        $this->assertResponseSuccess();
    }
}
