<?php
$title = 'Goals'; 
require_once '../controller/connection.php';

function get_content(){
    $userId = $_SESSION['user_data']['user_id'];
    $org = $_SESSION['user_data']['organization'];
    $goal_id_query = "SELECT id FROM goals WHERE user_id = '$userId'";
    $goal_id = intval(mysqli_fetch_assoc(mysqli_query($GLOBALS['cn'], $goal_id_query))['id']);
    $education_query_un = "SELECT id, title FROM education_goal WHERE goal_id = $goal_id AND achieved = 0 ";
    $education_un = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $education_query_un));
    $health_query_un = "SELECT id, title FROM health_goal WHERE goal_id = $goal_id AND achieved = 0 ";
    $health_un = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $health_query_un));
    $skills_query_un = "SELECT id, title FROM skills_goal WHERE goal_id = $goal_id AND achieved = 0 ";
    $skills_un = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $skills_query_un));
    $social_query_un = "SELECT id, title FROM social_goal WHERE goal_id = $goal_id AND achieved = 0 ";
    $social_un = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $social_query_un));
    
    $overall_query = "SELECT * FROM goals WHERE user_id = '$userId'";
    $overall = mysqli_fetch_assoc(mysqli_query($GLOBALS['cn'], $overall_query ));

    $goals_un = array(
        "Health" => $health_un,
        "Education" => $education_un,
        "Skills" => $skills_un,
        "Social" => $social_un
    );

    $goals_ac = array(
        "Health" => intval($overall['health_count']) - $health_un,
        "Education" => intval($overall['education_count']) - $education_un,
        "Skills" => intval($overall['skills_count']) - $skills_un,
        "Social" => intval($overall['social_count']) - $social_un
    );

    if($org != NULL){
        $org_goal_query = "SELECT id, title FROM org_goal WHERE org_id = '$org' AND achieved = 0";
        $org_goals_un = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $org_goal_query));
        $goals_un['Organization'] = $org_goals_un;
        $org_goal_query2 = "SELECT title FROM org_goal WHERE org_id = '$org' AND achieved = 1";
        $org_goals_ac = mysqli_num_rows(mysqli_query($GLOBALS['cn'], $org_goal_query2));
        $goals_ac['Organization'] = $org_goals_ac;
    }

?>

