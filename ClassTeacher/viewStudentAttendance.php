<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';



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
  <title>Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <script>
    function typeDropDown(str) {
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
        xmlhttp.open("GET", "ajaxCallTypes.php?tid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>

</head>
<style>
  /* Attendance Container */
  .attendance-container {
    background-color: #78B7D0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  /* Attendance Header */
  .attendance-header {
    margin-bottom: 15px;
  }

  .attendance-title {
    font-weight: bold;
    color: #333333;
    font-size: 1.2em;
  }

  /* Table Styling */
  .attendance-table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  /* Table Head */
  .attendance-table-head th {
    background-color: #549ab2;
    color: #ffffff;
    padding: 10px;
    font-weight: bold;
    text-align: left;
  }

  /* Table Body */
  .attendance-table tbody tr {
    border-bottom: 1px solid #dddddd;
    background-color: white;
  }

  .attendance-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .attendance-table tbody tr:hover {
    background-color: #78B7D0;
    color: #ffffff;
  }

  /* Table Cell Styling */
  .attendance-table td {
    padding: 10px;
    text-align: left;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .attendance-table {
      font-size: 0.9em;
    }
  }
</style>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php"; ?>

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Student Attendance</h1>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4" style="background-color: #78b7d0;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                  style="background-color: #78b7d0; ">
                  <h6 class="m-0 font-weight-bold text-primary" style="color: white;">View Student Attendance</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Select Student<span class="text-danger ml-2">*</span></label>
                        <?php
                        $qry = "SELECT * FROM tblstudents where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' ORDER BY firstName ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;
                        if ($num > 0) {
                          echo ' <select required name="admissionNumber" class="form-control mb-3">';
                          echo '<option value="">--Select Student--</option>';
                          while ($rows = $result->fetch_assoc()) {
                            echo '<option value="' . $rows['admissionNumber'] . '" >' . $rows['firstName'] . ' ' . $rows['lastName'] . '</option>';
                          }
                          echo '</select>';
                        }
                        ?>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Type<span class="text-danger ml-2">*</span></label>
                        <select required name="type" onchange="typeDropDown(this.value)" class="form-control mb-3">
                          <option value="">--Select--</option>
                          <option value="1">All</option>
                          <option value="2">By Single Date</option>
                          <option value="3">By Date Range</option>
                        </select>
                      </div>
                    </div>
                    <?php
                    echo "<div id='txtHint'></div>";
                    ?>
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
              <div class="attendance-container">
                <div class="attendance-wrapper">
                  <div class="attendance-header">
                    <h6 class="attendance-title">Class Attendance</h6>
                  </div>
                  <div class="attendance-table-wrapper">
                    <table class="table attendance-table" id="dataTableHover">
                      <thead class="attendance-table-head">
                        <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Other Name</th>
                          <th>Admission No</th>
                          <th>Class</th>
                          <th>Class Arm</th>
                          <th>Session</th>
                          <th>Term</th>
                          <th>Status</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($_POST['view'])) {
                          $admissionNumber = $_POST['admissionNumber'];
                          $type = $_POST['type'];

                          if ($type == "1") {
                            $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblclass.className,
                  tblclassarms.classArmName, tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
                  tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.admissionNumber
                  FROM tblattendance
                  INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                  INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                  INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                  INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                  INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                  WHERE tblattendance.admissionNo = '$admissionNumber' 
                    AND tblattendance.classId = '$_SESSION[classId]' 
                    AND tblattendance.classArmId = '$_SESSION[classArmId]'";

                          } elseif ($type == "2") {
                            $singleDate = $_POST['singleDate'];
                            $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblclass.className,
                  tblclassarms.classArmName, tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
                  tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.admissionNumber
                  FROM tblattendance
                  INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                  INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                  INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                  INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                  INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                  WHERE tblattendance.dateTimeTaken = '$singleDate' 
                    AND tblattendance.admissionNo = '$admissionNumber' 
                    AND tblattendance.classId = '$_SESSION[classId]' 
                    AND tblattendance.classArmId = '$_SESSION[classArmId]'";

                          } elseif ($type == "3") {
                            $fromDate = $_POST['fromDate'];
                            $toDate = $_POST['toDate'];
                            $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblclass.className,
                  tblclassarms.classArmName, tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
                  tblstudents.firstName, tblstudents.lastName, tblstudents.otherName, tblstudents.admissionNumber
                  FROM tblattendance
                  INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                  INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                  INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                  INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                  INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                  WHERE tblattendance.dateTimeTaken BETWEEN '$fromDate' AND '$toDate' 
                    AND tblattendance.admissionNo = '$admissionNumber' 
                    AND tblattendance.classId = '$_SESSION[classId]' 
                    AND tblattendance.classArmId = '$_SESSION[classArmId]'";

                          }

                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn = 0;
                          $status = "";
                          if ($num > 0) {
                            while ($rows = $rs->fetch_assoc()) {
                              if ($rows['status'] == '1') {
                                $status = "Present";
                                $colour = "#00FF00";
                              } else {
                                $status = "Absent";
                                $colour = "#FF0000";
                              }
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
                      <td>" . $rows['sessionName'] . "</td>
                      <td>" . $rows['termName'] . "</td>
                      <td style='background-color:" . $colour . "'>" . $status . "</td>
                      <td>" . $rows['dateTimeTaken'] . "</td>
                    </tr>";
                            }
                          } else {
                            echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
                          }
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

    <script>
      $(document).ready(function () {
        $('#dataTable').DataTable(); // ID From dataTable 
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
      });
    </script>
</body>

</html>