<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php"); ?>

<?php
    $menu_name= $_POST['menu_name'];
    $position = $_POST['position'];
    $visible = $_POST['visible'];
?>

<?php 
$query = "insert into subject (menu_name, position, visible) values ('{$menu_name}', {$position}, {$visible})";

$result_set = $connection->query($query);
if($result_set){
    header("Location: content.php");
    exit;
} else {
    echo "<p>Subject creation failed.</p>";
    echo "<p>" . mysql_error(). "</p>";
}
?>

<?php
mysqli_close($connection);
?>