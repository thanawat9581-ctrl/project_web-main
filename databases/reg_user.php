<?php
function insertCourse($users): bool
{
    global $conn;
    $sql = 'insert into users (name, email,password,gender,birthdate,province) VALUES (?,?,?,?,?,?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssis',
        $users['name'], 
        $users['email'], 
        $users['password'], 
        $users['gender'], 
        $users['birthdate'], 
        $users['province']);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}