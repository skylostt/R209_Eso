<?php
session_start();
include('db_class.php');
$sid = session_id();
$db = new MyDB();

if (is_numeric($_GET['id'])) {
    echo "ok";
}
?>
