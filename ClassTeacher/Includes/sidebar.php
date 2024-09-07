<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>


</style>

<body>
  <div  class="container-for-sidebar">
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

      <a style="background: #22313f;"
        class="sidebar-brand d-flex align-items-center bg-gradient-primary justify-content-center" href="index.php">
        <div class="sidebar-brand-text mx-3">DOCKING Attendance</div>
      </a>
      <hr class="sidebar-divider my-0">
      <div class="sidebar-container">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">
            <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">

        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2"
            aria-expanded="true" aria-controls="collapseBootstrap2">
            <span>Manage Students</span>
          </a>
          <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="viewStudents.php">View Students</a>
            </div>
          </div>
        </li>
        <hr class="sidebar-divider">
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrapcon"
            aria-expanded="true" aria-controls="collapseBootstrapcon">
            <span>Manage Attendance</span>
          </a>
          <div id="collapseBootstrapcon" class="collapse" aria-labelledby="headingBootstrap"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="takeAttendance.php">Take Attendance</a>
              <a class="collapse-item" href="viewAttendance.php">View Class Attendance</a>
              <a class="collapse-item" href="viewStudentAttendance.php">View Student Attendance</a>
              <a class="collapse-item" href="downloadRecord.php">Today's Report (xls)</a>
            </div>
          </div>
        </li>
      </div>

    </ul>
  </div>

</body>

</html>