<div class="content d-flex">
    <div class="goals-row">
        <div class="distribution" style="<?php echo ($org != NULL) ? 'flex:33.33%;' : 'flex:66.66%;'  ?>">
            <h2 class="text-white text-center box-text">Distribution</h2>
            <div class="total-goal-chart mx-auto py-2" style="<?php echo ($org != NULL) ? 'width: 300px;' : 'width : 500px;' ?>">
                <canvas id="totalGoalChart"></canvas>
            </div>
        </div>
        <?php if($org != NULL): ?>
            <div class="org">
                <h2 class="text-white text-center box-text"><?php echo (str_starts_with($org, 'S')) ? 'School  ' : 'Company  ' ?> Goals</h2>
                <?php if($org_goals_un == 0): ?>
                    <h3 class="text-white text-center py-2">All Goals Achieved</h3>
                <?php else: ?>
                    <div class="goal-page-list scroll">
                        <ul class="py-3 mx-6">
                            <?php foreach(mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $org_goal_query), MYSQLI_ASSOC) as $org_goal ): ?>
                                <li>
                                    <h4 class="text-white"><?php echo $org_goal['title']; ?></h4>
                                    <?php if($_SESSION['user_data']['isAdmin'] == 1): ?>
                                        <button class="achieved org-btn" id="<?php echo $org_goal['id'] ?>">Achieved</button>
                                    <?php endif ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if($_SESSION['user_data']['isAdmin'] == 1): ?>
                    <div class="py-2 addGoal d-flex justify-content-center align-items-center">
                        <button type="button" class="btn done" data-bs-toggle="modal" data-bs-target="#addGoalsOrg">
                            Add New Goal
                        </button>
                    </div>
                    <div class="modal fade" tabindex="-1" id="addGoalsOrg">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                    <div class="modal-content mm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title">Add new Goal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="Title" class="form-label">Goal Title</label>
                                    <input type="text" id="org_goal_title" class="form-control" placeholder="Enter your goal title here (Must be less than 25 characters)" required>
                                </div>
                            </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn done orgGoal">Add Goal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="health">
            <h2 class="text-white text-center box-text">Health</h2>
            <?php if($health_un == 0): ?>
                <h3 class="text-white text-center py-2">All Goals Achieved</h3>
            <?php else: ?>
                <div class="goal-page-list scroll">
                    <ul class="py-3 mx-6">
                        <?php foreach(mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $health_query_un), MYSQLI_ASSOC) as $health_goal ): ?>
                            <li>
                                <h4 class="text-white"><?php echo $health_goal['title']; ?></h4>
                                <button class="achieved health-btn" id="<?php echo $health_goal['id'] ?>">Achieved</button>   
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="py-2 addGoal d-flex justify-content-center align-items-center">
                <button type="button" class="btn done" data-bs-toggle="modal" data-bs-target="#addGoalsHealth">
                    Add New Goal
                </button>
            </div>
            <div class="modal fade" tabindex="-1" id="addGoalsHealth">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                <div class="modal-content mm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Add new Goal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="Title" class="form-label">Goal Title</label>
                                <input type="text" id="health_title" class="form-control" class="form-control" placeholder="Enter your goal title here (Must be less than 25 characters)" required>
                            </div>
                        </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn done add-goal-health" id="health">Add Goal</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="goals-row">
        <div class="skills">
            <h2 class="text-white text-center box-text">Skills</h2>
            <?php if($skills_un == 0): ?>
                <h3 class="text-white text-center py-2">All Goals Achieved</h3>
            <?php else: ?>
                <div class="goal-page-list scroll">
                    <ul class="py-3 mx-6">
                        <?php foreach(mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $skills_query_un), MYSQLI_ASSOC) as $skill_goal ): ?>
                            <li>
                                <h4 class="text-white"><?php echo $skill_goal['title']; ?></h4>
                                <button class="achieved skill-btn" id="<?php echo $skill_goal['id'] ?>">Achieved</button>   
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="py-2 addGoal d-flex justify-content-center align-items-center">
                <button type="button" class="btn done" data-bs-toggle="modal" data-bs-target="#addSkill">
                    Add New Goal
                </button>
            </div>
            <div class="modal fade" tabindex="-1" id="addSkill">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                <div class="modal-content mm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Add new Goal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="Title" class="form-label">Goal Title</label>
                                <input type="text" id="skill_title" class="form-control" placeholder="Enter your goal title here (Must be less than 25 characters)" required>
                            </div>
                        </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn done add-goal-skill" id="skills">Add Goal</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="education">
            <h2 class="text-white text-center box-text">Education</h2>
            <?php if($education_un == 0): ?>
                <h3 class="text-white text-center py-2">All Goals Achieved</h3>
            <?php else: ?>
                <div class="goal-page-list scroll">
                    <ul class="py-3 mx-6">
                        <?php foreach(mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $education_query_un), MYSQLI_ASSOC) as $education_goal ): ?>
                            <li>
                                <h4 class="text-white"><?php echo $education_goal['title']; ?></h4>
                                <button class="achieved education-btn" id="<?php echo $education_goal['id'] ?>">Achieved</button>   
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="py-2 addGoal d-flex justify-content-center align-items-center">
                <button type="button" class="btn done" data-bs-toggle="modal" data-bs-target="#addeducation">
                    Add New Goal
                </button>
            </div>
            <div class="modal fade" tabindex="-1" id="addeducation">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                <div class="modal-content mm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Add new Goal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="Title" class="form-label">Goal Title</label>
                                <input type="text" id="education_title" class="form-control" placeholder="Enter your goal title here (Must be less than 25 characters)" required>
                            </div>
                        </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn done add-goal-education" id="edu">Add Goal</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="social"> 
            <h2 class="text-white text-center box-text">Social</h2>
            <?php if($social_un == 0): ?>
                <h3 class="text-white text-center py-2">All Goals Achieved</h3>
            <?php else: ?>
                <div class="goal-page-list scroll">
                    <ul class="py-3 mx-6">
                        <?php foreach(mysqli_fetch_all(mysqli_query($GLOBALS['cn'], $social_query_un), MYSQLI_ASSOC) as $social_goal ): ?>
                            <li>
                                <h4 class="text-white"><?php echo $social_goal['title']; ?></h4>
                                <button class="achieved social-btn" id="<?php echo $social_goal['id'] ?>">Achieved</button>   
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="py-2 addGoal d-flex justify-content-center align-items-center">
                <button type="button" class="btn done" data-bs-toggle="modal" data-bs-target="#addsocial">
                    Add New Goal
                </button>
            </div>
            <div class="modal fade" tabindex="-1" id="addsocial">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                <div class="modal-content mm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Add new Goal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="Title" class="form-label">Goal Title</label>
                                <input type="text" id="social_title" class="form-control" placeholder="Enter your goal title here (Must be less than 25 characters)" required>
                            </div>
                        </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn done add-goal-social" id="social">Add Goal</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>  
