<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/login.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Jquery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="icon" href="/assets/image/Logo_ntext.png">
    <title> SQUARE² | LOGIN</title>
</head>
<body>

    <?php 
    session_start();
    require_once 'controller/connection.php';
    $query = "SELECT * FROM organization";
    $org = mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $query), MYSQLI_ASSOC);
    ?>
    <div class="black-box"></div>

    <div class="flex h-screen justify-center items-center  ">
        <div class="login m-auto shadow-2xl">
            <h3 class="text-center text-white mt-4">SQUARE²</h3>
            <h5 class="text-center text-white text-base opacity-75">A friendly & effective management system</h5>

            <!-- LOGIN  -->
            <h5 class="text-center mt-5 text-white text-lg log">Welcome Back!</h5>
            <form class="px-5 mb-5">
                
                <!-- REGISTER  FORM-->
                <h5 class="text-center mt-5 text-white text-lg reg">Register Now</h5>
                <div class="form-group py-1 ">
                    <div class="form-label text-white">
                        <i class="bi bi-person-fill "></i>
                        <label for="username">Username</label>
                    </div>
                    <input type="text" class="form-control" id="username" placeholder="Enter your Username " required>
                </div>

                <div class="form-group py-1">
                    <div class="form-label text-white">
                        <i class="bi bi-key-fill"></i>
                        <label for="password">Password</label>
                    </div>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password (more than 8 character)" required>
                </div>

                <div class="form-group py-1 reg">
                    <div class="form-label text-white">
                        <i class="bi bi-key-fill"></i>
                        <label for="password2">Confirm Password</label>
                    </div>
                    <input type="password" class="form-control" id="password2" placeholder="Confirm your password" required>
                </div>

                <div class="form-group py-1 reg">
                    <div class="form-label text-white">
                        <i class="bi bi-people-fill"></i>
                        <label for="field">Field</label>
                    </div>          
                    <select class="form-select form-select-sm" id="field" required>
                        <option selected disabled>Select your field</option>
                        <option value="self">Self Use</option>
                        <option value="school">School</option>
                        <option value="company">Company</option>
                    </select>
                </div>

                <div class="form-group py-1 reg ">
                    <div class="org-form" style="display: none;">
                        <div class="form-label text-white">
                            <i class="bi bi-geo-fill"></i>
                            <label for="organization">Organization</label>
                        </div>          
                        <select class="form-select form-select-sm" id="organization" required>
                            <option selected disabled value="self">Select your organization</option>
                        </select>
                    </div>  
                </div>
            </form>
            <div class="button-group mt-5 mb-5">
                <button class="text-white reg" id="register" value="Register" >Signup</button>
                <button class="text-white reg" id="toLogin" value="login" >Login</button>
                <button class="text-white log" id="login" value="login" >Login</button>
                <button class="text-white log" id="toRegister" value="Toreg" >Signup</button>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <script>
        $('#toLogin').click(function(){
            $('.reg').toggle("slow");
            $('.log').toggle("slow");
        })

        $('#toRegister').click(function(){
            $('.reg').toggle("slow");
            $('.log').toggle("slow");
        })

        $('#register').click(function(e){
            e.preventDefault;
            let username = $('#username').val()
            let password = $('#password').val()
            let passowrd2 = $('#password2').val()
            let field = $('#field').val()
            let org = $('#organization').val()
            if(username != '' && password.length > 8 && passowrd2 == password && field != ''){
                if((field == 'school' && !org.startsWith('S') ) || (field == 'company' && !org.startsWith('C'))){
                    alert('Please select organization according to your field')
                }else{
                    let id = ''
                    if(field == 'school'){
                        id += 'S'
                    }else if (field == 'company'){
                        id += 'C'
                    }else{
                        id += 'I'
                        org = 'self'
                    }
                    id += Date.now()
                    console.log(id)
                    $.ajax({
                        type: 'post',
                        url: '/controller/user.php',
                        data: {
                            action : 'register',
                            id : id,
                            username : username,
                            password : password,
                            field: field,
                            org: org
                        },
                        success: function(response){
                            alert(response)
                            $('.reg').toggle('slow');
                            $('.log').toggle('slow');
                        },
                    
                    })
                }
                
            }else{
                alert('Please meet all the requirements of the form')
            }
            
        })

        // AJAX 

        $('#login').click(function(e){
            e.preventDefault;
            let username = $('#username').val()
            let password = $('#password').val()
            if(username != '' && password != ''){
                $.ajax({
                    type : 'post',
                    url: '/controller/user.php',
                    data:{
                        action : 'login',
                        username : username,
                        password: password,
                    },
                    success: function(response){
                        if(response == 'success'){
                            alert('Login Successfully');
                            window.location.href = '/views/main.php';
                        }else if(response == 'fail'){
                            alert('Username and password mismatch');
                        }else{
                            alert('User does not exist, please proceed to register ');
                        }
                    }
                })
            }else{
                alert('Please fill up all the form')
            }
            
        })

        $('#field').change(function(){
            if($('#field').val() == 'school'){
                $('#organization').children('option:not(:first)').remove();
                $.ajax({
                    type: 'post',
                    url : '/controller/user.php',
                    data:{
                        action: 'get_school'
                    },
                    dataType: 'json',
                    success: function(response){
                        $('.org-form').css('display', 'block')
                        
                        for(var i of response){
                            $('#organization').append("<option value='" + i['id'] + "'>" + i['name'] + "</option>")
                        }
                    }
                })
            }else if($('#field').val() == 'company'){
                $('#organization').children('option:not(:first)').remove();
                $.ajax({
                    type: 'post',
                    url : '/controller/user.php',
                    data:{
                        action: 'get_company'
                    },
                    dataType: 'json',
                    success: function(response){
                        $('.org-form').css('display', 'block')
                        
                        for(var i of response){
                            $('#organization').append("<option value='" + i['id'] + "'>" + i['name'] + "</option>")
                        }
                    }
                })
            }else{
                $('.org-form').css('display', 'none')
            }
           
        })
    </script>

</body>
</html>