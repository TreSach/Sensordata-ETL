<?php

// Date format should match with the .csv files. Timezone set in Eastern Time using New York time.
date_default_timezone_set('America/New_York'); 

$date = date('Y_m_d_H'); 

$errors = [];


$fp = "new/sensordata_$date.csv";


if($_SERVER['REQUEST_METHOD'] == 'POST') {

   

   if(is_uploaded_file($_FILES['loadfile']['tmp_name'])){
      
        

        $user_file = $_FILES['loadfile']['name'];
     
       
       
      //Check filename
      
        $scan_file = basename($user_file, pathinfo($user_file, PATHINFO_EXTENSION));
        $scan_check = basename($fp, pathinfo($fp, PATHINFO_EXTENSION));

        
        if($scan_file !== $scan_check){
            $errors[] = "Invalid Filename. Filename should be in this format with current date and time: <em>sensordata_YYYY_MM_DD_HH.csv</em>";
          
        }

        //Check file type
       
        $user_mime = pathinfo($user_file, PATHINFO_EXTENSION);
        $check_mime = pathinfo($fp, PATHINFO_EXTENSION);
       
        if($user_mime !== $check_mime){
            $errors[] = "File extension not accepted. Only file with .csv extension is accepted.";
       
        }

        //Check file size

        $user_size = $_FILES['loadfile']['size'];
        $filep = filesize($fp);


        if( $user_size > 1000) {
            $errors[] = "Maximum file size exceeded.";
  
        } else if($user_size == 0){
            $errors[] = "Empty Bytes received. Empty Upload.";
      
        } else if($user_size !== $filep){
          $errors[] = "Invalid file size";
        }


   } else {
       $errors[] = "File is not uploaded. Empty Upload?";
   }

   if(sizeof($errors) == 0){
    header("Location: {YOUR_WEBSITE}/etlm/sadi/manual.php?success");
    exit();

}
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
body {
  background-color: #7A0292;
  
}
div.container-fluid, .list-group-item {
  color: white;
  background-color: transparent;
}
div.error {
	display: inline-block;
	background-color: #ffcccc;
  color: #990000;
	border-radius: 6px;
	padding: 5px 5px 5px 5px;
	width: auto;
	font-size: smaller;
}

div.success {
	display: inline-block;
	background-color: #66ff99;
  color: #009933;
	border-radius: 6px;
	padding: 5px 5px 5px 5px;
	width: auto;
	font-size: 14px;
}
div.head1 {
  text-align: center;
  background-color: #560166;
  padding: 5px 5px 5px 5px;
  color: white;
}

a.asuccess {
  color: #006633;
  text-decoration: none;
}
</style>
    <title>PHP ETL</title>
  </head>
  <body>
  <div class="head1">
          <h1>Manual Instruction - ETL</h1>
          <h6><em>Developed by Sachel Purvis</em></h6>
          </div>
      <div class="container-fluid">
      <br><br>

          <?php 
           if (isset($errors) && sizeof($errors) > 0) { 
             ?>

			<div class="error"><b>Server refused your request with the following errors:</b>
	<?php
				foreach ($errors as $error) {
					echo "<br/>";
					echo "&bullet; $error";
				}
	?>
			</div><br>
<?php } 


//GET success

if(isset($_GET["success"])) {
  header("Location: {YOUR_WEBSITE}/etlm/sadi/etlm.php?datatransfer");
  exit();
}

if(isset($_GET["etlsuccess"]) || $_GET['etlsuccess']){
  ?>
			<div class="success">
<a href="{YOUR_WEBSITE}/etlm/sadi/out/sensordata_<?php echo $date;?>.csv" class="asuccess"><b>Congratulations, ETL process was successful and updated file was created! Click this bubble to download the updated file for viewing.</b></a>
			</div><br>
<?php 
}
 ?>

          <br>
          
          
<form action="manual.php" method="post" enctype="multipart/form-data">
<div class="form-row">
<div class="col">
  <a href="{YOUR_WEBSITE}/etlm/sadi/random.php" class="btn btn-outline-light btn-lg">Generate</a>
  </div>
  <div class="col">
    <label for="loadfileme">File Upload</label>
<input type="file" name="loadfile" class="form-control-file">
</div>
<div class="col">
    <input type="submit" class="btn btn-outline-light btn-lg" name="etl" value="ETL">
    </div>
</form>
</div>
<br>
      <div>
      <ol class="list-group list-group-flush">
  <li class="list-group-item">Click the <b>Generate</b> button.</li>
  <li class="list-group-item">Save the .csv file to your folder without changing the filename.*</li>
  <li class="list-group-item">Optionally, open the file using your text editor (e.g. Notepad) to view contents.<br><em>Note the battery charge data. The server will grab only data if battery charge is less than or equal to 50.0%</em></li>
  <li class="list-group-item">Upload the .csv file.</li>
  <li class="list-group-item">Click the <b>ETL</b> button to start the proccess.</li>
</ol>
<p><em>NOTE: The server only accepts .csv files generated on current date and time (hourly). All .csv files created within past hour and other files will be rejected</em></p>

    </div>
   
  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>