<?php
$title = 'Events';
require_once '../controller/connection.php';

function get_content(){
    $userId = $_SESSION['user_data']['user_id'];
    $org = $_SESSION['user_data']['organization'];
    $isAdmin = $_SESSION['user_data']['isAdmin'];
?>

<div class="content d-flex">
    <div class="calendar">
        <div class="d-flex" style="margin-left: 20px;">
            <select class="form-select calendar-select" aria-label="Month select" id="cal">
                <option selected disabled>Select month </option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <button class="done cal-select">Select</button>
        </div>
        <div class="d-flex cal-num">
            <?php for($i = 1; $i < 32; $i++): ?>
                <div class="btn-box" style="width: 15%; margin-bottom:20px; margin-left:30px" >
                    <button class="cal-btn" id="<?php echo $i ?>"><?php echo $i ?></button>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <div class="event-details">
        <h2 class="text-white text-center box-text">Event Details</h2>
        <div class="details scroll">
            <div class="events-text scroll">
                <ol class="event-list-ajax">
                    
                </ol>
            </div>
            
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn done" data-bs-toggle="modal" data-bs-target="#addEventModal">
                Add New Event
            </button>
        </div>
        <div class="modal fade" tabindex="-1" id="addEventModal">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                    <div class="modal-content mm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title">Add new Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="Title" class="form-label">Event Title</label>
                                    <input type="text" id="event_title" class="form-control" placeholder="Enter your event title here (Must be less than 25 characters)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="desc" class="form-label">Event Description</label>
                                    <input type="text" id="desc" class="form-control" placeholder="Enter your event description here" required>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" min="<?= date('Y-m-d'); ?>" id="date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="assign" class="form-label"> Add Event To: </label>
                                    <select class="form-select" size="1" id="assign">
                                        <option selected disabled>Select who to add event to </option>
                                        <option value="self">Self</option>
                                        <?php if($isAdmin): ?>
                                            <option value="organization">Organization</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                               
            
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close">Close</button>
                            <button type="button" class="btn done two">Add Event</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>

    $('.cal-select').click(function(e){
        e.preventDefault;
        var month = $('#cal').val();
        if(month != null){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data:{
                    action: 'get_event',
                    month : month
                },
                dataType: 'json',
                success: function(response){
                    $('.cal-btn').css('background-color', 'transparent')
                    for(let i of response){
                        $('#' + i).css('background-color' , '#CD3E71')
                    }
                }
            })
        }
    })
    
    $('.cal-btn').click(function(e){
        e.preventDefault;
        var month = $('#cal').val();
        var id = this.id;
        if(month != null){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data:{
                    action: 'get_event_details',
                    month : month,
                    day : id
                },
                dataType : 'json',
                success: function(response){
                    $('.event-list-ajax').remove()
                    $('.events-text').append("<ol class='event-list-ajax'></ol>")
                    response.forEach(function(value, i){
                        $('.event-list-ajax').append("<ul class='item-" + i  + "'>" + "<h4 class='text-white bold'>" +value['title']+ "</h4>" +"</ul>")
                        $('.item-' + i).append("<li> <strong>Description :   </strong>" +  value['desc'] + "</li>")
                        $('.item-' + i).append("<li> <strong>Date :   </strong>" +  value['date'] + "</li>")
                    })
                },
                error: function(er){
                    console.log(er)
                }
            })
        }    
    })

    $('.two').click(function(e){
        e.preventDefault;
        var title = $('#event_title').val()
        var desc = $('#desc').val()
        var date = $('#date').val()
        var assign = $('#assign').val()
        if((title.length > 0 && title.length < 25) && (desc.length > 0 && desc.length < 30) && date.length > 0 && assign.length > 0){
            $.ajax({
                type: 'post',
                url: '../controller/chart.php',
                data:{
                    action: 'add_event',
                    title :title,
                    desc : desc,
                    date: date,
                    assign : assign,
                },
                success: function(response){
                    alert('Successfully added a new event !');
                    console.log(response)
                    $('#close').click()
                }
            })
        }else{
            alert('Please meet all the requirements');
        }
    })

</script>


<?php
}
require_once 'layout.php';