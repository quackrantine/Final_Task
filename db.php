<?php

function getDBConnection() {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "blackmarket_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

?>
