<?php
if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=="127.0.0.1" || $_SERVER['HTTP_HOST']=="192.168.1.1"  || $_SERVER['HTTP_HOST']=="[::1]"){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "alkapurifier";
}else{
    $servername = "localhost";
    $username = "alkaener_dsvinfo";
    $password = "dsvinfo@123";
    $dbname = "alkaener_alkadb";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

