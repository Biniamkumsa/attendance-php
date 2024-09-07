<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {

  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $otherName = $_POST['otherName'];

  $admissionNumber = $_POST['admissionNumber'];
  $classId = $_POST['classId'];
  $classArmId = $_POST['classArmId'];
  $dateCreated = date("Y-m-d");

  $query = mysqli_query($conn, "select * from tblstudents where admissionNumber ='$admissionNumber'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {

    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
  } else {

    $query = mysqli_query($conn, "insert into tblstudents(firstName,lastName,otherName,admissionNumber,password,classId,classArmId,dateCreated) 
    value('$firstName','$lastName','$otherName','$admissionNumber','12345','$classId','$classArmId','$dateCreated')");

    if ($query) {

      $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";

    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//---------------------------------------EDIT-------------------------------------------------------------






//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "select * from tblstudents where Id ='$Id'");
  $row = mysqli_fetch_array($query);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $otherName = $_POST['otherName'];

    $admissionNumber = $_POST['admissionNumber'];
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];
    $dateCreated = date("Y-m-d");

    $query = mysqli_query($conn, "update tblstudents set firstName='$firstName', lastName='$lastName',
    otherName='$otherName', admissionNumber='$admissionNumber',password='12345', classId='$classId',classArmId='$classArmId'
    where Id='$Id'");
    if ($query) {

      echo "<script type = \"text/javascript\">
                window.location = (\"createStudents.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}


//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];
  $classArmId = $_GET['classArmId'];

  $query = mysqli_query($conn, "DELETE FROM tblstudents WHERE Id='$Id'");

  if ($query == TRUE) {

    echo "<script type = \"text/javascript\">
            window.location = (\"createStudents.php\")
            </script>";
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
        xmlhttp.open("GET", "ajaxClassArms2.php?cid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>
</head>
<style>
  .student-form-container {
    padding: 20px;
    background-color: #78B7D0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    max-width: 1200px;
    margin: auto;
    margin-bottom: 100px;
  }

  .form-wrapper {
    background-color: #78B7D0;
    border-radius: 10px;
    padding: 20px;
  }

  .form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
  }

  .form-group {
    flex: 1;
    min-width: 200px;
  }

  .form-label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333333;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
    color: #333333;
  }

  .form-control.mb-3 {
    margin-bottom: 15px;
  }

  .form-actions {
    text-align: center;
  }

  .btn {
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 1em;
    color: #ffffff;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .btn-primary {
    background-color: #007bff;
    border: none;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .btn-warning {
    background-color: #ffae42;
    border: none;
  }

  .btn-warning:hover {
    background-color: #d98b30;
  }

  /* table */
  .student-table-container {
    padding: 20px;
    background-color: #78B7D0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 1200px;
    margin: auto;
  }

  .table-wrapper {
    background-color: #78B7D0;
    border-radius: 10px;
    padding: 20px;
  }

  .table-header {
    margin-bottom: 15px;
  }

  .table-title {
    font-size: 1.25em;
    font-weight: bold;
    color: #333333;
    text-align: center;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .student-table {
    width: 100%;
    border-collapse: collapse;
  }

  .table-head th {
    background-color: #f8f9fa;
    font-weight: bold;
    text-align: left;
    padding: 10px;
    border-bottom: 2px solid #dee2e6;
  }

  .table-body td {
    padding: 10px;
    border-bottom: 1px solid #dee2e6;
    color: #333333;
    background-color: #ffffff;
    transition: background-color 0.3s ease;
  }

  .table-body tr:hover td {
    background-color: #78B7D0;
    color: #ffffff;
  }

  .edit-icon,
  .delete-icon {
    color: #007bff;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .edit-icon:hover {
    color: #0056b3;
  }

  .delete-icon {
    color: #dc3545;
  }

  .delete-icon:hover {
    color: #c82333;
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
            <h1 class="h3 mb-0 text-gray-800">Add Students</h1>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="student-form-container">
                <div class="form-wrapper">
                  <form method="post">
                    <div class="form-row">
                      <div class="form-group">
                        <label for="firstName" class="form-label">Firstname<span
                            class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="firstName"
                          value="<?php echo $row['firstName']; ?>" id="firstName">
                      </div>
                      <div class="form-group">
                        <label for="lastName" class="form-label">Lastname<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="lastName" value="<?php echo $row['lastName']; ?>"
                          id="lastName">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group">
                        <label for="otherName" class="form-label">Class<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="otherName"
                          value="<?php echo $row['otherName']; ?>" id="otherName">
                      </div>
                      <div class="form-group">
                        <label for="admissionNumber" class="form-label">Laptop Device ID Number<span
                            class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="admissionNumber"
                          value="<?php echo $row['admissionNumber']; ?>" id="admissionNumber">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group">
                        <label for="classId" class="form-label">Select Class<span
                            class="text-danger ml-2">*</span></label>
                        <?php
                        $qry = "SELECT * FROM tblclass ORDER BY className ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;
                        if ($num > 0) {
                          echo ' <select required name="classId" onchange="classArmDropdown(this.value)" class="form-control mb-3" id="classId">';
                          echo '<option value="">--Select Class--</option>';
                          while ($rows = $result->fetch_assoc()) {
                            echo '<option value="' . $rows['Id'] . '">' . $rows['className'] . '</option>';
                          }
                          echo '</select>';
                        }
                        ?>
                      </div>
                      <div class="form-group">
                        <label for="classArm" class="form-label">Class Arm<span
                            class="text-danger ml-2">*</span></label>
                        <?php echo "<div id='txtHint'></div>"; ?>
                      </div>
                    </div>
                    <div class="form-actions">
                      <?php if (isset($Id)) { ?>
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                      <?php } else { ?>
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                      <?php } ?>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
              <div class="student-table-container">
                <div class="table-wrapper">
                  <div class="table-header">
                    <h6 class="table-title">All Students</h6>
                  </div>
                  <div class="table-responsive">
                    <table class="student-table" id="dataTableHover">
                      <thead class="table-head">
                        <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Other Name</th>
                          <th>Laptop ID number</th>
                          <th>Hostel</th>
                          <th>Hostel Group</th>
                          <th>Date Created</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody class="table-body">
                        <?php
                        $query = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
              tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber,tblstudents.dateCreated
              FROM tblstudents
              INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
              INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId";
                        $rs = $conn->query($query);
                        $num = $rs->num_rows;
                        $sn = 0;
                        if ($num > 0) {
                          while ($rows = $rs->fetch_assoc()) {
                            $sn = $sn + 1;
                            echo "
              <tr>
                <td>" . $sn . "</td>
                <td>" . $rows['firstName'] . "</td>
                <td>" . $rows['lastName'] . "</td>
                <td>" . $rows['otherName'] . "</td>
                <td>" . $rows['admissionNumber'] . "</td>
                <td>" . $rows['className'] . "</td>
                <td>" . $rows['classArmName'] . "</td>
                <td>" . $rows['dateCreated'] . "</td>
                <td><a href='?action=edit&Id=" . $rows['Id'] . "' class='edit-icon'><i class='fas fa-fw fa-edit'></i></a></td>
                <td><a href='?action=delete&Id=" . $rows['Id'] . "' class='delete-icon'><i class='fas fa-fw fa-trash'></i></a></td>
              </tr>";
                          }
                        } else {
                          echo
                            "<div class='alert alert-danger' role='alert'>
            No Record Found!
            </div>";
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