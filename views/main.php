<?php
$title = 'Overview';
require_once '../controller/connection.php';

function get_content(){
    // TASK 
    $userId = $_SESSION['user_data']['user_id'];
    $query = "SELECT * FROM task where user_id = '$userId' AND done = 1 ";
    $task_completed = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query));
    $query = "SELECT * FROM task where user_id = '$userId' AND done = 0 ";
    $task_incomplete = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query));
?>

<body>
    <div class="content d-flex">
        <div class="task-box">
            <h2 class="text-white text-center box-text">TASK</h2>
            <div class="d-flex">
                <div class="task-chart mx-5 py-5">
                    <canvas id="taskChart"></canvas>
                </div>
                <?php if($task_completed == 0 && $task_incomplete == 0): ?>
                    <h2 class="text-white text-center box-text pt-4">No task available</h2>
                <?php else: ?>
                    <div class="chart-task-list">
                    </div>
                <?php endif ; ?>
                <div class="task-list py-3">
                    <?php if($task_incomplete == 0): ?>
                        <h3 class="text-white text-center">No Task Available</h3>
                    <?php else: 
                            $tasks = "SELECT title FROM task WHERE user_id = '$userId' AND done = 0 LIMIT 6";
                            $result = mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $tasks), MYSQLI_ASSOC);
                    ?>
                            <ul>
                            <?php foreach($result as $element): ?>
                                <li class="li-task"><?php echo $element['title'] ?></li>
                            <?php endforeach; ?>
                            </ul>
                    <?php endif; ?>
                    <div class="d-flex justify-content-center">
                        <button id="addTask" class="navigate mx-auto">Add Task</button>
                    </div>
                </div>
            </div> 
        </div>
        <div class="goal-box">
            <h2 class="text-white text-center box-text">GOALS</h2>
        </div>
        <div class="event-box">
            <h2 class="text-white text-center box-text">EVENTS</h2>
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
                    backgroundColor : ["#005e58"],
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
    $('#addTask').click(function(e){
        e.preventDefault
        window.location.href='task.php'
    })
</script>


<?php
}
require_once 'layout.php';
