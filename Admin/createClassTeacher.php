<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {

  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $emailAddress = $_POST['emailAddress'];

  $phoneNo = $_POST['phoneNo'];
  $classId = $_POST['classId'];
  $classArmId = $_POST['classArmId'];
  $dateCreated = date("Y-m-d");

  $query = mysqli_query($conn, "select * from tblclassteacher where emailAddress ='$emailAddress'");
  $ret = mysqli_fetch_array($query);

  $sampPass = "pass123";
  $sampPass_2 = md5($sampPass);

  if ($ret > 0) {

    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
  } else {

    $query = mysqli_query($conn, "INSERT into tblclassteacher(firstName,lastName,emailAddress,password,phoneNo,classId,classArmId,dateCreated) 
    value('$firstName','$lastName','$emailAddress','$sampPass_2','$phoneNo','$classId','$classArmId','$dateCreated')");

    if ($query) {

      $qu = mysqli_query($conn, "update tblclassarms set isAssigned='1' where Id ='$classArmId'");
      if ($qu) {

        $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
      } else {
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
      }
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//---------------------------------------EDIT-------------------------------------------------------------






//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "select * from tblclassteacher where Id ='$Id'");
  $row = mysqli_fetch_array($query);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];

    $phoneNo = $_POST['phoneNo'];
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];
    $dateCreated = date("Y-m-d");

    $query = mysqli_query($conn, "update tblclassteacher set firstName='$firstName', lastName='$lastName',
    emailAddress='$emailAddress', password='$password',phoneNo='$phoneNo', classId='$classId',classArmId='$classArmId'
    where Id='$Id'");
    if ($query) {

      echo "<script type = \"text/javascript\">
                window.location = (\"createClassTeacher.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}


//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['classArmId']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];
  $classArmId = $_GET['classArmId'];

  $query = mysqli_query($conn, "DELETE FROM tblclassteacher WHERE Id='$Id'");

  if ($query == TRUE) {

    $qu = mysqli_query($conn, "update tblclassarms set isAssigned='0' where Id ='$classArmId'");
    if ($qu) {

      echo "<script type = \"text/javascript\">
                window.location = (\"createClassTeacher.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  } else {

    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
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
  <link href="img/logo/attnlg.jpg" rel="icon">
  <?php include 'includes/title.php'; ?>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">



  <script>
    function classArmDropdown(str) {
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else {
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxClassArms.php?cid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>
</head>
<style>
  .user-form-container {
    padding: 20px;
    background-color: #78B7D0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 1200px;
    margin: auto;
  }

  .form-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
  }

  .form-group {
    flex: 1;
    margin-right: 10px;
  }

  .form-group:last-child {
    margin-right: 0;
  }

  .form-label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #ffffff;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .form-control:focus {
    border-color: #549AB2;
    box-shadow: 0 0 5px rgba(84, 154, 178, 0.8);
  }

  .form-control.mb-3 {
    margin-bottom: 15px;
  }

  .btn {
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .btn-warning {
    background-color: #ffcc00;
    color: #ffffff;
  }

  .btn-primary {
    background-color: #007bff;
    color: #ffffff;
  }

  .btn:hover {
    transform: scale(1.05);
  }

  .btn-warning:hover {
    background-color: #ff9900;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .teacher-table-container {
    padding: 20px;
    background-color: #78B7D0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 1200px;
    margin-top: 100px;
    position: relative;
    left: 20px;
  }

  .table-wrapper {
    overflow-x: auto;
  }

  .table-title .title-text {
    font-size: 1.2em;
    font-weight: bold;
    color: #ffffff;
    margin-bottom: 15px;
  }

  .styled-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .table-head th {
    padding: 15px;
    text-align: left;
    background-color: #549AB2;
    color: #ffffff;
    font-weight: bold;
  }

  .table-body td {
    padding: 15px;
    border-bottom: 1px solid #ddd;
  }

  .table-body tr:hover {
    background-color: #f1f1f1;
  }

  .delete-link {
    color: #ff4444;
    text-decoration: none;
    font-size: 1.2em;
    transition: color 0.3s ease;
  }

  .delete-link:hover {
    color: #cc0000;
  }

  .no-records {
    text-align: center;
    color: #ff4444;
    font-weight: bold;
  }

</style>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php"; ?>

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Hostel Tutour</h1>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="user-form-container">
                <form method="post">
                  <div class="form-row">
                    <div class="form-group">
                      <label class="form-label">Firstname<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" required name="firstName"
                        value="<?php echo $row['firstName']; ?>" id="exampleInputFirstName">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Lastname<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" required name="lastName"
                        value="<?php echo $row['lastName']; ?>" id="exampleInputFirstName">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label class="form-label">Email Address<span class="text-danger ml-2">*</span></label>
                      <input type="email" class="form-control" required name="emailAddress"
                        value="<?php echo $row['emailAddress']; ?>" id="exampleInputFirstName">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Phone No<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" name="phoneNo" value="<?php echo $row['phoneNo']; ?>"
                        id="exampleInputFirstName">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label class="form-label">Select Hostel<span class="text-danger ml-2">*</span></label>
                      <?php
                      $qry = "SELECT * FROM tblclass ORDER BY className ASC";
                      $result = $conn->query($qry);
                      $num = $result->num_rows;
                      if ($num > 0) {
                        echo ' <select required name="classId" onchange="classArmDropdown(this.value)" class="form-control mb-3">';
                        echo '<option value="">--Select Hostel--</option>';
                        while ($rows = $result->fetch_assoc()) {
                          echo '<option value="' . $rows['Id'] . '" >' . $rows['className'] . '</option>';
                        }
                        echo '</select>';
                      }
                      ?>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Select Hostel Group<span class="text-danger ml-2">*</span></label>
                      <?php
                      echo "<div id='txtHint'></div>";
                      ?>
                    </div>
                  </div>
                  <div class="form-row">
                    <?php if (isset($Id)) { ?>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php } else { ?>
                      <button type="submit" name="save" class="btn btn-primary">Save</button>
                    <?php } ?>
                  </div>
                </form>
              </div>



              <!-- Input Group -->
              <div class="teacher-table-container">
                <div class="table-wrapper">
                  <div class="table-header">
                    <div class="table-title">
                      <h6 class="title-text">All Class Teachers</h6>
                    </div>
                  </div>
                  <div class="table-content">
                    <table class="styled-table" id="dataTableHover">
                      <thead class="table-head">
                        <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email Address</th>
                          <th>Phone No</th>
                          <th>Hostel</th>
                          <th>Hostel Group</th>
                          <th>Date Created</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody class="table-body">
                        <?php
                        $query = "SELECT tblclassteacher.Id, tblclass.className, tblclassarms.classArmName, tblclassarms.Id AS classArmId, tblclassteacher.firstName, 
              tblclassteacher.lastName, tblclassteacher.emailAddress, tblclassteacher.phoneNo, tblclassteacher.dateCreated
              FROM tblclassteacher
              INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
              INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId";
                        $rs = $conn->query($query);
                        $num = $rs->num_rows;
                        $sn = 0;
                        if ($num > 0) {
                          while ($rows = $rs->fetch_assoc()) {
                            $sn++;
                            echo "
              <tr>
                <td>{$sn}</td>
                <td>{$rows['firstName']}</td>
                <td>{$rows['lastName']}</td>
                <td>{$rows['emailAddress']}</td>
                <td>{$rows['phoneNo']}</td>
                <td>{$rows['className']}</td>
                <td>{$rows['classArmName']}</td>
                <td>{$rows['dateCreated']}</td>
                <td><a href='?action=delete&Id={$rows['Id']}&classArmId={$rows['classArmId']}' class='delete-link'><i class='fas fa-fw fa-trash'></i></a></td>
              </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='9' class='no-records'>No Record Found!</td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
      $(document).ready(function () {
        $('#dataTable').DataTable(); // ID From dataTable 
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
      });
    </script>
</body>

</html>