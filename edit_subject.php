<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php"); ?>


<?php

    if(intval($_GET['subj']) == 0) {
        redirect_to("content.php");
    }
    if(isset($_POST['submit'])){
        $errors = array();

        //form validation
        $required_fields= array('menu_name', 'position', 'visible');
        foreach($required_fields as $fieldname){
            if(!isset ($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] != 0 )) {
            $errors[] = $fieldname;    
            }
        }

        $fields_with_lengths = array('menu_name' => 30);
        foreach($fields_with_lengths as $fieldname => $maxlength ){
            if (strlen(strip_tags($_POST[$fieldname])) > $maxlength) {
                $errors[] = $fieldname;
            }
            }

            if(empty($errors)){
            $id = stripslashes($_GET['subj']); 
            $menu_name= stripslashes($_POST['menu_name']);
            $position = stripslashes($_POST['position']);
            $visible = stripslashes($_POST['visible']);
           
            $query = "update subject SET 
                      menu_name = '{$menu_name}', 
                      position = {$position}, 
                      visible = {$visible} 
                      WHERE id = {$id}";
            $result = $connection->query($query); 
            
            if (mysqli_affected_rows($connection) == 1) {
                //Success
                $message = "The subject was successfully updated.";
            }else{
                 //failed 
                 $message="The subject update failed";
                 $message="<br/>". mysql_error();
            }
        }
            else{
                //errors occurred
                $message= "There were" . count($errors) . " error in the form."; 
            }
        }
?>
<?php find_selected_page(); ?>
<?php include("includes/header.php"); ?>
    <table id="structure">
        <tr>
            <td id="navigation">
                <?php echo navigation($sel_subject, $sel_page)?>
            </td>
            <td id="page">
               <h2> Edit Subject: <?php echo $sel_subject['menu_name']; ?></h2>
               <?php 
                if(!empty($message)){
                 echo "<p class = \"message\" >" . $message . "</p>";
                } 
                ?>
                <?php 
                if(!empty($errors)){
                    echo "<p class=\"errors\">";
                    echo "Please review the following fields:<br/>";
                    foreach($errors as $error){
                        echo " - " . $error . "<br/>";
                    }
                    echo "</p>";
                }
                ?>
               <form action="edit_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>" method="POST">
                    <p>Subject name:
                        <input type="text" name="menu_name" value="<?php echo $sel_subject['menu_name'];?>" id="menu_name" />
                    </p>
                    <p>Position:
                        <select name="position">
                            <?php
                            $subject_set= get_all_subjects();
                            $subject_count = mysqli_num_rows($subject_set);
                            for($count=1; $count <= $subject_count+1; $count++){
                                echo "<option value=\"{$count}\"";
                                if($sel_subject['position']== $count){
                                    echo" selected";
                                }
                                echo ">${count}</option>";
                            }
                            ?>
                        </select>
                    </p>
                    <p>Visible:
                        <input type="radio" name="visible" value="0"
                        <?php if($sel_subject['visible'] == 0) {echo "  checked";} ?> /> No
                        <input type="radio" name="visible" value="1" 
                        <?php if($sel_subject['visible'] == 1) {echo "  checked";} ?>/> Yes
                    </p>
                    <input type="submit" name = "submit" value = "Edit Subject" />

                    &nbsp;&nbsp;
                    <a href="delete_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>">Delete Subject</a>
                </form>
               <br/>
            <a href = "content.php">Cancel</a>               
            </td>        
            </tr>
    </table>
<?php require("includes/footer.php")?>