<form class="p-4 p-md-5 border rounded-3 bg-light" action="" method="post">
    <div class="form-floating mb-3">
        <select class="form-select" aria-label="Default select example">
            <?php
            $types = Type::getAll($link);
            foreach($types as $type){
                echo("<option value='" . $type->id . "'>" . $type->name . "</option>\n");
            }
            ?>
        </select>
        <label for="floatingInput">I'm looking for a</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Search</button>
</form>