</div>

<script>

    <?php
    echo "var goalslabels = " . json_encode(array_keys($goals_un));
    echo ";";
    echo "var goalsdata1 =" . json_encode(array_values($goals_un));
    echo ";";
    echo "var goalsdata2 =" . json_encode(array_values($goals_ac));
    ?>

    const goalsChartData = {
        labels: goalslabels,
        datasets: [{
            label: 'Goals Achieved',
            data: goalsdata2,
            backgroundColor: 'rgba(255,255,255,0.5)',
            borderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(255, 99, 132)'
        },{
            label: 'Goals Unaccomplished',
            data: goalsdata1,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgb(255, 99, 132)',
            pointBackgroundColor: 'rgb(255, 99, 132)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(255, 99, 132)'
        }]

    };


    var goalsChart = new Chart(document.getElementById('totalGoalChart'), {
        type: 'radar',
        data : goalsChartData,
        options :{
            responsive : true,
            elements: {
                line: {
                    borderWidth: 2
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
                        display: false
                    }
                    
                }
            }
        }
        
    })


    //buttons
    $('.org-btn').click(function(e){
        e.preventDefault
        var box = confirm("Achieved this goal?");
        if(box){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'achieved_goal_org',
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

    $('.orgGoal').click(function(e){
        e.preventDefault
        var title = $('#org_goal_title').val()
        if(title.length > 0 && title.length < 25){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'add_org_goal',
                    title : title
                },  
                success : function(response){
                    location.reload()
                }
            })
        }else{
            e.preventDefault
            alert('Please meet the requirements')
        }
    })

    $('.health-btn').click(function(e){
        e.preventDefault
        var box = confirm("Achieved this goal?");
        if(box){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'achieved_goal',
                    type : 'health',
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

    $('.add-goal-health').click(function(e){
        e.preventDefault;
        var title = $('#health_title').val()
        if(title.length > 0 && title.length < 25){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'add_goal',
                    type : this.id,
                    goalId : '<?php echo $goal_id ?>' ,
                    title : title
                },  
                success : function(response){
                    location.reload()
                }
            })
        }else{
            e.preventDefault
            alert('Please meet the requirements')
        }
    })

    $('.skill-btn').click(function(e){
        e.preventDefault
        var box = confirm("Achieved this goal?");
        if(box){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'achieved_goal',
                    type : 'skills',
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

    $('.add-goal-skill').click(function(e){
        e.preventDefault;
        var title = $('#skill_title').val()
        if(title.length > 0 && title.length < 25){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'add_goal',
                    type : this.id,
                    goalId : '<?php echo $goal_id ?>' ,
                    title : title
                },  
                success : function(response){
                    location.reload()
                }
            })
        }else{
            e.preventDefault
            alert('Please meet the requirements')
        }
    })

    $('.education-btn').click(function(e){
        e.preventDefault
        var box = confirm("Achieved this goal?");
        if(box){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'achieved_goal',
                    type : 'edu',
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

    $('.add-goal-education').click(function(e){
        e.preventDefault;
        var title = $('#education_title').val()
        if(title.length > 0 && title.length < 25){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'add_goal',
                    type : this.id,
                    goalId : '<?php echo $goal_id ?>' ,
                    title : title
                },  
                success : function(response){
                    location.reload()
                }
            })
        }else{
            e.preventDefault
            alert('Please meet the requirements')
        }
    })

    $('.social-btn').click(function(e){
        e.preventDefault
        var box = confirm("Achieved this goal?");
        if(box){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'achieved_goal',
                    type : 'social',
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

    $('.add-goal-social').click(function(e){
        e.preventDefault;
        var title = $('#social_title').val()
        if(title.length > 0 && title.length < 25){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data: {
                    action : 'add_goal',
                    type : this.id,
                    goalId : '<?php echo $goal_id ?>' ,
                    title : title
                },  
                success : function(response){
                    location.reload()
                }
            })
        }else{
            e.preventDefault
            alert('Please meet the requirements')
        }
    })

</script>


<?php 
}
require_once 'layout.php';