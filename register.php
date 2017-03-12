<?php


  $title = "Register";
  $headerMsg = "Register Page";
  $errorMessage = null;
  $successMessage = null;
  include("inc/header.php");



  if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty($_POST["username"])) {
      $errorMessage.= "username,";
    }

    if(empty($_POST["password"])) {
      $errorMessage.= "password, ";
    }

    if(empty($_POST["email"])) {
      $errorMessage.= "email";
    }

    if($_POST["password"] != $_POST["verifypassword"]) {
      $errorMessage.= " The two passwords do not match";
    }

    if(empty($errorMessage)) {
      // Don't trust inputs from the user. Always sanitize the inputs
      $username = filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING);
      $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
      $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
      $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

      try {
        include("inc/database.php");
        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO users VALUES(NULL,:username,:password,:email)");
        $statement->bindParam(":username",$username,PDO::PARAM_STR);
        $statement->bindParam(":password",$hashedPassword,PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();

        $successMessage = "Successfully registered! You may now login <a href='login.php'>here...</a>";
        Database::disconnect();
      } catch(Exception $e) {

        if($e->errorInfo[1] == 1062) {
          $errorMessage.= "Username or Email is already taken";
        }

      }

    }

  }


 ?>
 <body>
   <div class="container">

      <?php

         if(!empty($errorMessage)) {

           $msg = "Following errors: ".$errorMessage;

            echo "<div class='alert alert-danger' role='alert'>
                    $msg;
                  </div>";
        }

        if(!empty($successMessage)) {
          echo "<div class='alert alert-success' role='alert'>
                  $successMessage
                </div>";
        }


      ?>

     <form action="register.php" method="POST">
       <div class="form-group">
         <label for="username">Username</label>
         <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
       </div>

       <div class="form-group">
         <label for="password">Password</label>
         <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
       </div>

       <div class="form-group">
         <label for="verifypassword">Verify Password</label>
         <input type="password" class="form-control" id="verifypassword" placeholder="verify password" name="verifypassword">
       </div>


       <div class="form-group">
         <label for="email">Email</label>
         <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
       </div>

       <button class="btn btn-secondary btn-lg" type="button submit">Register</button>

       <div class="message-box">
         <h3>Already have an account?</h3>
         <a href="login.php" class="card-link">Login Here...</a>
       </div>


     </form>



   </div>

 </body>
