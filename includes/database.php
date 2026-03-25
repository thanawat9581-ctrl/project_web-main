<?php
declare(strict_types=1);
function getConnection(): mysqli
{
    $hostname = '*******';
    $dbName = 'blabonli_eventsystem';
    $username = 'blabonli_User1';
    $password = '*******';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}