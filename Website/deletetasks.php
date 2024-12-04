<?php
include ("database.php");


if(isset($_GET['user_id'])){
    $task_id = $_GET['user_id'];
    $sql = "DELETE FROM tasks WHERE task_id = '$task_id'";   
    $query = mysqli_query($connect, $sql);

    if(!$query ){
        die ("There's an Error!");

    }
    else{
        header('Location:task.php?delete_error=You delete a record');
    }

}

?>

