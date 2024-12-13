<?php
include ("database.php");


if(isset($_GET['user_id'])){
    $project_id = $_GET['user_id'];
    $sql = "DELETE FROM projects WHERE project_id = '$project_id'";   
    $query = mysqli_query($connect, $sql);

    if(!$query ){
        die ("There's an Error!");

    }
    else{
        header('Location:projects.php?delete_error=You delete a record');
    }

}

?>

