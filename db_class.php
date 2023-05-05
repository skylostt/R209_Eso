<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('bdd.db');
    }
}
?>
