<?php
$title = 'Overview';
require_once '../controller/connection.php';

function get_content(){
    $userId = $_SESSION['user_data']['user_id'];
    $org = $_SESSION['user_data']['organization'];
    $isAdmin = $_SESSION['user_data']['isAdmin'];
    $query = "SELECT * FROM task where user_id = '$userId' AND done = 1 ";
    $task_completed = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query));
    $query = "SELECT * FROM task where user_id = '$userId' AND done = 0 ";
    $task_incomplete = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $query));
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
                                    <button class="done mark mx-16" id="<?php echo $single['id'] ?>"> Mark as Done</button>
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
                                <button class="done mark mx-16" id="<?php echo $single['id'] ?>"> Mark as Done</button>
                            </div>
                        <?php endforeach; ?>   
                    <?php endif; ?>
                </ol>
            </div>
            <div class="py-2 addTask d-flex justify-content-center align-items-center">
                <button type="button" class="btn done" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                   Add New Task
                </button>
            </div>
            <div class="modal fade" tabindex="-1" id="addTaskModal">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                    <div class="modal-content mm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title">Add new Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="Title" class="form-label">Task Title</label>
                                    <input type="text" id="task_title" class="form-control" placeholder="Enter your task title here (Must be less than 15 characters)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="desc" class="form-label">Task Description</label>
                                    <input type="text" id="desc" class="form-control" placeholder="Enter your task description here" required>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label"> Task Due Date</label>
                                    <input type="date" min="<?= date('Y-m-d'); ?>" id="due_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="assign" class="form-label"> Assign To </label>
                                    <select class="form-select" size="1" id="assign">
                                        <option selected disabled>Select who to assign </option>
                                        <option value="self">Self</option>
                                        <?php if($isAdmin):
                                            $member_query = "SELECT * FROM users WHERE organization = '$org' ";
                                            $result = mysqli_query($GLOBALS['cn'], $member_query);
                                            $members = mysqli_fetch_all($result, MYSQLI_ASSOC);    
                                        ?>
                                        <option value="everyone">Everyone</option>
                                        <?php foreach($members as $member): ?>
                                            <option value="<?php echo $member['user_id'] ?>"><?php echo $member['user_id'], ' ', $member['username'] ?></option>
                                        <?php endforeach ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                               
            
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn done two">Add Task</button>
                        </div>
                    </div>
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

    // buttons 
    $('.mark').click(function(e){
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

    $('.two').click(function(e){
        e.preventDefault
        let title = $('#task_title').val()
        let desc = $('#desc').val()
        let date = $('#due_date').val()
        let assign = $('#assign').val()
        if((title.length > 0 && title.length < 15) && (desc.length > 0 && desc.length < 25) && date.length > 0 && assign.length > 0){
            $.ajax({
                type : 'post',
                url: '../controller/chart.php',
                data:{
                    action: 'addTask',
                    title : title,
                    desc : desc,
                    date : date,
                    assign : assign
                },
                success : function(response){
                    location.reload()
                },
                
            })
        }else{
            e.preventDefault
            alert('Please meet all the requirements')
        }
    })

</script>


 
<?php
}
require_once 'layout.php';