$(document).ready(function(){

    $('.datepicker').datepicker({
        autoclose: true
    }).on('changeDate', function(ev) {
        (ev.viewMode == 'days') ? $(this).datepicker('hide') : '';
    }).data('datepicker');
    
});