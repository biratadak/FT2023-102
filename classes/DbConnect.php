<?php
  namespace App\classes;
  use mysqli;

  /**
   * Connects with database using mysqli.
   */
  class DbConnect extends EnvHandler{
    /**
     * @var object
     *  Define global $conn to hold connection object after successful authentication with database.
     */
    protected $conn; 
    /**
     * Creates MySqli object and connect with database.
     */
    public function __construct() {
      // Loading enviroment varialble through EnvHandler Class
      parent::__construct();
      
      // Stores the Mysqli connection object. 
      $connect = new mysqli("localhost", $this->credential['sqlUser'], $this->credential['sqlPass'], $this->credential['dbName']);
      if ($connect->connect_error) {
        echo "Connection error:" . $connect->connect_error;
      }
      $this->conn = $connect;

    }
  }
?>
