<?php

  // A DESIGN PATTERN IS USED HERE (Singleton Pattern)

  class Database {

    private static $db = null;

    // prevents from being instantiated
    private function __construct() { }

    public static function connect() {
      // if  $db is empty we try to create a PDO instance and store it in $db
      // if not empty we just return the $db assuming that there is already an instance and it's not empty
      if(empty($db)) {
        try {
                        /////// REPLACE THESE PARAMETERS CORRESPONDING TO YOUR DATABASE ////
          $db = new PDO("mysql:host=localhost;dbname=simplelogin","root","1234");
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
          echo $e->getMessage();
        }

      }
      return $db;
    }

    public static function disconnect() {
      $db = null;
    }

  }

 ?>
