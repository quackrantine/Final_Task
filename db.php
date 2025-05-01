<?php

function getDBConnection() {
    $servername = "sql.freedb.tech";
    $username = "freedb_finaltask"; // Make sure this matches FreeDB EXACTLY
    $password = "c%?Yy6@y7hvKbzS";    // Make sure this matches FreeDB EXACTLY
    $database = "freedb_finaltask";   // Use this variable below
    $port = 3306;                     // FreeDB uses port 3306

    // Use the correct variable $database and include the $port
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Check connection
    if ($conn->connect_error) {
        // Provide detailed error
        die("Connection failed: " . $conn->connect_error . " (Host: " . $servername . ":" . $port . ")");
    }
    return $conn;
}

?>
