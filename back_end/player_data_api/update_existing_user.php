<?php
if(empty($_POST['user_ID'])){
    $output['errors'][] = 'missing user_ID';
    return;
}

$keys_we_are_looking_for = ['first_name', 'fav_genre', 'about_me'];

$things_to_update_unesc = [];

foreach($keys_we_are_looking_for as $key){
    if(array_key_exists($key, $_POST)){
        $things_to_update_unesc[$key] = addslashes($_POST[$key]);
//        print("I think the key is ".$key);
    }
}

if(empty($things_to_update_unesc)){
    $output['errors'][] = 'nothing to update';
    return;
}

$query = "UPDATE `users` SET";

foreach($things_to_update_unesc as $key => $value){
    $queryArr[] = " `{$key}` = '{$value}'";
}
$query.= implode(',' , $queryArr)." WHERE `user_ID` = '{$_POST['user_ID']}';";

$result = null;
$result = mysqli_query($conn, $query);

if(empty($result)){
    $output['errors'][] = 'database error';
} else {
    if(mysqli_affected_rows($conn)){
        $query2 = "SELECT `first_name`, `fav_genre`, `about_me` FROM `users` WHERE `user_ID` = '{$_POST['user_ID']}'";
        $result2 = null;
        $result2 = mysqli_query($conn, $query2);

        if(empty($result2)){
            $output['errors'][] = 'problem retrieving updated data';
        } else {
            if(mysqli_num_rows($result2)){
//                $output['data'] = [];
                while($row = mysqli_fetch_assoc($result2)){
                    $output['data'] = $row;
                }
                //make sure retrieve_past_activity.php is included AFTER first retrieving the user row data (thanks Collette!)
                require_once('retrieve_past_activity.php');
                $output['success'] = true;

            } else {
                $output['errors'][] = 'no data';
            }
        }

    } else {
        $output['errors'][] = 'update error: '.mysqli_error($conn);
    }

}