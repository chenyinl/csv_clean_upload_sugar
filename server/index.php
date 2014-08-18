<?php
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( -1 );

if (ob_get_level() == 0) ob_start();
if(isset($_FILES["file"])){
    $planCount=array();
    $planCount[0]=0;
    $planCount[1]=0;
    $planCount[2]=0;
    $planCount[3]=0;
    include_once( "Sugarcrm.class.php" );
    include_once( "LocalDB.class.php" );
    if( $_POST["success"]=="success"){
        $success = true;
    }else{
        $success = false;
    }

    if ($_FILES["file"]["error"] > 0) {
      //echo "Error: " . $_FILES["file"]["error"] . "<br>";
    } else {
      //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
      //echo "Type: " . $_FILES["file"]["type"] . "<br>";
      //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
      //echo "Stored in: " . $_FILES["file"]["tmp_name"];
    }

    ini_set("auto_detect_line_endings", "1");
    if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {

        $row =1;
        if(isset($_POST["limit"]) && is_numeric($_POST["limit"])){
            $max = $_POST["limit"];
        }else{
            $max = 10000;
        }
        
        $sc = new Sugarcrm();
        //$sc -> login();

        $count = 0;
        //$data = fgetcsv($handle, 1000, ",");

        $rowData = fgetcsv($handle, 1000, "\t"); //remove first line
        $sc = new Sugarcrm();
        $sc->login();
        // use local database
        $db = new LocalDB();
        $db -> readDB();
        $localData = $db->data;

        while (( $tempData = fgetcsv($handle, 1000, "\t")) !== FALSE && $count++ < $max) {
            if(!($tempData[0])) continue;
            list(
                $saffron_id,  
                $email,
                $attributes,
                $window_id,
                $status
            ) = $tempData;
            

            //$saffron_id = str_replace("\n", "", $saffron_id);
            $attributes = json_decode($attributes);

            //$utm = $attributes->utm_campaign;
            if( $success){
                switch( $window_id ){
                    case ( "d611a7e7-a767-4bc3-9bfa-65dc079e0f57" ):
                        $plan = 1;
                        $planCount[1]++;
                        break;
                    case ( "da320f02-2d56-4833-b0c7-b1d1fbc01a53" ):
                        $plan = 2;
                        $planCount[2]++;
                        break;
                    case ( "ac882d72-e89d-4cc8-bea3-7536b7539551" ):
                        $plan = 3;
                        $planCount[3]++;
                        break;
                }
                // not pulling from attribute
                //$plan = $attributes->price_selection;
            } else {
                $plan = 0;
                $planCount[0]++;
            }
            //$last_name = $attributes->last_name;
            if( isset( $attributes->crm_id )){
                // if crm id is in resource CSV
                $lead_id = $attributes->crm_id;
                $source = "source file";
            }else{

                if( isset( $localData[$email] )){
                    // if crm id is in local database
                    $lead_id =  $localData[$email];
                    $source = "local DB";
                } else {
                    // look for crm id in crm server by email
                    $sc->search( $email );
                    //$sc->lead_id = "xx";
                    $source = "server";
                    $db -> updateDB( $email, $sc->lead_id);
                    $lead_id = $sc->lead_id;
                }
            }
            
            $sc->updatePackagePurachsed( $lead_id, $plan );
            echo $row.". Update ". $email." - ".$lead_id." with plan ".$plan." CRM id: ".$source."<br/>";
            ob_flush();
            flush();
            $row++;   
        }
        fclose( $handle );
        echo "<br/>";
        for( $i=0; $i<4; $i++){
            echo "Plan ".$i." has ".$planCount[$i]." subscribers<br/>";
        }
    }
return;
}
?>
<html>
<body>
<p>v2.2</p>
Upload your CSV file here.<br/>
Bad Sub first
<form action="" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="radio" name="success" value="success" checked>Success
<input type="radio" name="success" value="failed">Failed<br>
Limit of row: <input type="text" name="limit" id="limit"><br>
<input type="submit" name="submit" value="Process">
</form>
</body>
</html>