<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataBase\DefaultConnection;
use PHPUnit\DbUnit\DataSet\FlatXmlDataSet;

class UserTest extends TestCase
{
    use TestCaseTrait;

    protected static $pdo;

    public function getConnection()
    {
        if(null === self::$pdo)
        {
            // set up Eloquent
            $capsule = new \Illuminate\Database\Capsule\Manager;
            $capsule->addConnection([
                'driver'    =>  'sqlite',
                'database'  =>  ':memory:'
            ]);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            // init user, get pdo
            $user = new App\Models\User();
            self::$pdo = $user->getConnection()->getPdo();

            // table
            self::$pdo->exec(
                'CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name VARCHAR(20)
                )'
            );

        }
        // return 
        return $this->createDefaultDBConnection(self::$pdo, 'sqlite');
    }

    public function getDataSet()
    {
        return $this->createFlatXmlDataSet(dirname(__FILE__).'/_fixtures/Initial.xml');
    }

    /**
     * @test
     */
    public function is_not_exploding()
    {
        $this->assertTrue(true);
    }


    /**
     * @test
     */
    public function initial()
    {
        $expected = $this->createFlatXmlDataSet(dirname(__FILE__).'/_fixtures/Initial.xml')
            ->getTable('users');
        $result = $this->getConnection()
            ->createQueryTable('users', 'SELECT * FROM users');
        $this->assertTablesEqual($expected, $result);
    }
}
