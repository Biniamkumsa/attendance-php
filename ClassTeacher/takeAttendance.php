<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$query = "SELECT tblclass.className,tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    Where tblclassteacher.Id = '$_SESSION[userId]'";
$rs = $conn->query($query);
$num = $rs->num_rows;
$rrw = $rs->fetch_assoc();


$querey = mysqli_query($conn, "select * from tblsessionterm where isActive ='1'");
$rwws = mysqli_fetch_array($querey);
$sessionTermId = $rwws['Id'];

$dateTaken = date("Y-m-d");

$qurty = mysqli_query($conn, "select * from tblattendance  where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' and dateTimeTaken='$dateTaken'");
$count = mysqli_num_rows($qurty);

if ($count == 0) {

  $qus = mysqli_query($conn, "select * from tblstudents  where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]'");
  while ($ros = $qus->fetch_assoc()) {
    $qquery = mysqli_query($conn, "insert into tblattendance(admissionNo,classId,classArmId,sessionTermId,status,dateTimeTaken) 
              value('$ros[admissionNumber]','$_SESSION[classId]','$_SESSION[classArmId]','$sessionTermId','0','$dateTaken')");

  }
}






if (isset($_POST['save'])) {

  $admissionNo = $_POST['admissionNo'];

  $check = $_POST['check'];
  $N = count($admissionNo);
  $status = "";


  //check if the attendance has not been taken i.e if no record has a status of 1
  $qurty = mysqli_query($conn, "select * from tblattendance  where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' and dateTimeTaken='$dateTaken' and status = '1'");
  $count = mysqli_num_rows($qurty);

  if ($count > 0) {

    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Attendance has been taken for today!</div>";

  } else //update the status to 1 for the checkboxes checked
  {

    for ($i = 0; $i < $N; $i++) {
      $admissionNo[$i]; //admission Number

      if (isset($check[$i])) //the checked checkboxes
      {
        $qquery = mysqli_query($conn, "update tblattendance set status='1' where admissionNo = '$check[$i]'");

        if ($qquery) {

          $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Attendance Taken Successfully!</div>";
        } else {
          $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
        }

      }
    }
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
  <title>Dashboard</title>
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
  /* Container for the attendance table */
  .attendance-table-container {
    padding: 20px;
    background-color: #78b7d0;
    /* White background */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 100%;
    margin: auto;
  }

  .attendance-table-wrapper {
    background-color: #78b7d0;
    border-radius: 10px;
    padding: 20px; 
   }

  /* Header styling */
  .attendance-header-container {
    margin-bottom: 15px;
  }

  .attendance-title {
    font-size: 1.25em;
    font-weight: bold;
    color: #333333;
  }

  .attendance-note {
    font-size: 1em;
    font-weight: normal;
    margin-top: 5px;
    color: #dc3545;
    /* Red for the note */
  }

  /* Responsive table wrapper */
  .attendance-table-responsive {
    overflow-x: auto;
  }

  /* Table styling */
  .attendance-table {
    width: 100%;
    border-collapse: collapse;
  }

  /* Table head styling */
  .attendance-table-head th {
    background-color: #549ab2;
    font-weight: bold;
    text-align: left;
    padding: 10px;
    border-bottom: 2px solid #dee2e6;
    color: white;
  }

  /* Table body styling */
  .attendance-table-body td {
    padding: 10px;
    border-bottom: 1px solid #dee2e6;
    background-color: #ffffff;
    /* Default background color */
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  /* Hover effect for table rows */
  .attendance-table-body tr:hover td {
    background-color: #78B7D0;
    /* Background changes to #78B7D0 on hover */
    color: #ffffff;
    /* Text color changes to white on hover */
  }

  /* Checkbox column */
  .attendance-table-body td input[type="checkbox"] {
    cursor: pointer;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .attendance-table-container {
      padding: 10px;
    }

    .attendance-title {
      font-size: 1.1em;
    }

    .attendance-table-body td,
    .attendance-table-head th {
      padding: 8px;
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
            <h1 class="h3 mb-0 text-gray-800">Take Attendance (Today's Date :
              <?php echo $todaysDate = date("m-d-Y"); ?>)
            </h1>
          </div>

          <div class="attendance-table-container">
            <div class="attendance-table-wrapper">
              <form method="post">
                <div class="attendance-header-container">
                  <div class="attendance-header">
                    <h6 class="attendance-title">All Students in
                      (<?php echo $rrw['className'] . ' - ' . $rrw['classArmName']; ?>) Class</h6>
                    <h6 class="attendance-note text-danger">Note: <i>Click on the checkboxes beside each student to take
                        attendance!</i></h6>
                  </div>
                </div>
                <div class="attendance-status">
                  <?php echo $statusMsg; ?>
                </div>
                <div class="attendance-table-responsive">
                  <table class="attendance-table" id="attendanceTable">
                    <thead class="attendance-table-head">
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Class</th>
                        <th>Laptop ID No</th>
                        <th>Hostel</th>
                        <th>Hostel Group</th>
                        <th>Docked</th>
                      </tr>
                    </thead>
                    <tbody class="attendance-table-body">
                      <?php
                      $query = "SELECT tblstudents.Id,tblstudents.admissionNumber,tblclass.className,tblclass.Id As classId,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
                      tblstudents.lastName,tblstudents.otherName,tblstudents.admissionNumber,tblstudents.dateCreated
                      FROM tblstudents
                      INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                      INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId
                      where tblstudents.classId = '$_SESSION[classId]' and tblstudents.classArmId = '$_SESSION[classArmId]'";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn = 0;
                      if ($num > 0) {
                        while ($rows = $rs->fetch_assoc()) {
                          $sn++;
                          echo "
                  <tr>
                    <td>" . $sn . "</td>
                    <td>" . $rows['firstName'] . "</td>
                    <td>" . $rows['lastName'] . "</td>
                    <td>" . $rows['otherName'] . "</td>
                    <td>" . $rows['admissionNumber'] . "</td>
                    <td>" . $rows['className'] . "</td>
                    <td>" . $rows['classArmName'] . "</td>
                    <td><input name='check[]' type='checkbox' value=" . $rows['admissionNumber'] . " class='form-control'></td>
                  </tr>";
                          echo "<input name='admissionNo[]' value=" . $rows['admissionNumber'] . " type='hidden' class='form-control'>";
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
                <br>
                <button type="submit" name="save" class="btn btn-primary">Take Attendance</button>
              </form>
            </div>
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

  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>