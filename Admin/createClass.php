<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {

  $className = $_POST['className'];

  $query = mysqli_query($conn, "select * from tblclass where className ='$className'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {

    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Class Already Exists!</div>";
  } else {

    $query = mysqli_query($conn, "insert into tblclass(className) value('$className')");

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

  $query = mysqli_query($conn, "select * from tblclass where Id ='$Id'");
  $row = mysqli_fetch_array($query);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $className = $_POST['className'];

    $query = mysqli_query($conn, "update tblclass set className='$className' where Id='$Id'");

    if ($query) {

      echo "<script type = \"text/javascript\">
                window.location = (\"createClass.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}


//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "DELETE FROM tblclass WHERE Id='$Id'");

  if ($query == TRUE) {

    echo "<script type = \"text/javascript\">
                window.location = (\"createClass.php\")
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
</head>
<style>
  .hostel-container {
    width: 100%;
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background-color: #78B7D0;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .hostel-header {
    margin-bottom: 20px;
  }

  .hostel-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #fff;
    margin-bottom: 10px;
  }

  .hostel-form-container {
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
  }

  .hostel-form .form-group {
    margin-bottom: 15px;
  }

  .form-item {
    margin-bottom: 10px;
  }

  .form-label {
    display: block;
    font-size: 1rem;
    color: #333;
    margin-bottom: 5px;
  }

  .required {
    color: red;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .update-button,
  .save-button {
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 5px;
    border: none;
    cursor: pointer;
  }

  .update-button {
    background-color: #f0ad4e;
    color: #fff;
  }

  .save-button {
    background-color: #007bff;
    color: #fff;
  }

  .update-button:hover,
  .save-button:hover {
    opacity: 0.9;
  }


  .classes-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #78B7D0;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
  }

  .classes-table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 15px;
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  }

  .table-header th {
    background-color: #549AB2;
    color: #ffffff;
    padding: 15px;
    text-align: left;
    font-weight: bold;
    font-size: 1.1rem;
    text-transform: uppercase;
  }

  .table-body td {
    padding: 15px;
    color: #333333;
    border-bottom: 1px solid #e0e0e0;
    font-size: 1rem;
    transition: background-color 0.3s ease, font-size 0.3s ease, color 0.3s ease;
  }

  .table-body tr:hover {
    background-color: #78B7D0;
    font-size: 1.05rem;
    color: #ffffff;
  }

  @media (max-width: 600px) {

    .classes-table th,
    .classes-table td {
      padding: 12px;
      font-size: 0.9rem;
    }
  }

  .custom-button {
    padding: 12px 20px;
    font-size: 1rem;
    font-weight: bold;
    color: #ffffff;
    background-color: #549AB2;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .custom-button:hover {
    background-color: #417A90;
    transform: translateY(-3px);
  }

  .update-button {
    background-color: #F0AD4E;
  }

  .update-button:hover {
    background-color: #EC971F;
  }

  .save-button {
    background-color: #5CB85C;
  }

  .save-button:hover {
    background-color: #449D44;
  }

  .edit_button,
  .delete_button {
    display: inline-block;
    padding: 8px 15px;
    font-size: 0.9rem;
    font-weight: bold;
    text-decoration: none;
    color: #ffffff;
    border-radius: 6px;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .edit_button {
    background-color: #5BC0DE;
  }

  .edit_button:hover {
    background-color: #31B0D5;
    transform: translateY(-2px);
  }

  .delete_button {
    background-color: #D9534F;
  }

  .delete_button:hover {
    background-color: #C9302C;
    transform: translateY(-2px);
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
            <h1 class="h3 mb-0 text-gray-800">Create Hostel</h1>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="hostel-container">
                <div class="hostel-header">
                  <h6 class="hostel-title">Create Hostel</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="hostel-form-container">
                  <form method="post" class="hostel-form">
                    <div class="form-group">
                      <div class="form-item">
                        <label class="form-label">Hostel Name<span class="required">*</span></label>
                        <input type="text" class="form-control" name="className"
                          value="<?php echo $row['className']; ?>" id="exampleInputFirstName" placeholder="Spartan">
                      </div>
                    </div>
                    <?php if (isset($Id)) { ?>
                      <button type="submit" name="update" class="custom-button update-button">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php } else { ?>
                      <button type="submit" name="save" class="custom-button save-button">Save</button>
                    <?php } ?>
                  </form>
                </div>
              </div>
              
              <!-- Input Group -->
              <div class="classes-container">
                <div class="classes-content">
                  <div class="classes-header">
                    <div class="classes-title-wrapper">
                      <h6 class="classes-title">All Hostels</h6>
                    </div>
                    <div class="classes-table-wrapper">
                      <table class="classes-table" id="dataTableHover">
                        <thead class="table-header">
                          <tr>
                            <th>#</th>
                            <th>Hostel Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody class="table-body">
                          <?php
                          $query = "SELECT * FROM tblclass";
                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn = 0;
                          if ($num > 0) {
                            while ($rows = $rs->fetch_assoc()) {
                              $sn = $sn + 1;
                              echo "
                <tr>
                  <td>" . $sn . "</td>
                  <td>" . $rows['className'] . "</td>
                  <td><a class='edit_button' href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit'></i>Edit</a></td>
                  <td><a class='delete_button' href='?action=delete&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-trash'></i>Delete</a></td>
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
        $('#dataTable').DataTable(); 
        $('#dataTableHover').DataTable();
      });
    </script>
</body>
</html>