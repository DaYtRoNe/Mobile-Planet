<?php

require "connection.php";

if (isset($_GET["d"])) {

    $category_id = $_GET["d"];

    $subcat_rs = Database::search("SELECT * FROM `sub_category` WHERE `category_cat_id`='" . $category_id . "'");

    $subcat_num = $subcat_rs->num_rows;

    for ($i = 0; $i < $subcat_num; $i++) {

        $subcat_data = $subcat_rs->fetch_assoc();

?>

        <option value="<?php echo $subcat_data["subcat_id"]; ?>"><?php echo $subcat_data["subcat_name"]; ?></option>

<?php

    }
}

?>