<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

require_once dirname(__FILE__) . "/../utils/MigrationUtil.php";

/**
 * Class UsersMigration_101
 */
class UsersMigration_101 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        $this->morphTable('users', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'name',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'region',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'name'
                        ]
                    ),
                    new Column(
                        'team',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'region'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'team'
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'created_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('name', ['name'], null)
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '1',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8mb4_general_ci'
                ],
            ]
        );

        // updated_atにON UPDATE CURRENT_TIMESTAMP
        self::$connection->execute("
ALTER TABLE users
MODIFY COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;");

        self::$connection->execute("INSERT INTO `users` (`name`, `region`, `team`, `created_at`, `updated_at`)
VALUES
	('test_1', 'jp', '1', '2019-03-17 11:27:56', '2019-03-17 11:27:56'),
	('test_2', 'us', '2', '2019-03-17 11:28:02', '2019-03-17 11:28:02');
");

//
//        // enumに修正(バグ)
//        self::$connection->execute("ALTER TABLE users MODIFY role enum('USER', 'FRANCHISE','CORPORATION','ADMIN') NOT NULL;");
//
//        // deleted_at追加
//        self::$connection->execute("
//ALTER TABLE users ADD deleted_at timestamp NULL DEFAULT NULL;
//");
//        self::$connection->execute("
//ALTER TABLE users ADD INDEX deleted_at(deleted_at);
//        ");

//        // マスターユーザーを登録
//        self::$connection->execute("
//INSERT INTO users (id, email, password, nearest_station_id, frequently_drinking_station_id, sex, payment_customer_token, payment_subscription_token, payment_cycle_anchor, date_of_birth, name, role, franchise_id, corporation_id, encrypted_id, created_at, updated_at, deleted_at) VALUES (1, 'admin@nomeru.com.test', '$2y$04\$dUtQa3U4Vmw5QlVqbGMye.h3mgTyfgLba6WbCLFTH97cV4qeYT64C', null, null, null, null, null, null, null, '山田 太郎', 'ADMIN', null, null, 'gfr45t6y7uujtgvf', '2018-08-07 21:30:22', '2018-08-08 00:14:55', null);
//");
//
//        if (!MigrationUtil::isProductionMode()) {
//            // @link https://olddocs.phalconphp.com/en/3.0.0/reference/db.html
//            self::$connection->execute("
//INSERT INTO users (id, email, password, nearest_station_id, frequently_drinking_station_id, sex, payment_customer_token, payment_subscription_token, payment_cycle_anchor, date_of_birth, name, role, franchise_id, corporation_id, encrypted_id, created_at, updated_at, deleted_at) VALUES (2, 'user@nomeru.com.test', '$2y$04\$dUtQa3U4Vmw5QlVqbGMye.h3mgTyfgLba6WbCLFTH97cV4qeYT64C', 3106, 3108, 2, 'test_hogehogehogehgeo', 'test_hogehogehogehgeo', 3, '1955-08-08', null, 'USER', null, null, 'qwertyuiopnbmvin', '2018-08-07 21:27:19', '2018-08-08 00:46:25', null);
//INSERT INTO users (id, email, password, nearest_station_id, frequently_drinking_station_id, sex, payment_customer_token, payment_subscription_token, payment_cycle_anchor, date_of_birth, name, role, franchise_id, corporation_id, encrypted_id, created_at, updated_at, deleted_at) VALUES (3, 'franchise@nomeru.com.test', '$2y$04\$dUtQa3U4Vmw5QlVqbGMye.h3mgTyfgLba6WbCLFTH97cV4qeYT64C', null, null, null, null, null, null, null, null, 'FRANCHISE', 1, null, 'zxcvbnmlp0aujdbg', '2018-08-07 21:28:38', '2018-08-08 00:14:55', null);
//INSERT INTO users (id, email, password, nearest_station_id, frequently_drinking_station_id, sex, payment_customer_token, payment_subscription_token, payment_cycle_anchor, date_of_birth, name, role, franchise_id, corporation_id, encrypted_id, created_at, updated_at, deleted_at) VALUES (4, 'corporation@nomeru.com.test', '$2y$04\$dUtQa3U4Vmw5QlVqbGMye.h3mgTyfgLba6WbCLFTH97cV4qeYT64C', null, null, null, null, null, null, null, null, 'CORPORATION', null, 1, '0i9u8y7t6rzjbnvf', '2018-08-07 21:28:59', '2018-08-08 00:14:55', null);
//INSERT INTO users (id, email, password, nearest_station_id, frequently_drinking_station_id, sex, payment_customer_token, payment_subscription_token, payment_cycle_anchor, date_of_birth, name, role, franchise_id, corporation_id, encrypted_id, created_at, updated_at, deleted_at) VALUES (5, 'user5@nomeru.com.test', '$2y$04\$dUtQa3U4Vmw5QlVqbGMye.h3mgTyfgLba6WbCLFTH97cV4qeYT64C', 3348, 3386, 1, 'test_hogehogehogehgeo', 'test_hogehogehogehgeo', 31, '1988-08-08', null, 'USER', null, null, 'qwertyuiopnbmvia', '2018-08-07 21:27:19', '2018-08-08 00:46:25', null);
//INSERT INTO users (id, email, password, nearest_station_id, frequently_drinking_station_id, sex, payment_customer_token, payment_subscription_token, payment_cycle_anchor, date_of_birth, name, role, franchise_id, corporation_id, encrypted_id, created_at, updated_at, deleted_at) VALUES (6, 'user6@nomeru.com.test', '$2y$04\$dUtQa3U4Vmw5QlVqbGMye.h3mgTyfgLba6WbCLFTH97cV4qeYT64C', 3398, 3408, 2, 'test_hogehogehogehgeo', 'test_hogehogehogehgeo', 30, '1950-12-12', null, 'USER', null, null, 'qwertyuiopnbmvib', '2018-08-07 21:27:19', '2018-08-08 00:46:25', null);
//INSERT INTO users (id, email, password, nearest_station_id, frequently_drinking_station_id, sex, payment_customer_token, payment_subscription_token, payment_cycle_anchor, date_of_birth, name, role, franchise_id, corporation_id, encrypted_id, created_at, updated_at, deleted_at) VALUES (7, 'user7@nomeru.com.test', '$2y$04\$dUtQa3U4Vmw5QlVqbGMye.h3mgTyfgLba6WbCLFTH97cV4qeYT64C', 3108, 3348, 0, 'test_hogehogehogehgeo', 'test_hogehogehogehgeo', 29, '1930-12-12', null, 'USER', null, null, 'qwertyuiopnbmvuy', '2018-08-07 21:27:19', '2018-08-08 00:46:25', null);
//        ");
//        }

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        self::$connection->dropTable('users');
    }

}
