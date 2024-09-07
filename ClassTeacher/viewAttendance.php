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
</head>
<style>
  /* Container for the attendance view section */
  .attendance-view-container {
    padding: 20px;
    background-color: #78b7d0;
    /* White background */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 100%;
    margin: auto;
    margin-bottom: 100px;
  }

  /* Wrapper for the form and content */
  .attendance-view-wrapper {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
  }

  /* Title styling */
  .attendance-view-title {
    font-size: 1.5em;
    font-weight: bold;
    color: #333333;
    margin-bottom: 15px;
  }

  .attendance-status-message {
    margin-bottom: 15px;
    font-size: 1em;
    color: #555555;
  }

  .attendance-form-wrapper {
    margin-bottom: 20px;
  }

  .attendance-date-select .form-group {
    margin-bottom: 20px;
  }

  .attendance-date-select input[type="date"] {
    padding: 10px;
    font-size: 1em;
    border-radius: 5px;
    border: 1px solid #ced4da;
    width: 100%;
    transition: border-color 0.3s ease;
  }

  .attendance-date-select input[type="date"]:hover {
    border-color: #78B7D0;
  }

  .attendance-view-btn {
    padding: 10px 20px;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    font-size: 1em;
    transition: background-color 0.3s ease;
  }

  .attendance-view-btn:hover {
    background-color: #78B7D0;
    color: #ffffff;
  }

  /* Container for the attendance view */
  .attendance-container {
    padding: 20px;
    background-color: #78b7d0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 100%;
    margin: auto;
  }

  /* Wrapper for attendance section */
  .attendance-wrapper {
    background-color: #78b7d0;
    padding: 20px;
    border-radius: 10px;
    /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
  }

  /* Header styling */
  .attendance-header {
    margin-bottom: 15px;
  }

  /* Title styling */
  .attendance-title {
    font-size: 1.5em;
    font-weight: bold;
    color: #333333;
  }

  /* Table wrapper */
  .attendance-table-wrapper {
    overflow-x: auto;
  }

  /* Table styling */
  .attendance-table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  /* Table header styling */
  .attendance-table-header th {
    background-color: #549ab2;
    color: #333333;
    text-align: left;
    padding: 12px 15px;
    border-bottom: 1px solid #dddddd;
  }

  /* Table body styling */
  .attendance-table tbody tr td {
    padding: 12px 15px;
    border-bottom: 1px solid #dddddd;
    text-align: left;
  }

  /* Row hover effect */
  .attendance-table tbody tr:hover {
    background-color: #78B7D0;
    /* Hover background color */
    color: #ffffff;
    transition: all 0.3s ease;
  }

  /* Status column with dynamic background color */
  .attendance-table tbody tr td[style*="background-color"] {
    font-weight: bold;
    color: #ffffff;
  }

  /* Responsive design */
  @media (max-width: 768px) {
    .attendance-container {
      padding: 10px;
    }

    .attendance-title {
      font-size: 1.25em;
    }

    .attendance-table tbody tr td {
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

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View hostel Attendance</h1>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="attendance-view-container">
                <div class="attendance-view-wrapper">
                  <h6 class="attendance-view-title">View hostel Attendance</h6>
                  <div class="attendance-status-message">
                    <?php echo $statusMsg; ?>
                  </div>
                  <div class="attendance-form-wrapper">
                    <form method="post">
                      <div class="attendance-date-select">
                        <div class="form-group">
                          <label class="form-control-label">Select Date<span class="text-danger ml-2">*</span></label>
                          <input type="date" class="form-control" name="dateTaken" id="attendanceDate"
                            placeholder="Class Arm Name">
                        </div>
                      </div>
                      <button type="submit" name="view" class="btn btn-primary attendance-view-btn">View
                        Attendance</button>
                    </form>
                  </div>
                </div>
              </div>


              <div class="attendance-container">
                <div class="attendance-wrapper">
                  <div class="attendance-header">
                    <h6 class="attendance-title">Class Attendance</h6>
                  </div>
                  <div class="attendance-table-wrapper">
                    <table class="attendance-table" id="dataTableHover">
                      <thead class="attendance-table-header">
                        <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Other Name</th>
                          <th>Laptop ID No</th>
                          <th>Hostel</th>
                          <th>Hostel Group</th>
                          <th>Status</th>
                          <th>Date</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        if (isset($_POST['view'])) {
                          $dateTaken = $_POST['dateTaken'];
                          $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblclass.className,
                        tblclassarms.classArmName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                        tblstudents.firstName,tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber
                        FROM tblattendance
                        INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                        INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                        INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                        where tblattendance.dateTimeTaken = '$dateTaken' and tblattendance.classId = '$_SESSION[classId]' and tblattendance.classArmId = '$_SESSION[classArmId]'";
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