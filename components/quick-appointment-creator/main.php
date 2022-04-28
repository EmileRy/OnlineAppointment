<?php
    $default_value = "No date selected";
    $added = false;
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["date"]) && $_POST["date"] != $default_value && isset($_POST["duration"])){
        $added = true;
        $date = new DateTime($_POST["date"]);
        $duration = $_POST["duration"];

        $timetable = new Timetable($doctor->id, $date->format("Y-m-d H:i:00"), $duration);
        $timetable->save($link);
    }
?>
<div class="alert alert-success alert-dismissible fade show<?php echo($added ? "" : " visually-hidden") ?>" role="alert">
    Your availability has been added.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<div class="card" style="margin-bottom: 20px;">
    <div class="card-body">
        <h5 class="card-title">Quick add</h5>
        <p class="card-text">Quickly add an availibility</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" name="date" id="date-selector-input" value="<?php echo($default_value) ?>" aria-describedby="button-addon2" readonly="readonly">
                <button class="btn btn-outline-secondary" id="date-selector-button" type="button" id="button-addon2">Select</button>
            </div>
            <select class="form-select form-select-sm mb-3" name="duration" required>
                <option value="">Choose the duration</option>
                <option value="30">30 minutes</option>
                <option value="60">1 hour</option>
                <option value="90">1 hour 30 minutes</option>
                <option value="120">2 hours</option>
            </select>
            <button type='submit' class='btn btn-outline-primary w-100'>Add</button>
        </form>
    </div>
</div>

<script>
    let simplepicker = new SimplePicker({
        zIndex: 10
    });

    simplepicker.reset(roundToNearestHour(new Date()));

    const $button = document.querySelector('#date-selector-button');
    const $input = document.querySelector('#date-selector-input');
    $button.addEventListener('click', (e) => {
        simplepicker.open();
    });

    simplepicker.on('submit', (date, readableDate) => {
        $input.value = readableDate;
    });

    function roundToNearestHour(date) {
        date.setMinutes(date.getMinutes() + 30);
        date.setMinutes(0, 0, 0);

        return date;
    }
</script>