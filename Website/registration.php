<?php
    include "database.php";   

    if (isset($_POST['signup'])){
      $username = $_POST['username'];
      $email =  $_POST['email'];
      $pass =  $_POST['password'];
      $confirmpass =  $_POST['confirm_password'];
      $dupilcate = mysqli_query($connect, "SELECT * FROM registration WHERE user_name = '$username' OR email = '$email'");

      if (mysqli_num_rows($dupilcate) > 0){
        echo '<div id ="delete-alert" role="alert" class="alert alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Theres a dupilcated Email or Username. Error!</span>
      </div>';
      }
      else if($pass != $confirmpass){
          echo '<div id ="delete-alert" role="alert" class="alert alert-error">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Error! Password Doesnt Match!.</span>
        </div>';
      }
      else{
          $sql = "INSERT INTO registration (user_name, email, password) VALUES ('$username', '$email',' $pass')"; 
          mysqli_query($connect, $sql); 
          echo '<div id ="success-alert" role="alert" class="alert alert-success">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Your Successfully Registered!</span>
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
    <title>Create Account</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(
                to bottom,
                #e1b382, /* Sand Tan */
                #c89666, /* Sand Tan Shadow */
                #2d545e, /* Night Blue */
                #12343b  /* Night Blue Shadow */
            );
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            color: black;
            text-align: center;
        }
        h1 {
            font-size: 3rem;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
        }
        p {
            font-size: 1.2rem;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            line-height: 1.6;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .form-control label {
            font-weight: bold;
            color: white;
        }
        .form-control input {
            margin-top: 5px;
        }
        .form-control mt-6 {
            margin-top: 20px;
        }
        #sign-up {
            background-color: #c89666;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #sign-up:hover {
            background-color: #e1b382;
        }
    </style>
</head>
<body>
  <div class="hero min-h-screen">
    <div class="hero-content flex-col lg:flex-row-reverse">
      <div class="text-center lg:text-left">
        <h1 class="text-5xl font-bold">Register Now!</h1>
        <p class="py-6">Liwanag Solutions is here to bring light and innovation to your business. Please fill in your details below to get started on a brighter journey with us!</p>
      </div>
      <div class="card bg-neutral w-full max-w-sm shrink-0 shadow-2xl">
        <form class="card-body" method="post" action="">
          <div class="form-control">
            <label class="label">
              <span class="label-text text-white">Username</span>
            </label>
            <input type="text" name="username" placeholder="username" class="input input-bordered" required />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text text-white">Email</span>
            </label>
            <input type="email" name="email" placeholder="email" class="input input-bordered" required />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text text-white">Password</span>
            </label>
            <input type="password" name="password" placeholder="password" class="input input-bordered" required />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text text-white">Confirm Password</span>
            </label>
            <input type="password" name="confirm_password" placeholder="Confirm Password" class="input input-bordered" required />
            <label class="label">
              <a href="#" class="label-text-alt link link-hover text-white">Forgot password?</a>
              <a href="login.php" class="btn btn-primary text-white">Login</a>
            </label>
          </div>
          <div class="form-control mt-6">
            <input type="submit" name="signup" value="Sign up" id="sign-up">
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
