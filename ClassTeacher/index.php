<?php
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
  <title>SOS HGIC DOCKING SYSTEM</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon"
    href="https://i0.wp.com/www.soshgic.edu.gh/wp-content/uploads/2022/06/fv-hgic.jpg?fit=32%2C32&#038;ssl=1"
    sizes="32x32" />
  <link rel="icon"
    href="https://i0.wp.com/www.soshgic.edu.gh/wp-content/uploads/2022/06/fv-hgic.jpg?fit=32%2C32&#038;ssl=1"
    sizes="192x192" />
</head>
<style>
  .card-body{
    background-color: #5B99C2;
    padding: 20px 10px;
    border-radius: 4px;
    transition: 0.25s;
  }
  .card-body:hover{
    transform: scale(1.05)
  }
  .card-body i{
    font-size: 30px;
    color: white;
  }
  .text{
    color: white;
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
            <h1 class="h3 mb-0 text-gray-800">HOSTEL GROUP --->
              (<?php echo $rrw['className'] . ' - ' . $rrw['classArmName']; ?>)</h1>
          </div>

          <div class="row mb-3">
            <?php
            $query1 = mysqli_query($conn, "SELECT * from tblstudents where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]'");
            $students = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1 text">Students</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-white-800 text"><?php echo $students; ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa-solid fa-user-graduate"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $query1 = mysqli_query($conn, "SELECT * from tblclass");
            $class = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1 text">Hostels</div>
                      <div class="h5 mb-0 font-weight-bold text-white-800 text"><?php echo $class; ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa-solid fa-hotel"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $query1 = mysqli_query($conn, "SELECT * from tblclassarms");
            $classArms = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1 text">Hostel Groups</div>
                      <div class="h5 mb-0 font-weight-bold text-white-800 text"><?php echo $classArms; ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa-solid fa-house"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
</body>

</html>