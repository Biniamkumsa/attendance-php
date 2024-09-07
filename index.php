<?php
include 'Includes/dbcon.php';
session_start();
?>
<?php
if (isset($_POST['login'])) {
  $userType = $_POST['userType'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password = md5($password);
  if ($userType == "Administrator") {
    $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $rows = $rs->fetch_assoc();
    if ($num > 0) {
      $_SESSION['userId'] = $rows['Id'];
      $_SESSION['firstName'] = $rows['firstName'];
      $_SESSION['lastName'] = $rows['lastName'];
      $_SESSION['emailAddress'] = $rows['emailAddress'];
      echo "<script type = \"text/javascript\">
        window.location = (\"Admin/index.php\")
        </script>";
    } else {
      echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";
    }
  } else if ($userType == "ClassTeacher") {

    $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $rows = $rs->fetch_assoc();
    if ($num > 0) {
      $_SESSION['userId'] = $rows['Id'];
      $_SESSION['firstName'] = $rows['firstName'];
      $_SESSION['lastName'] = $rows['lastName'];
      $_SESSION['emailAddress'] = $rows['emailAddress'];
      $_SESSION['classId'] = $rows['classId'];
      $_SESSION['classArmId'] = $rows['classArmId'];
      echo "<script type = \"text/javascript\">
        window.location = (\"ClassTeacher/index.php\")
        </script>";
    } else {

      echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

    }
  } else {

    echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SOS-HGIC DOCKING SYSTEM</title>
  <link rel="icon"
    href="https://i0.wp.com/www.soshgic.edu.gh/wp-content/uploads/2022/06/fv-hgic.jpg?fit=32%2C32&#038;ssl=1"
    sizes="32x32" />
  <link rel="icon"
    href="https://i0.wp.com/www.soshgic.edu.gh/wp-content/uploads/2022/06/fv-hgic.jpg?fit=32%2C32&#038;ssl=1"
    sizes="192x192" />
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

  body {
    padding: 0;
    margin: 0;
    font-family: "Poppins";
  }

  .main-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100vh;
    background-color: #021526;
    color: black;
  }

  .login-form-container {
    background: white;
    padding: 50px 90px;
    border-radius: 15px;
    box-shadow: 4px 6px 10px rgba(0, 0, 0, 0.3);
  }

  .logo-container {
    text-align: center;
  }

  .logo-container img {
    height: 250px;
  }
  /*  */
  .select-form-group{
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .select-form-group select{
    padding: 10px 50px 10px 10px;
    font-size: 18px;
    font-family: "Poppins", sans-serif;
  }
  .select-form-group option{
    padding: 10px 20px;
  }
  .form-group{
    margin-top: 12px;
  }
  .form-group input{
    padding: 10px 175px 10px 10px;
    border-left: none;
    border-right: none;
    border-top: none;
    background-color: rgb(214, 214, 214);
    color: black;
    font-family: "Poppins";
  }
  .form-group p{
    margin-top: 0;
    margin-bottom: 0;
  }
  .button-form-group input{
    margin-top: 10px;
    width: 100%;
    padding: 10px 0;
    background-color: white;
    border: 1px solid gray;
    font-size: 20px;
    font-weight: 600;
    transition: 0.7s;
  }
  .button-form-group input:hover{
    background-color: rgb(214, 214, 214);

  }
</style>
<body class="bg-gradient-login">
  <div class="main-container">
    <div class="login-form-container">
      <div class="logo-container">
        <h1>Login Page</h1>
        <img src="img/logo/login_pic.png">
      </div>
      <div>
        <form class="user" method="Post" action="">
          <div class="select-form-group">
            <select required name="userType" class="form-control">
              <option value="">--Who is using the account--</option>
              <option value="Administrator">Administrator</option>
              <option value="ClassTeacher">Hostel Tutour</option>
            </select>
          </div>
          <div class="form-group">
            <p>Email</p>
            <input type="text" class="form-control" required name="username" id="exampleInputEmail">
          </div>
          <div class="form-group">
            <p>Password</p>
            <input type="password" name="password" required class="form-control" id="exampleInputPassword">
          </div>
          <div class="button-form-group">
            <input type="submit" class="btn btn-success btn-block" value="LOG-IN" name="login" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>
</html>