<?php
 use App\classes\DbHelper;
 use App\classes\Features;
 require("vendor/autoload.php");
  // If already loggedin redirect to submit page.
  if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE)
  header("Location:index.php");
  
  // Stores the database helper class.
  $db = new DbHelper();
  $feature= new Features();

  // Checks first if submit is clicked
  if (isset($_POST["name"]) && isset($_POST["mailId"]) && isset($_POST["userId"]) && isset($_POST["pass"])) {
    // If id and pass fields are not empty.
    if ($_POST['name'] != "" && $_POST["mailId"] != "" && $_POST['userId'] != "" && $_POST["pass"] != "") {
      if (!$feature->onlyAlpha($_POST['name'])){?>
        <h4 class='error-div'>Invalid name</h4>
      <?php
      } 
      if (!$feature->validMailId($_POST['mailId'])){?>
        <h4 class='error-div'>Invalid email address.</h4>
      <?php
      }
      if (!$feature->validUserId($_POST['userId'])){?>
        <h4 class='error-div'>User Id should only contain alphabet numbers and space</h4>
      <?php
      }
      // If user is not available in db
      if ($db->existsUserId($_POST['userId'])){?>
        <h4 class='error-div'>User Id is unavailable</h4>
      <?php
      }
      // If mail id is not available in db
      if ($db->existsMailId($_POST['mailId'])){?>
        <h4 class='error-div'>Mail Id is unavailable</h4>
      <?php
      }
      // If all fileds are valid then insert data into database
      else {
        try {
          date_default_timezone_set("Asia/Kolkata");
          $db->setUser('postit',explode(' ', $_POST['name'], 2)[0],explode(' ', $_POST['name'] . " ", 2)[1], $_POST["mailId"], $_POST['userId'], $_POST['pass'], date("y-m-d h:i:s")) ;
          ?>
          <h3 class='success'>Account Successfully created<br> Try to Login</h3>
          <span >Redirecting page in <span class='counter'>10</span> sec.</span>
          <?php
          header("refresh:10;url=index.php");
        } 
        catch (Exception $e) {
          echo $e;
        }
      }
    } 
    else {?>
    <h4 class='error-div'>All fileds should be filled</h4>
    <?php
    }
  }
?>
<html>
<head>
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>Register</title>
  <script src="scripts/validation.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>

<body>
  <form class="form-div" method="POST" onsubmit="return validate()">
    <h3>Register Yourself</h2>
      Name: <span class="error br" name="nameerr">*
      </span> <input type="text" name="name" value=<?php if (isset($_POST['name']))
        echo $_POST['name']; ?>>
      Email: <span class="error br" name="mailerr">*
      </span><input type="text" name="mailId" value=<?php if (isset($_POST['mailId']))
        echo $_POST['mailId']; ?>>

      User Id: <span class="error br" name="usererr">*
      </span><input type="text" name="userId" value=<?php if (isset($_POST['userId']))
        echo $_POST['userId']; ?>>

      Password: <span class="error br" name="passerr">*
      </span><input type="password" name="pass" id="pass" value=<?php if (isset($_POST['pass']))
        echo $_POST['pass']; ?>><i class="bi bi-eye-slash " id="togglePassword"></i>
      <div class="sp-bw br">
        <input type="submit" class="hover-eff click-eff btn" name="register" value="Regiser User">
        <a class="link-btn grow" href="index.php">Already have account.</a>
      </div>
  </form>
</body>
</html>
<script src="scripts/register.js"></script> 
