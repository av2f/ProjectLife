// customize datepicker
$(document).ready(function(){
    $('.js-datepicker').datepicker({
        container: '#date-container',
        format: 'dd-mm-yyyy',
        language: 'fr',
        orientation: 'top auto',
        startView: 2,
        endDate: '-18y',
        startDate: '-105y',
    });
});