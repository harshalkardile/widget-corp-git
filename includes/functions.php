<?php

//get_magic_quotes_gpc() is deprecated in the following function
// function mysql_prep($value){
//     $magic_quotes_active = get_magic_quotes_gpc();
//     $new_enough_php = function_exists("mysql_real_escape_string");
//     if($new_enough_php){
//         if($magic_quotes_active){
//             $value = stripslashes($value);
//         }
//         $value=mysql_real_escape_string($value);
//         }
//         else {
//              if(!magic_quotes_active){
//                 $value=addslashes($value);
//              }
//         }
//         return $value;
//     }
    

function redirect_to( $location = NULL ){
    if($location!=NULL) {
        header("Location:{$location}");
        exit;
    }
}
function confirm_query($result_set){

    if(!$result_set){
        die("database query failed:" + mysql_error());
    }
}

function get_all_subjects(){
    global $connection;
    $query='select * from subject order by position asc';
    $subject_set = $connection->query($query);
    confirm_query($subject_set);
    return $subject_set;
}

function get_pages_for_subject($subject_id){
    global $connection;
    $query="select * from pages where subject_id = {$subject_id} order by position asc";
    $page_set = $connection->query($query);
    confirm_query($page_set);
    return $page_set;
}

function get_subject_by_id($subject_id){
    global $connection;
    $query= "select * from subject where id=". $subject_id." limit 1";
    $result_set = $connection->query($query);
    confirm_query($result_set);

    if($subject = $result_set->fetch_assoc()){
        return $subject;
    }
    else{
        return NULL;
    }
}

function get_page_by_id($page_id){
    
        global $connection;
        $query= "select * from pages where id=". $page_id." limit 1";
        $result_set = $connection->query($query);
        confirm_query($result_set);
    
        if($page = $result_set->fetch_assoc()){
            return $page;
        }
        else{
            return NULL;
        }
}

function find_selected_page(){
    global $sel_page;
    global $sel_subject;
    if(isset($_GET['subj'])){
        $sel_subject = get_subject_by_id($_GET['subj']);
        $sel_page = NULL;  
    } 
    elseif(isset($_GET['page'])){
        $sel_subject = NULL;
        $sel_page = get_page_by_id($_GET['page']);
    }
    else{
        $sel_subject=NULL;
        $sel_page=NULL;
    }
}

function navigation($sel_subject, $sel_page){
    $output = "<ul class=\"subjects\">";
  
    
    $subject_set = get_all_subjects();
                        
    while ($subject = $subject_set->fetch_assoc()) {
    
        $output .= "<li";
        
        if($subject["id"]== $sel_subject){
            $output .= " class=\"selected\"";
        }                      
        
        $output .= "><br><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]). "\">{$subject["menu_name"]}</a></li>"; 

            $page_set = get_pages_for_subject($subject["id"]);

            $output .= "<ul class=\"pages\">";
            while ($page = $page_set->fetch_assoc()) {
                $output .=  "<li";
                if($page["id"]== $sel_page){
                    $output .= " class= \"selected\"";
                }  
                
                $output .= "><a href=\"content.php?page=". urlencode($page["id"]). "\"> {$page["menu_name"]} </a></li>" ;
            }
            $output .= "</ul>";    
    }  
    $output .= "</ul>";
    return $output;
}
?>