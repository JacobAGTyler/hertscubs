<?php
namespace App\Test\TestCase\Controller;

use App\Controller\Admin\AllergiesController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Admin\AllergiesController Test Case
 */
class AllergiesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sessions',
        'app.districts',
        'app.scoutgroups',
        'app.section_types',
        'app.sections',
        'app.password_states',
        'app.auth_roles',
        'app.item_types',
        'app.roles',
        'app.users',
        'app.notification_types',
        'app.notifications',
        'app.application_statuses',
        'app.setting_types',
        'app.settings',
        'app.event_types',
        'app.event_statuses',
        'app.discounts',
        'app.events',
        'app.prices',
        'app.applications',
        'app.task_types',
        'app.tasks',
        'app.attendees',
        'app.applications_attendees',
        'app.allergies',
        'app.attendees_allergies',
        'app.reservation_statuses',
        'app.reservations',
    ];

    public function testIndexUnauthenticatedFails()
    {
        // No session data set.
        $this->get('/allergies');

        $this->assertRedirect(['controller' => 'Users', 'action' => 'login', 'redirect' => '/allergies']);
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->session([
            'Auth.User.id' => 1,
            'Auth.User.auth_role_id' => 1,
        ]);

        $this->get('/allergies');

        $this->assertResponseOk();
    }

    public function testIndexQueryData()
    {
        $this->session([
            'Auth.User.id' => 1,
            'Auth.User.auth_role_id' => 1,
        ]);

        $this->get('/allergies?page=1');

        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */

    public function testViewUnauthenticatedFails()
    {
        // No session data set.
        $this->get('/allergies/view/1');

        $this->assertRedirect(['controller' => 'Users', 'action' => 'login', 'redirect' => '/allergies/view/1']);
    }

    public function testView()
    {
        $this->session([
            'Auth.User.id' => 1,
            'Auth.User.auth_role_id' => 1,
        ]);

        $this->get('/allergies/view/1');

        $this->assertResponseOk();
    }

    public function testAddUnauthenticatedFails()
    {
        // No session data set.
        $this->get('/allergies/add');

        $this->assertRedirect(['controller' => 'Users', 'action' => 'login', 'redirect' => '/allergies/add']);
    }

    public function testAdd()
    {
        $this->session([
            'Auth.User.id' => 1,
            'Auth.User.auth_role_id' => 1,
        ]);

        $this->get('/allergies/add');

        $this->assertResponseOk();
    }

    public function testAddPostBadCsrf()
    {
        $this->session([
            'Auth.User.id' => 1,
            'Auth.User.auth_role_id' => 1,
        ]);

        $this->enableSecurityToken();

        $data = [
            'id' => 2,
            'allergy' => 'Test Me',
            'description' => 'This is a test Allergy'
        ];
        $this->post('/allergies/add', $data);

        $this->assertResponseError();
    }

    public function testAddPostGoodData()
    {
        $this->session([
            'Auth.User.id' => 1,
            'Auth.User.auth_role_id' => 2
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $postData = [
            'allergy' => 'I am a Test',
            'description' => 'This is a different test Allergy',
            'is_medical' => false,
            'is_dietary' => true,
        ];

        $this->post('/allergies/add', $postData);

        //$this->assertRedirect(['controller' => 'allergies', 'action' => 'index']);

        $articles = TableRegistry::get('Allergies');
        $query = $articles->find()->where(['allergy' => $postData['allergy']]);
        $this->assertEquals(1, $query->count());
    }

    public function testAddPostBadData()
    {
        $this->session([
            'Auth.User.id' => 1,
            'Auth.User.auth_role_id' => 1,
        ]);

        $data = [
            'id' => '4',
            'allergy' => null,
            'description' => null
        ];
        $this->post('/allergies', $data);

        $this->assertResponseError();
    }
}
