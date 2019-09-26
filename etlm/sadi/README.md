# Sensordata ETL - PHP based script used for file extraction, transformation, and loading new files back to the server. 

The purpose of this project is to filter out the original .csv file then overwrite it to a new file based on a condition. The condition is to retain all entities if their battery charge is less than or equal to 50.0%. This process can be done on your own however you may set it automatic. To set up the automation, I use Linux cron job to execute etl.php and random.php in every hour. The automation will output 24 new files and another 24 filtered files every day. Please note that you will need to replace {YOUR_WEBSITE} to your web server in order to work.

## Scenario
Your IT Manager wants you to build a middleware application that collects all data based on a business condition. The objective is to replace the battery if the battery charge is less than 50%. Every hour, the server releases updated sensordata files. You are to manipulate the file by extracting items (only if the battery charge <= 50%) from first point of the server, rewriting them to a new file, and uploading it back to the second point of the server. The second point of the server is where your IT Manager will view specific items needed to replace the battery.


If you would like to try a demo of this project, please visit https://sachelpurvis.me/etl/sadi/manual.php

# ~Sach
