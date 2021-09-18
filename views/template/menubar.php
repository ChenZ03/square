<div class="menubar">
    <img src="/assets/image/Logo.png" alt="#" class="mx-auto py-5">
    <div class="icons py-4 mx-auto text-center">
        <i class="bi bi-x-diamond-fill" id="overview"></i>
        <p class= "text" id="overview_text">OVERVIEW</p>
    </div>
    <div class="icons py-4 mx-auto text-center">
        <i class="bi bi-check-square-fill" id="task"></i>
        <p class="text" id="task_text">TASK</p>
    </div>
    <div class="icons py-4 mx-auto text-center">
        <i class="bi bi-calendar-event-fill" id="calendar"></i>
        <p class="text" id="calendar_text">CALENDAR</p>
    </div>
    <div class="icons py-4 mx-auto text-center">
        <i class="bi bi-award-fill" id="goals"></i>
        <p class="text" id="goals_text">GOALS</p>
    </div>
    <div class="icons py-4 mx-auto text-center">
        <i class="bi bi-wallet-fill" id="wallet"></i>
        <p class="text" id="wallet_text">WALLET</p>
    </div>
    <div class="icons py-4 mx-auto text-center">
        <i class="bi bi-door-open-fill" id="logout"></i>
    </div>
</div>

<script>
    $('#overview').click(function(e){
        $('.text').not($('#overview_text')).hide('slow')
        $('#overview_text').show('slow')
    })

    $('#task').click(function(e){
        $('.text').not($('#task_text')).hide('slow')
        $('#task_text').show('slow')
    })

    $('#calendar').click(function(e){
        $('.text').not($('#calendar_text')).hide('slow')
        $('#calendar_text').show('slow')
    })

    $('#goals').click(function(e){
        $('.text').not($('#goals_text')).hide('slow')
        $('#goals_text').show('slow')
    })

    $('#wallet').click(function(e){
        $('.text').not($('#wallet_text')).hide('slow')
        $('#wallet_text').show('slow')
    })

</script>