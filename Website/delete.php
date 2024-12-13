<?php
include ("database.php");


if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    $sql = "DELETE FROM registration WHERE user_id = '$user_id'";   
    $query = mysqli_query($connect, $sql);

    if(!$query ){
        die ("There's an Error!");

    }
    else{
        header('Location:index.php?delete_error=You delete a record');
    }

}

?>

