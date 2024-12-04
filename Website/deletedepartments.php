<?php
include ("database.php");


if(isset($_GET['user_id'])){
    $department_id = $_GET['user_id'];
    $sql = "DELETE FROM departments WHERE user_id = '$department_id'";   
    $query = mysqli_query($connect, $sql);

    if(!$query ){
        die ("There's an Error!");

    }
    else{
        header('Location:department.php?delete_error=You delete a record');
    }

}

?>

