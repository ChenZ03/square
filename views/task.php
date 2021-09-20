<?php
$title = 'Overview';
require_once '../controller/connection.php';

function get_content(){
    $userId = $_SESSION['user_data']['user_id'];
    $org = $_SESSION['user_data']['organization'];
    $query = "SELECT * FROM task where user_id = '$userId' AND done = 1 ";
    $task_completed = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query));
    $query = "SELECT * FROM task where user_id = '$userId' AND done = 0 ";
    $task_incomplete = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query));
    // var_dump($_SESSION['user_data']);
    // die();
?>

<body>
    <div class="content d-flex">
        <div class="task-progression-box">
            <h1 class="text-white text-center box-text">Progression</h1>
            <div class="task-chart-list mx-auto py-5">
                <canvas id="taskChart"></canvas>
            </div>  
            <div class="d-flex justify-content-center">
                <ul>
                    <li>Incomplete Task : <?php echo $task_incomplete ?></li>
                    <li>Completed Task : <?php echo $task_completed ?></li>
                </ul>
            </div>   
        </div>
        <div class="task-list-box">
            <h1 class="text-white text-center box-text">Task List</h1>
            <div class="single-task-list mx-auto py-3">
                <?php 
                    $query_ind = "SELECT * FROM task WHERE user_id = '$userId' AND organization_id IS NULL AND done = 0";
                    $ind_task = mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $query_ind), MYSQLI_ASSOC);
                ?>
                <?php if($org != NULL): ?>
                    <?php
                        $query_org = "SELECT * FROM task WHERE user_id = '$userId' AND organization_id = '$org' AND done = 0";
                        $org_task = mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $query_org), MYSQLI_ASSOC);
                    ?> 
                    <h2 class="text-white pb-4 underline"><?php echo (str_starts_with($org, 'S')) ? 'School' : 'Company' ?></h2>
                    <ol>
                        <?php if(mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query)) == 0): ?>
                            <h3 class="text-white">No Task Available</h3>
                        <?php else: ?>
                            <?php foreach($org_task as $single): ?>
                                <div class="d-flex align-items-center py-2">
                                    <li>
                                        <h4 class="text-white"><?php echo $single['title'] ?></h4>
                                        <ul>
                                            <li><h6 class="text-white"><?php echo $single['description'] ?></h6></li>
                                            <li class="d-flex"><h6 class="text-white">Due Date :  </h6><h6 class="text-white font-extrabold"><?php echo $single['dueDate'] ?></h6></li>
                                        </ul>
                                    </li>
                                    <button class="done mx-16" id="<?php echo $single['id'] ?>"> Mark as Done</button>
                                </div>   
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ol>
                <?php endif; ?>
                <h2 class="text-white pb-4 underline">Individual Task</h2>
                <ol>
                    <?php if(mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query_ind)) == 0): ?>
                        <h3 class="text-white">No Task Available</h3>
                    <?php else: ?>
                        <?php foreach($ind_task as $single): ?>
                            <div class="d-flex align-items-center py-2">
                                <li>
                                    <h4 class="text-white"><?php echo $single['title'] ?></h4>
                                    <ul>
                                        <li><h6 class="text-white"><?php echo $single['description'] ?></h6></li>
                                        <li class="d-flex"><h6 class="text-white">Due Date :  </h6><h6 class="text-white font-extrabold"><?php echo $single['dueDate'] ?></h6></li>
                                    </ul>
                                </li>
                                <button class="done mx-16" id="<?php echo $single['id'] ?>"> Mark as Done</button>
                            </div>
                        <?php endforeach; ?>   
                    <?php endif; ?>
                </ol>
            </div>
        </div>
    </div>
</body>

<script>
    // Charts
    // task
    <?php if($task_completed == 0 && $task_incomplete == 0): ?>
        var taskdata = {
            labels: ['No Task'],
            datasets:[
                {
                    label : 'No Task',
                    data: [100],
                    backgroundColor : ["#09b57d"],
                }
            ]
        }
    <?php else: ?>
        var taskdata = {
        labels: ['incomplete', 'completed'],
        datasets: [
            {
                label : 'Task Completion',
                data: [<?php echo $task_incomplete ?>, <?php echo $task_completed ?>],
                backgroundColor : [ "#005e58", "#09b57d" ],
            }
        ]
    }
    <?php endif; ?>
    
    
    var taskChart = new Chart(document.getElementById('taskChart'), {
        type: 'doughnut',
        data: taskdata,
        options : {
            responsive : true,
            plugins:{
                legend : {
                    position : 'bottom',
                    labels : {
                        fontColor : 'white',
                        fontSize: 16
                    }
                }
            }
        }
    })

    // buttons 
    $('.done').click(function(e){
        e.preventDefault
        var box = confirm("Mark this task as done?");
        if(box){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'done',
                    id : this.id
                },
                success : function(response){
                    location.reload()
                }
            })
        }else{
            e.preventDefault
        }
       
    })

</script>


 
<?php
}
require_once 'layout.php';