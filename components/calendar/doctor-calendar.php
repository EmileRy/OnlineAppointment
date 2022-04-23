<?php
    $timetables = Timetable::getDoctorTimetables($link, trim($_POST["doctor_id"]))
?>
<script>
    $(document).ready(function () {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#external-events div.external-event').each(function () {
            var eventObject = {
                title: $.trim($(this).text())
            };
            $(this).data('eventObject', eventObject);
            $(this).draggable({
                zIndex: 999,
                revert: true,
                revertDuration: 0
            });
        });

        var defaultViewValue = "agendaWeek";
        if(window.innerWidth < 992){
            defaultViewValue = "agendaDay";
        }

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'title',
                //center: 'agendaDay,agendaWeek,month',
                right: 'prev,next today'
            },
            editable: false,
            firstDay: 1,
            selectable: false,
            defaultView: defaultViewValue,

            axisFormat: 'h:mm',
            columnFormat: {
                month: 'ddd',    // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy' // Tuesday, Sep 8, 2009
            },
            allDaySlot: false,
            selectHelper: true,
            select: function (start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                        true
                    );
                }
                calendar.fullCalendar('unselect');
            },
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },

            events: [
                <?php
                foreach ($timetables as $timetable){
                    $date = new DateTime($timetable->date);
                    $end_date = new DateTime($timetable->date);
                    date_add($end_date, date_interval_create_from_date_string($timetable->duration . ' minutes'));
                    $doctor = $timetable->getDoctor($link);
                    $doctor_user = $doctor->getUser($link);
                    $classname = 'success';
                    if(!$timetable->available){
                        $classname = 'important';
                    }

                    echo("{\n");
                    echo("id: " . $timetable->id . ",\n");
                    echo("title: '" . ($timetable->available ? "Available" : "Unavailable") . "',\n");
                    echo("start: new Date(". $date->format('Y') . ", " . intval($date->format('n'))-1 . ", " . $date->format('j, G, i') ."),\n");
                    echo("end: new Date(". $end_date->format('Y') . ", " . intval($end_date->format('n'))-1 . ", " . $end_date->format('j, G, i') ."),\n");
                    echo("allDay: false,\n");
                    echo("className: '" . $classname . "'");
                    echo("},\n");
                }
                ?>
            ],
        });
    });
</script>

<div id='wrap'>
    <div id='calendar'></div>
    <div style='clear:both'></div>
</div>