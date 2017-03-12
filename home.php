<?php
  session_start();
  $title = "Home";

  if(empty($_SESSION)) {
    header("location:login.php");
  }

  $headerMsg = "Welcome ".$_SESSION["username"];
  include("inc/header.php");


  session_destroy();
?>
