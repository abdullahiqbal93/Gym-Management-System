<?php
$server="localhost";
$uname="root";
$pass="";
$db="amaDb";


$con = mysqli_connect("localhost","root","","amaDb");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}