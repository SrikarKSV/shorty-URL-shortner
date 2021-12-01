<?php
$HOSTNAME =  "your_host_name";
$USERNAME = "your_username";
$DATABASENAME = "your_databasename";
$PASSWORD = "your_password";

$conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASENAME);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
