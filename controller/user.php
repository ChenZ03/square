<?php 
session_start();
require_once 'connection.php';


$case = $_REQUEST['action'];

switch ($case){
    case 'register':
        $id = $_REQUEST['id'];
        $org = $_REQUEST['org'];
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
            if($org == 'self'){
                $query2 = "INSERT INTO users(user_id, username, password, field) VALUES ('$id', '$username', '$password', '$field')";
                mysqli_query($cn, $query2);
            }else{
                $query2 = "INSERT INTO users(user_id, username, password, field, organization) VALUES ('$id', '$username', '$password', '$field', '$org')";
                mysqli_query($cn, $query2);
                $query3 = "UPDATE organization SET member_count = member_count + 1 WHERE id = '$org' "; 
                mysqli_query($cn, $query3);
            }
            $query = "INSERT INTO goals(user_id) VALUES ('$id')";
            mysqli_query($cn, $query);
            
            break;
        }
        break;

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
                $_SESSION['page'] = 'overview';
                echo "success";
            }else{
                echo "fail";
            }
        }else{
            echo "Invalid user";
            break;
        }
        break;

    case 'logout':
        session_destroy();
        unset($_SESSION);
        break;

    case 'get_school':
        $query = "SELECT * FROM organization WHERE id LIKE 'S%' ";
        echo json_encode(mysqli_fetch_all(mysqli_query($cn, $query), MYSQLI_ASSOC));  
        break;

    case 'get_company':
        $query = "SELECT * FROM organization WHERE id LIKE 'C%' ";
        echo json_encode(mysqli_fetch_all(mysqli_query($cn, $query), MYSQLI_ASSOC));  
        break;

    default :
        echo "Error";
        break;
        
}


?>
