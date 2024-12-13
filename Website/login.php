<?php
include "database.php";
if (isset($_POST['submit'])) {
  $usernameemail = $_POST['usernameemail'];
  $pass = $_POST['password'];
  $result = mysqli_query($connect, "SELECT * FROM registration WHERE user_name = '$usernameemail' OR email = '$usernameemail'");
  $row = mysqli_fetch_assoc($result);

  if(mysqli_num_rows($result) > 0){
    if($pass == trim($row["password"])){
      $_SESSION["login"] = true;
      $_SESSION["user_id"] = $row ["user_id"];
      header("Location: dashboard.php");

    }
    else{
      echo '<div id ="delete-alert" role="alert" class="alert alert-error">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6 shrink-0 stroke-current"
        fill="none"
        viewBox="0 0 24 24">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <span>Wrong Password!. Error!</span>
    </div>';
    }

  }else{
    echo '<div id ="delete-alert" role="alert" class="alert alert-error">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-6 w-6 shrink-0 stroke-current"
      fill="none"
      viewBox="0 0 24 24">
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>User not Registered!. Error!</span>
  </div>';

  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.12/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="reg.css">
    <title>Login Page!</title>
</head>
<body>
<div class="hero min-h-screen">
  <div class="hero-content flex-col lg:flex-row ">
    <div class="text-center lg:text-left ">
      <h1 class="text-5xl font-bold">Login now!</h1>
      <p class="py-6 text-white">
        Welcome to Our Login Page, Liwanag Solutions..
      </p>
    </div>
    <div class="card bg-light w-full max-w-sm shrink-0 shadow-2xl shadow-lg p-3 mb-5 bg-body rounded">
      <form class="card-body " method="post" action="">
        <div class="form-control">
          <label class="label ">
            <span class="label-text text-white">Email</span>
          </label>
          <input type="text" name="usernameemail" id="usernameemail" placeholder="email" class="input input-bordered" required />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-white">Password</span>
          </label>
          <input type="password" name="password" id="password" placeholder="password" class="input input-bordered" required />
          <label class="label">
            <a href="#" class="label-text-alt link link-hover text-white">Forgot password?</a>
            <a href="registration.php" class="label-text-alt link link-hover text-white">Create Account</a>
          </label>
        </div>
        <div class="form-control mt-6">
          <button type="submit" name="submit" class="btn btn-primary">Log In</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#delete-alert, #success-alert").fadeOut("slow", function() {
                $(this).remove();
            });
        }, 2000);
    });
</script>
<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
