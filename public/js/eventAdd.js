$(document).ready( function () {
    moment.locale('fr');
    $('#event_beginsAt').datetimepicker({
        format: 'YYYY/MM/DD HH:mm',
        useCurrent: false,
        widgetPositioning : {
            horizontal: 'auto',
            vertical: 'top',
        },
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
        },
        minDate : {
            moment : true
        }
    });
    $('#event_endsAt').datetimepicker({
        format: 'YYYY/MM/DD',
        useCurrent: false,
        widgetPositioning : {
            horizontal: 'auto',
            vertical: 'top',
        },
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
        },
        minDate : {
            moment : true
        }
    });

    $("#event_endsAt").on("change.datetimepicker", function (e) {
        $('#event_beginsAt').datetimepicker('minDate', e.date);
    });
    $("#event_beginsAt").on("change.datetimepicker", function (e) {
        $('#event_endsAt').datetimepicker('maxDate', e.date);
    });
});