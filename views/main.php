<?php
$title = 'Overview';
require_once '../controller/connection.php';

function get_content(){
    $userId = $_SESSION['user_data']['user_id'];
    $org = $_SESSION['user_data']['organization'];

    // TASK  
    $query = "SELECT * FROM task where user_id = '$userId' AND done = 1 ";
    $task_completed = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query));
    $query = "SELECT * FROM task where user_id = '$userId' AND done = 0 ";
    $task_incomplete = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query));

    //Goals
    $overall_query = "SELECT * FROM goals WHERE user_id = '$userId'";
    $overall = mysqli_fetch_assoc(mysqli_query($GLOBALS['cn'], $overall_query ));

    $goals = array(
        "Health" => intval($overall['health_count']),
        "Education" => intval($overall['education_count']),
        "Skills" => intval($overall['skills_count']),
        "Social" => intval($overall['social_count'])
    );

    if($org != NULL){
        $org_goal_query = "SELECT * FROM org_goal WHERE org_id = '$org'";
        $org_goals_num = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $org_goal_query));
        $goals['Organization'] = intval($org_goals_num);
    };

    //Events
    if($org != NULL){
        $org_events_query = "SELECT * FROM event WHERE organization_id = '$org' AND date > NOW() ORDER BY date LIMIT 4 ";
        $org_events = mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $org_events_query), MYSQLI_ASSOC);
        $events_query = "SELECT * FROM event WHERE user_id = '$userId' AND date > NOW() ORDER BY date LIMIT 4";
        $events = mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $events_query), MYSQLI_ASSOC);
    }else{
        $events_query = "SELECT * FROM event WHERE user_id = '$userId' AND date > NOW() ORDER BY date LIMIT 8";
        $events = mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $events_query), MYSQLI_ASSOC);
    }

?>

<body>
    <div class="content d-flex">
        <div class="task-box">
            <h2 class="text-white text-center box-text">TASK</h2>
            <div class="d-flex align-items-center justify-content-center">
                <div class="task-chart mx-5 py-5">
                    <canvas id="taskChart"></canvas>
                </div>
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
            <div class="d-flex align-items-center justify-content-center">
                <div class="goal-chart mx-5 py-4 col-6">
                    <canvas id="goalChart"></canvas>
                </div>
                <div class="goal-list col-6">
                    <?php if(array_sum(array_values($goals)) == 0): ?>
                        <h3 class="text-white text-center">No Goals Available</h3>
                    <?php else: ?>
                        <ul>
                            <?php foreach($goals as $keys => $goal): ?>
                                    <li class="li-task">
                                        <?php echo $keys,' ', 'goals : ', ' ' , $goal  ?>
                                    </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="d-flex justify-content-center">
                        <button id="viewGoals" class="navigate mx-auto">View Details</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="event-box">
            <h2 class="text-white text-center box-text">EVENTS</h2>
            <div class="row">
                <div class="col-6">
                    <?php if($org != NULL): ?>
                        <h4 class="text-white text-center underline">Organization Events</h4>
                        <?php if(mysqli_num_rows(mysqli_query($GLOBALS['cn'], $org_events_query)) < 1): ?>
                            <h5 class="text-white text-center py-5">No upcoming events</h5>
                        <?php else: ?>
                            <ul class="event-list">
                                <?php foreach($org_events as $org_event): ?>
                                    <li class="text-white">
                                        <?php echo $org_event['date'], ' - ', ' ', $org_event['title']  ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    <?php else: ?>
                        <h4 class="text-white text-center underline" >Personal Events</h4>
                        <?php if(mysqli_num_rows(mysqli_query($GLOBALS['cn'], $events_query)) < 1): ?>
                            <h5 class="text-white text-center py-5">No upcoming events</h5>
                        <?php else: ?>
                            <ul class="event-list">
                                <?php for($x = 0; $x < 3; $x++): ?>
                                    <li>
                                        <?php echo $events[$x]['date'], ' - ', ' ', $events[$x]['title'] ?>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="col-6">
                    <h4 class="text-white text-center underline" >Personal Events</h4>
                    <?php if($org != NULL): ?>
                        <?php if(count($events) < 1): ?>
                            <h5 class="text-white text-center py-5">No upcoming events</h5>
                        <?php else: ?>
                            <ul class="event-list">
                                <?php foreach($events as $event): ?>
                                    <li>
                                        <?php echo $event['date'], ' - ', ' ', $event['title'] ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if(count($events) < 4): ?>
                            <h5 class="text-white text-center py-5">No upcoming events</h5>
                        <?php else: ?>
                            <ul class="event-list">
                                <?php for($x = 3; $x < count($events); $x++): ?>
                                    <li>
                                        <?php echo $events[$x]['date'], ' - ', ' ', $events[$x]['title'] ?>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
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

    //goals
    <?php
    echo "var goalslabels = " . json_encode(array_keys($goals));
    echo ";";
    echo "var goalsdata =" . json_encode(array_values($goals));
    ?>


    const goalsChartData = {
        labels: goalslabels,
        datasets: [{
            label: 'Goals Distribution',
            data: goalsdata,
            backgroundColor: 'rgba(255,255,255,0.5)',
            borderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(255, 99, 132)'
        }]
    };

    var goalsChart = new Chart(document.getElementById('goalChart'), {
        type: 'radar',
        data : goalsChartData,
        options :{
            responsive : true,
            elements: {
                line: {
                    borderWidth: 3
                }
            },
            scales: {
                r: {
                    grid: {
                        color: 'gray'
                    },
                    angleLines:{
                        color: 'gray'
                    },
                    pointLabels: {
                        color: 'white'
                    },
                    ticks: {
                        font :{
                            size : 10,
                        },
                        BackgroundColor : 'none'
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

    $('#viewGoals').click(function(e){
        e.preventDefault
        window.location.href='goals.php'
    })


</script>


<?php
}
require_once 'layout.php';
