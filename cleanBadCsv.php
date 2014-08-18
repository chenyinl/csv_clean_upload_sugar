#!/Applications/MAMP/bin/php/php5.4.10/bin/php
<?php
/*
 * usage: cleanBadCsv.php [file name] [file name]
 * A tool to generate CSV from an Exported CSV
 * This php takes two files, it will re-generate the second file without 
 * duplicates from itself and the first file.
 * The first file is "good (success)" csv without duplicates
 * The second file is "bad (failed)" csv with duplicates.
 * 
 * For example, the first file might have a, b, c, d
 * the second might have b, e, f, g, e, f, h
 * this script will not touch the original files and generate
 * a new file with e, f, g, h.
 *
 * This is for a particular project
 * 
 * 2014/8/18
 */

// check if the file exists
if( !isset($argv[1]) || !isset($argv[2]) ){
    echo "Missing file parameters.\nUsage:./countUniq.php Good.csv Bad.csv\n";
    die();
}
if( !is_file( $argv[1] ) ||!is_file( $argv[2] )){
    echo "Faile to open file\n";
    exit();
}

$filename = $argv[1];

// for test only
$maxrow = 10000;
if( isset( $argv[2] )){
    $maxrow = $argv[2];
}

// try to open file to read
try{
    if (($handle = fopen($filename, "r")) === FALSE) {
        echo "Faile to open file\n";
        exit();
    }
} catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$dataArray = array();
$headers = fgetcsv($handle, 1000, "\t"); //remove first row
$count=0;


while (( $tempData = fgetcsv($handle, 1000, "\t")) !== FALSE ) {
    list(
        $saffron_id,  
        $email, 
        $attributes,
        $active_window_id,
        $status
    ) = $tempData;
    if( $email == "NULL") continue;
    if( in_array( $email, $dataArray )) continue;
    $dataArray[]= $email;
    $count++;

    echo $count."\n";
    
}

fclose($handle);
$duplicate =0;
if(($handle2 = fopen($argv[2], "r")) === FALSE) {
    echo "Cannot open file 2 \n";
}
$cleanFilePath = "clean.".$argv[2];
$output = fopen( $cleanFilePath, "w");
//fputcsv( $output, $headers);
while (( $tempData = fgetcsv($handle2, 1000, "\t")) !== FALSE ) {
    list(
        $saffron_id,  
        $email, 
        $attributes
    ) = $tempData;
    if( $email == "NULL") continue;
    if( in_array( $email, $dataArray )) {
        // duplicated, echo out
        echo $email."\n";
        $duplicate++;
    }else{
        fputcsv( $output, $tempData, "\t");
        // save current email, avoid duplicate in the file
        $dataArray[]=$email;
    }
    //$dataArray[]= $email
    
}
fclose( $handle2 );
fclose( $output );
echo "total: ". $count."\n";
echo "duplicate: ". $duplicate."\n";
echo "Clean file at: ".$cleanFilePath."\n";
