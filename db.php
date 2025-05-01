<?php

function getDBConnection() {
    $servername = "mysql.railway.internal";   // From MYSQLHOST
    $username = "root";                       // From MYSQLUSER
    $password = "wOFYknqEOTFRRqIMfSBTOJfczizdCmai";  // From MYSQLPASSWORD
    $database = "railway";                    // From MYSQL_DATABASE
    $port = 3306;                             // From MYSQLPORT

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
