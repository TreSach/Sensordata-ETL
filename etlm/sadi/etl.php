<?php


date_default_timezone_set('America/New_York'); ####### This timezone should match with the timezone set in .csv files.
###################### NOTICE: Filename validator was added in the middleware. All filenames of csv file with a past date and time will be rejected.

$date = date('Y_m_d_H');



######################################################## Writing and Outputting data into a new CSV file ########################################################

$masterme = fopen(dirname(__FILE__) . "/out/sensordata_$date.csv", "w+");   
$file = file(dirname(__FILE__) . "/new/sensordata_$date.csv");  



$csv_data = array_map('str_getcsv', $file); ####### Convert strings from the csv file into an array.
$csv_header = $csv_data[0]; ####### Sets a variable to output only the header row.

 ###### str_replace only works on values of the array, not the keys. $csv_header is the keys of the array or the header row in a csv file.
foreach($csv_data as $row){

if($row[3] <= 50.0){  ###### If battery charge is less than 50.0%, it outputs the row of this condition.


  $row = array_combine($csv_header, $row); ###### It combines the header row with all rows where battery charge < 5.0.

  print_r($row); ##### You may remove this function. It's only to see the if condition works on filtering all data.
    echo "Filtered Data Complete! <br>";
    fwrite($masterme, implode(',', $row)); ###### Adds a comma in every cells.
    fwrite($masterme, PHP_EOL); ###### After passing the 4th column (battery charge column), add a linebreak after it.

  }

}

function onclick() {
header('Content-Type: text/csv; charset=utf-8');
header("Location: {YOUR_WEBSITE}/etlm/sadi/out/sensordata_$date.csv");
}




?>
