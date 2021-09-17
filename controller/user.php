<?php 

require_once 'connection.php';
session_start();

$case = $_REQUEST['action'];

switch ($case){
    case 'register':
        $id = $_REQUEST['id'];
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $field = $_REQUEST['field'];
        $query = "SELECT * FROM users WHERE username = '$username' ";
        
        $num = mysqli_num_rows(mysqli_query($cn, $query));

        if($num != 0){
            echo "User exist, please proceed to login";
            exit;
            break;
        }else{
            echo "User successfully registered, please proceed to login";
            $query2 = "INSERT INTO users(user_id, username, password, field) VALUES ('$id', '$username', '$password', '$field')";
            mysqli_query($cn, $query2);
            break;
        }

    case 'login':
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $query = "SELECT * FROM users WHERE username = '$username' ";
        $result = mysqli_query($cn, $query);
        $num = mysqli_num_rows($result);

        if($num > 0){
            $pw = mysqli_fetch_assoc($result);
            if($pw['password'] = $password){
                $_SESSION['user_data'] = $pw;
                echo "success";
            }else{
                echo "fail";
            }
        }else{
            echo "Invalid user";
            break;
        }
        
}


?>
