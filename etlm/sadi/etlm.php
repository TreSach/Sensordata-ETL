<?php

if($_SERVER['REQUEST_METHOD'] == 'GET') {

  if(isset($_GET['datatransfer'])) {
date_default_timezone_set('America/New_York'); 




######################################################## Writing and Outputting data into a new CSV file ########################################################

$masterme = fopen(dirname(__FILE__) . "/out/sensordata_$date.csv", "w+");  
$file = file(dirname(__FILE__) . "/new/sensordata_$date.csv"); 


$csv_data = array_map('str_getcsv', $file); ####### Convert strings from the csv file into an array.
$csv_header = $csv_data[0]; ####### Sets a variable to output only the header row.

 
foreach($csv_data as $row){

if($row[3] <= 50.0){  ###### If battery charge is less than 50.0%, it outputs the row of this condition.


  $row = array_combine($csv_header, $row); ###### It combines the header row with all rows where battery charge < 50.0%.

  print_r($row); ##### You may remove this function. It's only to see the if condition works on filtering all data.
    echo "Filtered Data Complete! <br>";
    fwrite($masterme, implode(',', $row)); ###### Adds a comma in every cells.
    fwrite($masterme, PHP_EOL); ###### After passing the 4th column (battery charge column), add a linebreak after it.

  }

}
header("Location: {YOUR_WEBSITE}/etlm/sadi/manual.php?etlsuccess");
exit();

  } else {
    header("Location: {YOUR_WEBSITE}/etlm/sadi/manual.php?manualetl=failed");
    exit();
  }

}
?>
