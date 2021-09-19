<?php 
    if($_SESSION['user_data']['field'] == 'self'){
        $class = 'Individual';
    } else{
        $class = 'Organization';
    }

    $username = $_SESSION['user_data']['username'];
?>

<div class="header">
    <h1 class="text-center py-5 text-white"><?php echo $class ?></h1>
    <div class="user d-flex px-5 align-items-center">
        <p class="text-white px-3"><?php echo $username ?></p>
        <i class="bi bi-person-circle text-white px-3"></i>
    </div>
</div>