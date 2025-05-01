<?php

function getDBConnection() {
    $servername = "hopper.proxy.rlwy.net";
    $username = "root";
    $password = "wOFYknqEOTRFRqIMfSBTOJfzcizdCmai";
    $database = "railway";
    $port = 43901;

    $conn = new mysqli($servername, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
