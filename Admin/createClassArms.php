<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {

  $classId = $_POST['classId'];
  $classArmName = $_POST['classArmName'];

  $query = mysqli_query($conn, "select * from tblclassarms where classArmName ='$classArmName' and classId = '$classId'");
  $ret = mysqli_fetch_array($query);

  if ($ret > 0) {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Class Arm Already Exists!</div>";
  } else {
    $query = mysqli_query($conn, "insert into tblclassarms(classId,classArmName,isAssigned) value('$classId','$classArmName','0')");

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

  $query = mysqli_query($conn, "select * from tblclassarms where Id ='$Id'");
  $row = mysqli_fetch_array($query);

  //------------UPDATE-----------------------------

  if (isset($_POST['update'])) {

    $classId = $_POST['classId'];
    $classArmName = $_POST['classArmName'];

    $query = mysqli_query($conn, "update tblclassarms set classId = '$classId', classArmName='$classArmName' where Id='$Id'");

    if ($query) {

      echo "<script type = \"text/javascript\">
                window.location = (\"createClassArms.php\")
                </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}


//--------------------------------DELETE------------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];

  $query = mysqli_query($conn, "DELETE FROM tblclassarms WHERE Id='$Id'");

  if ($query == TRUE) {

    echo "<script type = \"text/javascript\">
                window.location = (\"createClassArms.php\")
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
  .form-container {
    padding: 20px;
    background-color: #78B7D0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .form-item {
    display: flex;
    flex-direction: column;
  }

  .form-label {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 5px;
  }

  .select-hostel {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #B0C4DE;
    font-size: 1rem;
    background-color: #FFFFFF;
    transition: border-color 0.3s ease;
  }

  .select-hostel:focus {
    border-color: #549AB2;
    outline: none;
  }

  .input-group-name {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #B0C4DE;
    font-size: 1rem;
    background-color: #FFFFFF;
    transition: border-color 0.3s ease;
  }

  .input-group-name:focus {
    border-color: #549AB2;
    outline: none;
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

  .hostel-groups-container {
    padding: 20px;
    background-color: #78B7D0;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .hostel-groups-title-wrapper {
    margin-bottom: 20px;
  }

  .hostel-groups-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #ffffff;
  }

  .hostel-groups-table-wrapper {
    overflow-x: auto;
  }

  .hostel-groups-table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
    background-color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .table-header th {
    background-color: #549AB2;
    color: #ffffff;
    padding: 12px;
    text-align: left;
    font-weight: bold;
    border-bottom: 2px solid #78B7D0;
  }

  .table-body tr {
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .table-body tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  .table-body tr:hover {
    background-color: #549AB2;
    color: #ffffff;
    transform: scale(1.02);
  }

  .table-body td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
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

  .edit_button,
  .delete_button {
    color: white;
    font-weight: bold;
    text-decoration: none;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .edit_button:hover,
  .delete_button:hover {
    color: #ffffff;
    transform: scale(1.1);
  }

  .edit_button i,
  .delete_button i {
    margin-right: 5px;
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

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Hostel Groups</h1>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4" style="margin-bottom: 100px">

                <div class="form-container">
                  <form method="post">
                    <div class="form-group">
                      <div class="form-item">
                        <label class="form-label">Select Hostel<span class="text-danger ml-2">*</span></label>
                        <?php
                        $qry = "SELECT * FROM tblclass ORDER BY className ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;
                        if ($num > 0) {
                          echo '<select required name="classId" class="form-control mb-3 select-hostel">';
                          echo '<option value="">--Select Hostel--</option>';
                          while ($rows = $result->fetch_assoc()) {
                            echo '<option value="' . $rows['Id'] . '">' . $rows['className'] . '</option>';
                          }
                          echo '</select>';
                        }
                        ?>
                      </div>
                      <div class="form-item">
                        <label class="form-label">Add Hostel Group<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control input-group-name" name="classArmName"
                          value="<?php echo $row['classArmName']; ?>" id="exampleInputFirstName"
                          placeholder="Write the hostel group">
                      </div>
                    </div>
                    <?php
                    if (isset($Id)) {
                      ?>
                      <button type="submit" name="update" class="custom-button update-button">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php
                    } else {
                      ?>
                      <button type="submit" name="save" class="custom-button save-button">Save</button>
                      <?php
                    }
                    ?>
                  </form>
                </div>
              </div>

              <div class="hostel-groups-container">
                <div class="hostel-groups-content">
                  <div class="hostel-groups-header">
                    <div class="hostel-groups-title-wrapper">
                      <h6 class="hostel-groups-title">All Hostel Groups</h6>
                    </div>
                    <div class="hostel-groups-table-wrapper">
                      <table class="hostel-groups-table" id="dataTableHover">
                        <thead class="table-header">
                          <tr>
                            <th>#</th>
                            <th>Hostel Name</th>
                            <th>Hostel Group Name</th>
                            <th>Hostel Tutour</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>

                        <tbody class="table-body">
                          <?php
                          $query = "SELECT tblclassarms.Id,tblclassarms.isAssigned,tblclass.className,tblclassarms.classArmName 
                      FROM tblclassarms
                      INNER JOIN tblclass ON tblclass.Id = tblclassarms.classId";
                          $rs = $conn->query($query);
                          $num = $rs->num_rows;
                          $sn = 0;
                          $status = "";
                          if ($num > 0) {
                            while ($rows = $rs->fetch_assoc()) {
                              if ($rows['isAssigned'] == '1') {
                                $status = "Assigned";
                              } else {
                                $status = "UnAssigned";
                              }
                              $sn = $sn + 1;
                              echo "
                <tr>
                  <td>" . $sn . "</td>
                  <td>" . $rows['className'] . "</td>
                  <td>" . $rows['classArmName'] . "</td>
                  <td>" . $status . "</td>
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