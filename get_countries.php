<?php
include_once "db_con.php";

$sql = "SELECT * FROM countries";
$get_result=$conn->query($sql);
