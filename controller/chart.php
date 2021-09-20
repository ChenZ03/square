<?php 
session_start();
require_once 'connection.php';


$case = $_REQUEST['action'];

switch ($case){
    case 'done':
        $id = $_REQUEST['id'];
        $query  = "UPDATE task SET done = 1 WHERE id = $id";
        mysqli_query($cn, $query);
        break;
}
?>