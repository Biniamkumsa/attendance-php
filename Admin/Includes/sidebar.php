<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="icon" href="https://i0.wp.com/www.soshgic.edu.gh/wp-content/uploads/2022/06/fv-hgic.jpg?fit=32%2C32&#038;ssl=1" sizes="32x32" />
<link rel="icon" href="https://i0.wp.com/www.soshgic.edu.gh/wp-content/uploads/2022/06/fv-hgic.jpg?fit=32%2C32&#038;ssl=1" sizes="192x192" />
</head>
<style>
  .sidebar-link-container{
    background-color: #227B94;
    height: 100%;
  }
  .link-container{
    display: flex;
    justify-content: left;
    align-items: center;
    padding-left: 20px;
    padding-top: 20px;
    transition: 0.25s;
  }
  .link-container:hover{
    padding-left: 40px;
  }
  .link-container a{
    color: white;
    text-decoration: none;
    font-weight: 600;
  }
</style>
<body>
  <ul class="navbar-nav sidebar sidebar-light accordion " id="accordionSidebar">
    <a style="background-color: #16325B;" class="sidebar-brand d-flex align-items-center   justify-content-center"
      href="index.php">
      <div class="sidebar-brand-text mx-3">Docking Attendance</div>
    </a>
    <hr class="sidebar-divider my-0">

    <div class="sidebar-link-container">
      <li class="link-container">
        <a class="nav-link" href="index.php">
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <li class="link-container">
        <div id="collapseBootstrap" class="" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <a href="createClass.php">Add Hostel</a>
        </div>
      </li>
      <hr class="sidebar-divider">

      <li class="link-container">
        <div id="collapseBootstrap" class="" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <a href="createClassArms.php">Add Hostel Group</a>
        </div>
      </li>

      <hr class="sidebar-divider">

      <li class="link-container">
        <div id="collapseBootstrap" class="" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <a href="createClassTeacher.php">Add Hostel Tutour</a>
        </div>
      </li>
      <hr class="sidebar-divider">

      <li class="link-container">
        <div id="collapseBootstrap" class="" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <a href="createStudents.php">Add studetnt</a>
        </div>
      </li>
      <hr class="sidebar-divider">
    </div>
  </ul>
</body>
</html>