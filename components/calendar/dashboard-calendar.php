<?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["timetable_id"]) && isset($_POST["timetable_id"])){
        $clicked_timetable = Timetable::getById($link, $_POST["timetable_id"]);
        if($clicked_timetable->available){
            $clicked_timetable->delete($link);
        } else {
            $appointment = Appointment::getByTimetableId($link, $clicked_timetable->id);
            if($appointment != null){
                $appointment->delete($link);
            }
        }
    }

    $timetables = Timetable::getDoctorTimetables($link, $doctor->id, true)
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
            selectHelper: false,
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
            droppable: false, // this allows things to be dropped onto the calendar !!!
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
                    $classname = 'info';
                    $booker_name = "Available";

                    $appointment = null;
                    if(!$timetable->available){
                        $appointment = Appointment::getByTimetableId($link, $timetable->id);
                        $user = $appointment->getUser($link);
                        $booker_name = $user->first_name . " " . $user->name;

                        $classname = 'important';
                    }

                    echo("{\n");
                    echo("id: " . $timetable->id . ",\n");
                    echo("title: '" . ($timetable->available ? "Available" : $booker_name) . "',\n");
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

    function clicked(timetableSlot){
        document.querySelector('#modal_timetable_value').value = timetableSlot.id;
        $('#confirmModal').modal('show');
    }

    function redirectPost(url, data) {
        var form = document.createElement('form');
        document.body.appendChild(form);
        form.method = 'post';
        form.action = url;
        for (var name in data) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = data[name];
            form.appendChild(input);
        }
        form.submit();
    }
</script>

<div id='wrap'>
    <div id='calendar'></div>
    <div style='clear:both'></div>
</div>

<div class="modal fade" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You are about to cancel/delete this availability, do you want to continue ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
                    <input type='hidden' name='timetable_id' value='-1' id="modal_timetable_value">
                    <button class='btn btn-danger' type='submit'>Cancel/Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>