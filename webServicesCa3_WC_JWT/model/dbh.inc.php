<?php
$servername ="localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "webservices_clientdb";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn){
    die("connection failed: ". mysqli_connect_error());    
}