<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TokensFixture
 */
class TokensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
//        'token' => ['type' => 'string', 'length' => 511, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
//        'user_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
//        'email_send_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'expires' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'utilised' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
//        'active' => ['type' => 'boolean', 'length' => null, 'default' => 1, 'null' => false, 'comment' => null, 'precision' => null],
        'deleted' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
//        'hash' => ['type' => 'string', 'length' => 511, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
//        'random_number' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
//        'header' => ['type' => 'jsonb', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
//        '_indexes' => [
//            'tokens_user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
//            'tokens_email_send_id' => ['type' => 'index', 'columns' => ['email_send_id'], 'length' => []],
//        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
//            'tokens_email_send_id' => ['type' => 'foreign', 'columns' => ['email_send_id'], 'references' => ['email_sends', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
//            'tokens_user_id' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
//                'token' => 'Lorem ipsum dolor sit amet',
//                'user_id' => 1,
//                'email_send_id' => 1,
                'created' => 1554766740,
                'modified' => 1554766740,
                'expires' => 1554766740,
                'utilised' => 1554766740,
//                'active' => true,
                'deleted' => null,
//                'hash' => 'Lorem ipsum dolor sit amet',
//                'random_number' => 1789,
//                'header' => ''
            ],
        ];
        parent::init();
    }
}
