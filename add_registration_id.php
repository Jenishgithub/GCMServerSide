<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$server = "localhost";
$database = "push_demo";
$username = "root";
$password = "";
$mysqlConnection = mysql_connect($server, $username, $password);
if (!$mysqlConnection) {
    echo "Please try later.";
} else {
    mysql_select_db($database, $mysqlConnection);
}
if ($_SERVER['REQUEST_METHOD'] == "GET") { // Get data 
    $registration_id = isset($_GET['registration_id']) ? mysql_real_escape_string($_GET['registration_id']) : "";
// Insert data into data base 
    $q = mysql_query("select * from user where registration_id='" . $registration_id . "'") or die(mysql_error());
    $n = mysql_fetch_row($q);
    if ($n > 0) {
        $json = array(
            "status" => 2,
            "msg" => "UserID already added!"
        );
    } else {
        $sql = "INSERT INTO user (registration_id) VALUES ('$registration_id')";
        $qur = mysql_query($sql);
        if ($qur) {
            $json = array(
                "status" => 1,
                "msg" => "Done user id added!"
            );
        } else {
            $json = array(
                "status" => 0,
                "msg" => "Error adding user id!"
            );
        }
    }
} else {
    $json = array(
        "status" => 0,
        "msg" => "Request method not accepted"
    );
}
@mysql_close($conn);

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
