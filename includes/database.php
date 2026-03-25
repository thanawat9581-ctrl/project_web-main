<?php
declare(strict_types=1);
function getConnection(): mysqli
{
    $hostname = '103.27.201.8';
    $dbName = 'blabonli_eventsystem';
    $username = 'blabonli_User1';
    $password = '@pw112233';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}