<?php

date_default_timezone_set('America/New_York'); 

$date = date('Y_m_d_H');

######################################################## Writing and Outputting data into a new CSV file ########################################################

$file = file("old/sensordata_2018_10_01_00.csv");  
$masterme = fopen(dirname(__FILE__) . "/new/sensordata_$date.csv", "w+");  

$csv_data = array_map('str_getcsv', $file); 
$csv_header = $csv_data[0]; ####### Sets a variable to output only the header row.



####### Randomly generate a number for battery charge column. Think of collecting data from 15 entities.
foreach($csv_data as $row){
    
  

    $rand = number_format(mt_rand(0*100.0, 100.0*100.0) / 100.0, 1);

  if(strpos($row[3], chr(46)) !== false) {

  
      $row = str_replace($row[3], $rand, $row);
  }
  
     

  $row = array_combine($csv_header, $row); ###### It combines the header row with all rows where battery charge <= 50%.

 // print_r($row); To view all rows that met the condition.
    echo "Random Number generated <br>";
    fwrite($masterme, implode(',', $row)); ###### Adds a comma in every cells.
    fwrite($masterme, PHP_EOL); ###### After passing the 4th column (battery charge column), add a linebreak after it.
}
 


  
  header("Location: {YOUR_WEBSITE}/etlm/sadi/new/sensordata_$date.csv");
  


?>
