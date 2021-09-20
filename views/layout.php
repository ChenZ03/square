<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SCRIPT  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="/node_modules/chart.js/dist/chart.js"></script>

    <!-- CSS  -->
    
    <!-- Tailwind CSS -->
     <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" href="/assets/image/Logo_ntext.png">

    
    <title>SQUARE | <?php echo $title; ?> </title>
</head>
<body>
    <?php require_once "template/header.php" ?>
    <?php require_once "template/menubar.php"; ?>
    <?php
    if(!isset($_SESSION['user_data'])){
        header('Location: /');
    }
    ?>

    <main>
        <?php get_content(); ?>
    </main>
</body>
</html>