<?php
// Establish Connection to Database
function connect() {
    static $conn;
    if ($conn === NULL){
        $conn = mysqli_connect('localhost','kuhooadmin','abc123','vitgram');
    }
    return $conn;
}

?>
