<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Scoutgroup;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\ModelLevel\Table\ScoutgroupsTable Test Case
 */
class ScoutgroupsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScoutgroupsTable
     */
    public $Scoutgroups;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.scoutgroups',
        'app.districts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Scoutgroups') ? [] : ['className' => 'App\Model\Table\ScoutgroupsTable'];
        $this->Scoutgroups = TableRegistry::get('Scoutgroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Scoutgroups);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $query = $this->Scoutgroups->find('all');

        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray();
        $expected = [
            [
                'id' => 1,
                'scoutgroup' => '12th Letchworth',
                'district_id' => 1,
                'number_stripped' => 1,
                'deleted' => null
            ],
            [
                'id' => 2,
                'scoutgroup' => '4th Octopus',
                'district_id' => 2,
                'number_stripped' => 4,
                'deleted' => null
            ],
            [
                'id' => 3,
                'scoutgroup' => '1st Llamaland',
                'district_id' => 1,
                'number_stripped' => 1,
                'deleted' => null
            ],
            [
                'id' => 4,
                'scoutgroup' => '11th Goatface',
                'district_id' => 2,
                'number_stripped' => 11,
                'deleted' => null
            ],
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $badData = [
            'id' => 5,
            'scoutgroup' => null,
            'district_id' => 2,
            'number_stripped' => 1,
            'deleted' => null
        ];

        $goodData = [
            'scoutgroup' => 'Lorem ipsum monkey aorumn amet',
            'district_id' => 1,
            'number_stripped' => 1,
            'deleted' => null
        ];

        $expected = [
            [
                'id' => 1,
                'scoutgroup' => '12th Letchworth',
                'district_id' => 1,
                'number_stripped' => 1,
                'deleted' => null
            ],
            [
                'id' => 2,
                'scoutgroup' => '4th Octopus',
                'district_id' => 2,
                'number_stripped' => 4,
                'deleted' => null
            ],
            [
                'id' => 3,
                'scoutgroup' => '1st Llamaland',
                'district_id' => 1,
                'number_stripped' => 1,
                'deleted' => null
            ],
            [
                'id' => 4,
                'scoutgroup' => '11th Goatface',
                'district_id' => 2,
                'number_stripped' => 11,
                'deleted' => null
            ],
            [
                'id' => 5,
                'scoutgroup' => 'Lorem ipsum monkey aorumn amet',
                'district_id' => 1,
                'number_stripped' => 1,
                'deleted' => null
            ],
        ];

        $badEntity = $this->Scoutgroups->newEntity($badData, ['accessibleFields' => ['id' => true]]);
        $goodEntity = $this->Scoutgroups->newEntity($goodData, ['accessibleFields' => ['id' => true]]);

        $this->assertFalse($this->Scoutgroups->save($badEntity));
        $this->assertInstanceOf(Scoutgroup::class, $this->Scoutgroups->save($goodEntity));

        $query = $this->Scoutgroups->find('all');

        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray();

        $this->assertEquals($expected, $result);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $badData = [
            'id' => 5,
            'scoutgroup' => 'Lorem ipsum monkey aorumn amet',
            'district_id' => 4,
            'number_stripped' => 1,
            'deleted' => null
        ];

        $goodData = [
            'scoutgroup' => 'Lorem ipsum monkey aorumn amet',
            'district_id' => 1,
            'number_stripped' => 1,
            'deleted' => null
        ];

        $expected = [
            [
                'id' => 1,
                'scoutgroup' => '12th Letchworth',
                'district_id' => 1,
                'number_stripped' => 1,
                'deleted' => null
            ],
            [
                'id' => 2,
                'scoutgroup' => '4th Octopus',
                'district_id' => 2,
                'number_stripped' => 4,
                'deleted' => null
            ],
            [
                'id' => 3,
                'scoutgroup' => '1st Llamaland',
                'district_id' => 1,
                'number_stripped' => 1,
                'deleted' => null
            ],
            [
                'id' => 4,
                'scoutgroup' => '11th Goatface',
                'district_id' => 2,
                'number_stripped' => 11,
                'deleted' => null
            ],
            [
                'id' => 5,
                'scoutgroup' => 'Lorem ipsum monkey aorumn amet',
                'district_id' => 1,
                'number_stripped' => 1,
                'deleted' => null
            ],
        ];

        $badEntity = $this->Scoutgroups->newEntity($badData);
        $goodEntity = $this->Scoutgroups->newEntity($goodData);

        $this->assertFalse($this->Scoutgroups->save($badEntity));
        $this->assertInstanceOf(Scoutgroup::class, $this->Scoutgroups->save($goodEntity));

        $query = $this->Scoutgroups->find('all');

        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->enableHydration(false)->toArray();

        $this->assertEquals($expected, $result);
    }
}
