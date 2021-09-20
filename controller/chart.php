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
    
    case 'addTask':
        $assign = $_REQUEST['assign'];
        $title = $_REQUEST['title'];
        $desc = $_REQUEST['desc'];
        $date = $_REQUEST['date'];
        $userId = $_SESSION['user_data']['user_id'];
        $org = $_SESSION['user_data']['organization'];

        if($assign == 'self'){
            $self_assign_query = "INSERT INTO task(user_id, title, description, dueDate) VALUES ('$userId', '$title', '$desc', '$date')";
            mysqli_query($cn, $self_assign_query);
        }else if ($assign == 'everyone'){
            $everyone = "SELECT user_id FROM users WHERE organization = '$org'";
            foreach(mysqli_fetch_all(mysqli_query($cn, $everyone), MYSQLI_ASSOC) as $item){
                $current = $item['user_id'];
                $everyone_assign_query = "INSERT INTO task(user_id, organization_id, title, description, dueDate) VALUES ('$current', '$org', '$title', '$desc', '$date')";
                mysqli_query($cn, $everyone_assign_query);
            }
        }else{
            $assign_single = "INSERT INTO task(user_id, organization_id, title, description, dueDate) VALUES ('$assign', '$org', '$title', '$desc', '$date')";
            mysqli_query($cn, $assign_single);
        }

        break;
}
?>