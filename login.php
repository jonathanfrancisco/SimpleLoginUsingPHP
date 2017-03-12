<?php
  session_start();
  $title = "Login";
  $headerMsg = "Login Page";
  $errorMessage = null;
  include("inc/header.php");


  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);

    try {
      include("inc/database.php");
      $db = Database::connect();
      $statement = $db->prepare("SELECT password FROM users WHERE username = :username");
      $statement->bindParam(":username",$username);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      $resultPassword = $result["password"];

      if(password_verify($password,$resultPassword)) {
        $_SESSION["username"]  = $username;
        $_SESSION["password"]  = $password;
        header("location:home.php");
        exit;
      } else {
        $errorMessage = "Incorrect Username or Password";
      }

    } catch(Exception $e) {
      echo $e->getMessage();
    }

  }

  else if($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_SESSION["username"]) && !empty($_SESSION["password"])) {
    header("location:home.php");
    exit;
  }


?>

  <div class="container">

    <?php
      if(!empty($errorMessage)) {
        echo "<div class='alert alert-danger' role='alert'>
                $errorMessage
              </div>";
      }
     ?>

    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="username">USERNAME</label>
        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
      </div>

      <div class="form-group">
        <label for="password">PASSWORD</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
      </div>



      <button class="btn btn-secondary btn-lg" type="button submit">Login</button>
      <div class="message-box">
        <h3>Don't have account yet?</h3>
        <a href="register.php" class="card-link">Register Here...</a>
      </div>
    </form>



  </div>

  </body>
</html>
