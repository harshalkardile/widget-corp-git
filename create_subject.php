<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php"); ?>

<?php
    $errors = array();

    //form validation
    $required_fields= array('menu_name', 'position', 'visible');
    foreach($required_fields as $fieldname){
        if(!isset ($_POST[$fieldname]) || empty($_POST[$fieldname])) {
        $errors[] = $fieldname;    
        }
    }
    $fields_with_lengths = array('menu_name' => 30);
    foreach($fields_with_lengths as $fieldname => $maxlength ){
        if (strlen(strip_tags($_POST[$fieldname])) > $maxlength) {
            $errors[] = $fieldname;
        }
        }
    if(!empty($errors)){
        redirect_to("new_subject.php");
    }
?>

<?php
    $menu_name= stripslashes($_POST['menu_name']);
    $position = stripslashes($_POST['position']);
    $visible = stripslashes($_POST['visible']);
?>

<?php 
    $query = "insert into subject (menu_name, position, visible) values ('{$menu_name}', {$position}, {$visible})";

    $result_set = $connection->query($query);
    if($result_set){
        redirect_to("content.php");

    } else {
        echo "<p>Subject creation failed.</p>";
        echo "<p>" . mysql_error(). "</p>";
    }
?>

<?php
mysqli_close($connection);
?>