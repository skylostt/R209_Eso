<?php
session_start();
include('db_class.php');

$db = new MyDB();
$sid = session_id();
echo $sid;
?>
