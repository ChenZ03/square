<?php 
    if($_SESSION['user_data']['field'] == 'self'){
        $org = 'Individual';
    } else{
        $org_id = $_SESSION['user_data']['organization'];
        $organization = "SELECT * FROM organization WHERE id = '$org_id' ";
        $result = mysqli_fetch_assoc(mysqli_query($GLOBALS['cn'], $organization));
        $org = $result['name'];
    }

    $username = $_SESSION['user_data']['username'];
?>

<div class="header">
    <h1 class="text-center py-5 text-white"><?php echo $org ?></h1>
    <div class="user d-flex px-5 align-items-center">
        <p class="text-white px-3"><?php echo $username ?></p>
        <i class="bi bi-person-circle text-white px-3"></i>
    </div>
</div>