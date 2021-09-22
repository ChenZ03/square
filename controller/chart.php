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

    case 'achieved_goal_org':
        $id = $_REQUEST['id'];
        $query  = "UPDATE org_goal SET achieved = 1 WHERE id = $id";
        mysqli_query($cn, $query);
        break;

    case 'achieved_goal':
        $type = $_REQUEST['type'];
        $id = $_REQUEST['id'];
        if($type == 'health'){
            $query  = "UPDATE health_goal SET achieved = 1 WHERE id = $id";
            mysqli_query($cn, $query);
            break;
        }else if($type == 'edu'){
            $query  = "UPDATE education_goal SET achieved = 1 WHERE id = $id";
            mysqli_query($cn, $query);
            break;
        }else if($type == 'skills'){
            $query  = "UPDATE skills_goal SET achieved = 1 WHERE id = $id";
            mysqli_query($cn, $query);
            break;
        }else if($type == 'social'){
            $query  = "UPDATE social_goal SET achieved = 1 WHERE id = $id";
            mysqli_query($cn, $query);
            break;
        }else{
            echo "ERROR";
            break;
        }
        break;
    
    case 'add_goal':
        $title = $_REQUEST['title'];
        $type = $_REQUEST['type'];
        $goal_id = $_REQUEST['goalId'];
        if($type == 'health'){
            $query = "INSERT INTO health_goal(goal_id, title) VALUES ('$goal_id', '$title')";
            mysqli_query($cn, $query);
            $query = "UPDATE goals SET health_count = health_count + 1 WHERE id = '$goal_id' ";
            mysqli_query($cn, $query);
            break;
        }else if($type == 'edu'){
            $query = "INSERT INTO education_goal(goal_id, title) VALUES ('$goal_id', '$title')";
            mysqli_query($cn, $query);
            $query = "UPDATE goals SET education_count = education_count + 1 WHERE id = '$goal_id' ";
            mysqli_query($cn, $query);
            break;
        }else if($type == 'skills'){
            $query = "INSERT INTO skills_goal(goal_id, title) VALUES ('$goal_id', '$title')";
            mysqli_query($cn, $query);
            $query = "UPDATE goals SET skills_count = skills_count + 1 WHERE id = '$goal_id' ";
            mysqli_query($cn, $query);
            break;
        }else if($type == 'social'){
            $query = "INSERT INTO social_goal(goal_id, title) VALUES ('$goal_id', '$title')";
            mysqli_query($cn, $query);
            $query = "UPDATE goals SET social_count = social_count + 1 WHERE id = '$goal_id' ";
            mysqli_query($cn, $query);
            break;
        }else{
            echo "ERROR";
            break;
        }
        break;

    case 'add_org_goal':
        $org = $_SESSION['user_data']['organization'];
        $title = $_REQUEST['title'];
        $query = "INSERT INTO org_goal(org_id, title) VALUES ('$org', '$title')";
        mysqli_query($cn, $query);
        break;

    case 'get_event_details' :
        $org = $_SESSION['user_data']['organization'];
        $userId = $_SESSION['user_data']['user_id'];
        $month = $_REQUEST['month'];
        $day = $_REQUEST['day'];
        $events = array();
        $events_details_query_ps = "SELECT * FROM event WHERE user_id = '$userId' AND MONTH(date) = $month AND DAY(date) = $day ";
        $events_details_ps = mysqli_fetch_all(mysqli_query($cn, $events_details_query_ps), MYSQLI_ASSOC);
        foreach($events_details_ps as $ind_event){
            $temp = [];
            $temp['title'] = $ind_event['title'];
            $temp['desc'] = $ind_event['description'];
            $temp['date'] = $ind_event['date'];
            array_push($events, $temp);
        }
        if($org != NULL){
            $events_details_query_org = "SELECT * FROM event WHERE organization_id = '$org' AND MONTH(date) = $month AND DAY(date) = $day ";
            $events_details_org = mysqli_fetch_all(mysqli_query($cn, $events_details_query_org), MYSQLI_ASSOC);
            foreach($events_details_org as $org_event){
                $temp = [];
                $temp['title'] = $org_event['title'];
                $temp['desc'] = $org_event['description'];
                $temp['date'] = $org_event['date'];
                array_push($events, $temp);
            }
        }

        echo json_encode($events);
        break;

    case 'get_event':
        $org = $_SESSION['user_data']['organization'];
        $userId = $_SESSION['user_data']['user_id'];
        $month = $_REQUEST['month'];
        $month_query = "SELECT DAY(date) AS days FROM event WHERE user_id = '$userId' AND MONTH(date) = $month ";
        $result = mysqli_fetch_all(mysqli_query($cn, $month_query), MYSQLI_ASSOC);
        $days = [];
        foreach($result as $day){
            array_push($days,$day['days']);
        }
        if($org != NULL){
            $org_query = "SELECT DAY(date) AS days FROM event WHERE organization_id = '$org' AND MONTH(date) = $month ";
            $result2 = mysqli_fetch_all(mysqli_query($cn, $org_query), MYSQLI_ASSOC);;
            foreach($result2 as $org_day){
                array_push($days,$org_day['days']);
            }
        }
        echo json_encode(array_unique($days));
        break;

    case 'add_event':
        $org = $_SESSION['user_data']['organization'];
        $userId = $_SESSION['user_data']['user_id'];
        $title = $_REQUEST['title'];
        $desc = $_REQUEST['desc'];
        $date = $_REQUEST['date'];
        $assign = $_REQUEST['assign'];
        if($assign == 'organization'){
            $query = "INSERT INTO event(organization_id, title, description, date) VALUES('$org', '$title', '$desc', '$date')"; 
            mysqli_query($cn, $query);
            break;
        }else if($assign == 'self'){
            $query = "INSERT INTO event(user_id, title, description, date) VALUES('$userId', '$title', '$desc', '$date')"; 
            mysqli_query($cn, $query);
            break;
        }else{
            echo 'ERROR';
            break;
        }
        break;

    
    default:
        echo "ERROR";
        break;
        
}
?>