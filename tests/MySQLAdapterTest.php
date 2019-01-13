<?php

use Pollus\DatabaseSessionHandler\Adapters\MySQLAdapter;

class MySQLAdapterTest extends \PHPUnit\Framework\TestCase
{ 
    /**
     * @var MySQLAdapter
     */
    protected $adapter;
    
    /**
     * @var PDO
     */
    protected $pdo;
    
    protected function setUp()
    {
        require_once(__DIR__."/Helpers/Connection.php");
        $this->pdo = Connection::get();
        
        // Locking is not supported on SQLITE
        $this->adapter = new MySQLAdapter($this->pdo, false);
    }
    
    public function testInsertAndUpdate()
    {
        $this->adapter->save("abc", "this is a invalid session data");
        $this->adapter->save("abc", "this is a invalid session data");
        $this->adapter->save("abc", "this is a invalid session data");
        $result = $this->pdo->query("SELECT * FROM sessions WHERE id = 'abc'")->fetchAll(\PDO::FETCH_ASSOC);
        $this->assertSame(1, count($result ?? []));
        $this->assertSame("abc", $result[0]["id"] ?? null);
    }
    
    /**
     * @depends testInsertAndUpdate
     */
    public function testDelete()
    {
        $this->adapter->save("deleteme", "this is a invalid session data");
        $this->adapter->delete("deleteme");
        $result = $this->pdo->query("SELECT * FROM sessions WHERE id = 'deleteme'")->fetchAll(\PDO::FETCH_ASSOC);
        $this->assertSame(0, count($result));
    }
    
    /**
     * @depends testDelete
     */
    public function testSelect()
    {
        $this->adapter->save("selectme", "compare me");
        $result = $this->adapter->select("selectme", 600);
        $this->assertSame("compare me", $result);
        sleep(2);
        $result = $this->adapter->select("selectme", 1);
        $this->assertSame(null, $result);
    }
    
    /**
     * @depends testSelect
     */
    public function testGc()
    {
        $this->adapter->save("eraseme", "junk");
        sleep(4);
        $this->adapter->save("donteraseme", "not junk");
        $this->adapter->gc(2);
        $result = $this->adapter->select("donteraseme", 600);
        $this->assertSame("not junk", $result);
    }
}
