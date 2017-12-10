<?php

    $db = 'checkres';
    $username = 'root';
    $password = '';
    $hostname = 'localhost';

    $GLOBALS['conn'] = mysqli_connect($hostname, $username, $password, $db);
    if ( !$GLOBALS['conn'] ) {
        die("Cannot connect to database: " . mysqli_connect_error($GLOBALS['conn']));
    }

?>