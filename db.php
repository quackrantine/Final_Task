<?php

function getDBConnection() {
    $servername = "sql.freedb.tech";
    $username = "freedb_quackratine";
    $password = "!S$62Am!DTx*2ZF";
    $database = "freedb_finaltask";
    $port = 3306;

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

?>
