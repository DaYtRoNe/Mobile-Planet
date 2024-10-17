<?php

require "connection.php";

if(isset($_GET["m"])){

    $category_id = $_GET["m"];

    $category_rs = Database::search("SELECT * FROM `model` WHERE `category_cat_id`='".$category_id."'");

    $category_num = $category_rs->num_rows;

    for($i = 0; $i < $category_num; $i++){

        $category_data = $category_rs->fetch_assoc();

        $model_rs = Database::search("SELECT * FROM `model` WHERE `model_id`='".$category_data["model_id"]."'");

        $model_data = $model_rs->fetch_assoc();

        ?>

<option value="<?php echo $model_data["model_id"]; ?>"><?php echo $model_data["model_name"]; ?></option>

        <?php

    }

}

?>