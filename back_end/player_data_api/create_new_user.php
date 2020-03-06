<?php

//check if we have all the data we need from the client-side
if (empty($_POST['first_name']) || empty($_POST['email']) || empty($_POST['fb_ID'])){
    //TODO: make this a little bit cleaner
    $output['errors'][] = 'Missing input:';
    if (empty($_POST['first_name']))
        $output['errors'][] = 'first name';
    if (empty($_POST['email']))
        $output['errors'][] = 'email';
    if (empty($_POST['fb_ID']))
        $output['errors'][] = 'facebook ID';
    return;
//    $output['errors'][] = 'But it\'s ok I\'ll try to add your entry to the database anyway....for now';
}

$first_name = $_POST['first_name'];
$email = $_POST['email'];
$fb_ID = $_POST['fb_ID'];

$new_person_query = "INSERT INTO `users` SET `first_name` = '$first_name', `email`='$email', `fb_ID`='$fb_ID', `fav_genre`='Family'";
//print($new_person_query);
$result = mysqli_query($conn, $new_person_query);

//first check if $result is empty
if(empty($result)){
    //tell the front end
    $output['errors'][] = 'database error: '.mysqli_error($conn);
//    $output['errors'][] = 'attempted query: '.$new_person_query;
} else {
    //make sure 1 row was affected
    if (mysqli_affected_rows($conn)){
        $output['success'] = true;
        $output['data']['user_ID'] = mysqli_insert_id($conn);
    }
    else{
        $output['errors'][] = 'I tried inserting a new user but something went wrong';
    }
}