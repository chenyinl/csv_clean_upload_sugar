<?php

class LocalDB
{
    public $file_path = "db.csv";
    public $data = array();
    public function readDB()
    {
        ini_set("auto_detect_line_endings", "1");
        if (($handle = fopen($this->file_path, "r")) == FALSE) {
            return false;
        }
        
        $count=0;
        while ( ($tempData = fgetcsv($handle, 1000, ",")) !== FALSE  ) {
            $num = count($tempData);
          
            
            list( $id, $email ) =$tempData;
            
            $this->data[ $email ] = $id;
        }
        return true;
    }
    public function updateDB( $email, $id)
    {
        if(!$id) return false;
        //ini_set("auto_detect_line_endings", "1");
        if (($handle = fopen($this->file_path, "a")) == FALSE) {
            return false;
        }
        $dataArray = array( $id, $email);

        fputcsv( $handle, $dataArray);

        fclose($handle);
        return true;
    }
}