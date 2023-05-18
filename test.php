<?php
session_start();
include('db_class.php');
$sid = session_id();
$db = new MyDB();

if (isset($_SESSION['user']['username'])) {
    echo "ok";
}
?>
