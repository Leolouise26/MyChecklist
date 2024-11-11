<?php
$connection = mysqli_connect("localhost", "root", "password", "lchecklist");

if (!$connection) {
    die("Connection error: " . mysqli_connect_error());
}

?>