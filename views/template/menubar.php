<div class="menubar">
    <img src="/assets/image/Logo.png" alt="#" class="mx-auto py-5">
    <div class="icons py-4 mx-auto text-center <?php echo ($_SERVER['REQUEST_URI'] == '/views/main.php') ? 'selected' : '' ?>">
        <i class="bi bi-x-diamond-fill" id="overview"></i>
        <p class= "text" id="overview_text">OVERVIEW</p>
    </div>
    <div class="icons py-4 mx-auto text-center <?php echo ($_SERVER['REQUEST_URI'] == '/views/task.php') ? 'selected' : '' ?>">
        <i class="bi bi-check-square-fill" id="task"></i>
        <p class="text" id="task_text">TASK</p>
    </div>
    <div class="icons py-4 mx-auto text-center <?php echo ($_SERVER['REQUEST_URI'] == '/views/events.php') ? 'selected' : '' ?>">
        <i class="bi bi-calendar-event-fill" id="events"></i>
        <p class="text" id="calendar_text">EVENTS</p>
    </div>
    <div class="icons py-4 mx-auto text-center <?php echo ($_SERVER['REQUEST_URI'] == '/views/goals.php') ? 'selected' : '' ?>">
        <i class="bi bi-award-fill" id="goals"></i>
        <p class="text" id="goals_text">GOALS</p>
    </div>
    <div class="icons py-4 mx-auto text-center">
        <i class="bi bi-door-open-fill" id="logout"></i>
    </div>
</div>

<script>
    $('#overview').click(function(e){
        e.preventDefault
        window.location.href = "./main.php";
    })

    $('#task').click(function(e){
        e.preventDefault
        window.location.href = "./task.php";
    })

    $('#events').click(function(e){
        e.preventDefault
        window.location.href = "./events.php";
    })

    $('#goals').click(function(e){
        e.preventDefault
        window.location.href = "./goals.php";
    })

    $('#logout').click(function(e){
        var yes = confirm('Are you sure you want to logout?');
        if(yes){
            $.ajax({
                url: '../controller/user.php?action=logout',
                success: function(response){
                    alert('Logout Successfully');
                    window.location.href = "../";
                }
            })
        }
        
    })


</script>