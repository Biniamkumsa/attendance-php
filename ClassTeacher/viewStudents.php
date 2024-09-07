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
          xmlhttp = new XMLHttpRequest();
        } else {
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
  .student-table-container {
    padding: 20px;
    background-color: #78b7d0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 100%;
    margin: auto;
  }

  .student-table-wrapper {
    background-color: #78b7d0;
    border-radius: 10px;
    padding: 20px;
  }

  .student-table-header {
    margin-bottom: 15px;
  }

  .student-table-title {
    font-size: 1.25em;
    font-weight: bold;
    color: #333333;
    text-align: center;
  }

  .student-table-responsive {
    overflow-x: auto;
  }

  .student-table {
    width: 100%;
    border-collapse: collapse;
  }

  .student-table-head th {
    background-color: #f8f9fa;
    font-weight: bold;
    text-align: left;
    padding: 10px;
    border-bottom: 2px solid #dee2e6;
  }

  .student-table-body td {
    padding: 10px;
    border-bottom: 1px solid #dee2e6;
    color: #333333;
    background-color: #ffffff;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .student-table-body tr:hover td {
    background-color: #78B7D0;
    color: #ffffff;
  }

  .student-table-container {
    padding: 20px;
    background-color: #78b7d0;
    border-radius: 10px;
    /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
    max-width: 100%;
    margin: auto;
  }

  .student-table-wrapper {
    background-color: #78b7d0;
    border-radius: 10px;
    padding: 20px;
    /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
  }

  /* Table header */
  .student-table-header {
    margin-bottom: 15px;
  }

  .student-table-title {
    font-size: 1.25em;
    font-weight: bold;
    color: #333333;
    text-align: center;
  }

  .student-table-responsive {
    overflow-x: auto;
  }

  .student-table {
    width: 100%;
    border-collapse: collapse;
  }

  .student-table-head th {
    background-color: #549ab2;
    font-weight: bold;
    text-align: left;
    padding: 10px;
    color: white;
    border-bottom: 2px solid #dee2e6;
  }

  .student-table-body td {
    padding: 10px;
    border-bottom: 1px solid #dee2e6;
    color: #333333;
    background-color: #ffffff;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .student-table-body tr:hover td {
    background-color: #78B7D0;
    color: #ffffff;
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
            <h1 class="h3 mb-0 text-gray-800">All Student in
              (<?php echo $rrw['className'] . ' - ' . $rrw['classArmName']; ?>) Hostel</h1>
          </div>

          <div class="row">
            <div class="col-lg-12">

              <!-- Input Group -->
              <div class="student-table-container">
                <div class="student-table-wrapper">
                  <div class="student-table-header">
                    <h6 class="student-table-title">All Students In this Hostel</h6>
                  </div>
                  <div class="student-table-responsive">
                    <table class="student-table" id="dataTableHover">
                      <thead class="student-table-head">
                        <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Class</th>
                          <th>Laptop ID No</th>
                          <th>Hostel</th>
                          <th>Hostel Group</th>
                        </tr>
                      </thead>
                      <tbody class="student-table-body">
                        <?php
                        $query = "SELECT tblstudents.Id,tblclass.className,tblclassarms.classArmName,tblclassarms.Id AS classArmId,tblstudents.firstName,
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
                </tr>";
                          }
                        } else {
                          echo "<div class='alert alert-danger' role='alert'>
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
