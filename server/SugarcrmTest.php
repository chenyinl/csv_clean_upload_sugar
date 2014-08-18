<?php
require_once( "Sugarcrm.class.php" );

class SugarcrmTest extends PHPUnit_Framework_TestCase
{
    public function setUp(){ }

    public function tearDown(){ }

        public function testAdd_new_lead(){
            $this->sc = new Sugarcrm();
        $email = array(
            "steveSmith".rand(111, 999)."@one-k.com",
            "opt_out"=>"1"
        );
        $this->sc->addNew( 
            "steverr", //$first_name, 
            "smithrr", //$last_name, 
            "lead source form newspapaer", //$lead_source_description, 
            "status unknown", //$status_description, 
            $email, //$email, 
            "new", //$status, 
            $this->sc->user_id //$assigned_user_id
        );
        
        $this->lead_id = $this->sc->lead_id;
    }
/*
    public function testSearchById()
    {
        $sc = new Sugarcrm();
        $sc->login();
        //$sc->searchById( "3e89a65c-7b23-9ac6-549e-53cee90472bd" );
        $sc->searchById( "xxxxxx" );
    }

    public function testPackageUpdate()
    {
        $sc = new Sugarcrm();
        $sc->login();
        //$sc->search( "clin@one-k.com" );
        //var_dump($sc->lead_id);
        $r = $sc->updatePackagePurachsed( "xxxxxx", 2 );
        //var_dump( $r );

       
    }
*/



    /*
    public function testGetAllLead()
    {
        $sc = new Sugarcrm();
        $sc -> login();
        $sc->search( "clin@one-k.com" );
        //var_dump($sc -> getAllLead());
    }*/

    /*
    public function testLoginWorks()
    {
        $loginObj = new Sugarcrm();
        $loginObj -> login();
        $this->assertTrue($loginObj -> login());
    }
    public function testSearchTrue()
    {
        $loginObj = new Sugarcrm();
        $this->assertTrue($loginObj -> search("knichols@scs.k12.va.us"));
    }*/
    /*
    public function testSearchFalse()
    {
        $loginObj = new Sugarcrm();
        $this->assertFalse($loginObj -> search("clin321furhkfgikdenghctgsjdl@one-k.com"));
    }

    public function testAddNewAndUpdate()
    {
        $loginObj = new Sugarcrm();
        $this->assertTrue( $loginObj -> addNew(
            "UnitTest", 
            "UnitTest",
            "UTM_code",
            "2",
            "unittest@one-k.com", 
            "Assigned",
            NEWSLETTER_ID
        ));
        $this->assertEquals( 36, strlen($loginObj->user_id));
        $this->assertTrue( $loginObj -> updateLeadStatus( 
            $loginObj->user_id, 
            "In Process", 
            SUBSCRIBER_ID 
        ));
    }*/
}