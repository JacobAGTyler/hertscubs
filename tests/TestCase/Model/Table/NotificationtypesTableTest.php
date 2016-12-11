<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotificationtypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotificationtypesTable Test Case
 */
class NotificationtypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NotificationtypesTable
     */
    public $Notificationtypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.notificationtypes',
        'app.notifications',
        'app.users',
        'app.roles',
        'app.attendees',
        'app.scoutgroups',
        'app.districts',
        'app.champions',
        'app.applications',
        'app.events',
        'app.settings',
        'app.settingtypes',
        'app.discounts',
        'app.logistics',
        'app.parameters',
        'app.parameter_sets',
        'app.params',
        'app.logistic_items',
        'app.invoices',
        'app.invoice_items',
        'app.itemtypes',
        'app.notes',
        'app.payments',
        'app.invoices_payments',
        'app.applications_attendees',
        'app.allergies',
        'app.attendees_allergies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Notificationtypes') ? [] : ['className' => 'App\Model\Table\NotificationtypesTable'];
        $this->Notificationtypes = TableRegistry::get('Notificationtypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Notificationtypes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}