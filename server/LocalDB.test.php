<?php
require_once( "LocalDB.class.php" );

class LocalDBTest extends PHPUnit_Framework_TestCase
{
    public function setUp(){ }
    public function tearDown(){ }
    public function testGetData()
    {
        $db = new LocalDB();
        $this->assertTrue($db -> readDB());
        var_dump($db->data);
    }
    
   public function testInsertData()
    {
        $db = new LocalDB();
        
        $db->updateDB( "chenyin".rand(11,99)."@yahooxx.com", "x1xx-yzzzzy1y-xxxx1xxx");
        
    
    }
    /*
   public function testLookUpData()
    {
        $db = new LocalDB();
        $db -> readDB();
        $this->assertEquals( 
            "26efd84c-fcd7-04e4-a27d-53cdbf70fe8a", 
            $db->data["robin.e.edwards@comcast.net"]
        );
        $this->assertEquals( 
            "x1xx-yzzzzy1y-xxxx1xxx", 
            $db->data["chenyin59@yahooxx.com"]
        );
        

    }   */
}