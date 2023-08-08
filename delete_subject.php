<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php"); ?>
<?php
    if(intval($_GET['subj']) == 0) {
        redirect_to("content.php");
    }

    $id = stripslashes($_GET['subj']); 

    if($subject = get_subject_by_id($id)){
      
        $query= "delete from subject where id = {$id} limit 1";
        $result = $connection->query($query);
        if(mysqli_affected_rows($connection) == 1){
            redirect_to("content.php");
        }else{
            echo "<p>subject deletion failed.</p>";
            echo "<p>".mysql_error()."</p>";
            echo "<a href = \"content.php\">Return to the main page</a>";
        }
    } else{
        redirect_to("content.php");
    }
?>
<?php
mysqli_close($connection);
?>