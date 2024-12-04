<?php
include("database.php");
if (!empty($_SESSION["user_id"])){
    $id = $_SESSION["user_id"];
    $result = mysqli_query($connect, "SELECT * FROM registration WHERE user_id = $id");
    $row = mysqli_fetch_assoc($result);
}
else{
    header("Location: login.php");
    exit;
}

//alert message
$alerting = '';

   // Deleting message 
   if (isset($_GET['delete_error'])&& empty($alerting)) {
    $alerting ='<div id="delete-alert" class="alert alert-danger" role="alert">' . $_GET['delete_error'] . '</div>';
  }

 // Updating employees
 if(isset($_POST['update-button'])){
  $updateid = $_POST['user_id'];
  $e_name = $_POST['e_name'];
  $e_email = $_POST['e_email'];
  $updatequery = "UPDATE registration set user_name = '$e_name', email = '$e_email' WHERE user_id = '$updateid'";
  
  if(mysqli_query($connect, $updatequery)){
    $alerting ='<div id="success-alert" class="alert alert-success" role="alert">You Successfully updated the data!<div>';
  }
  else{
    $alerting ='<div id="error-alert" class="alert alert-danger" role="alert">You Successfully updated the data!<div>';
  }
 }
 // COUNT EMPLOYEES 
 $counts = "SELECT COUNT(*) total_count FROM registration"; 
 $count_result = mysqli_query($connect, $counts);
 $count_row = mysqli_fetch_assoc($count_result);
 $total_count = $count_row['total_count'];

 // COUNT DEPARTMENTS 
$count_departments = "SELECT COUNT(*) AS total_count FROM departments"; 
$count_result_departments = mysqli_query($connect, $count_departments);
$count_row_departments = mysqli_fetch_assoc($count_result_departments);
$total_count_departments = $count_row_departments['total_count'];


// COUNT PROJECTS
$count_projects = "SELECT COUNT(*) AS total_count FROM projects"; 
$count_result_projects = mysqli_query($connect, $count_projects);
$count_row_projects = mysqli_fetch_assoc($count_result_projects);
$total_count_projects = $count_row_projects['total_count'];

// COUNT TASKS
$count_tasks = "SELECT COUNT(*) AS total_count FROM tasks"; 
$count_result_tasks = mysqli_query($connect, $count_tasks);
$count_row_tasks = mysqli_fetch_assoc($count_result_tasks);
$total_count_tasks = $count_row_tasks['total_count'];


// SEARCH
$search = '';
 if(isset($_POST['searchquery'])){
  $search = $_POST['searchquery'];
 }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style2.css" />
    <title>Point of Sales System</title>
  </head>
  <body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#sidebar"
          aria-controls="offcanvasExample"
        >
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        
        <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
          href="#"><i class="bi bi-person me-3"></i><?php echo htmlspecialchars($row['user_name']); ?> </a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#topNavBar"
          aria-controls="topNavBar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
          <form class="d-flex ms-auto my-3 my-lg-0" role="search" action="" method="post">
            <div class="input-group">

              <!-- SEARCH BAR -->
              <input
                class="form-control"
                name="searchquery"
                value="<?php echo $search; ?>"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-primary" type="submit" value ="search">
                <i class="bi bi-search"></i>
              </button>
              <!-- ENDING SEARCH -->
            </div>
          </form>
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle ms-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-person-fill"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="accounts.php">Accounts</a></li>
                <li><a class="dropdown-item" href="index.php">Employee</a></li>
                <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a href="logout.php" class="btn btn-primary d-flex justify-content-center">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div
      class="offcanvas offcanvas-start sidebar-nav bg-dark"
      tabindex="-1"
      id="sidebar"
    >
      <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
          <ul class="navbar-nav">
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3">
                CORE
              </div>
            </li>
            <li>
              <a href="#" class="nav-link px-3 active">
                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                Interface
              </div>
            </li>
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts"
              >
                <span class="me-2"><i class="bi bi-layout-split"></i></span>
                <span>Layouts</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-chevron-down"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="dashboard.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-speedometer2"></i
                      ></span>
                      <span>Dashboard</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="index.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-people"></i></span>
                      <span>Employee</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="department.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-building"></i></span>
                      <span>Departments</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="projects.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-file-earmark"></i></span>
                      <span>Project</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="task.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-pencil-square"></i></span>
                      <span>Task</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
           
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                Addons
              </div>
            </li>
            <li>
              <a href="#" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-graph-up"></i></span>
                <span>Charts</span>
              </a>
            </li>
            <li> 
              <a href="#" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-table"></i></span>
                <span>Tables</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h4>Dashboard</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3 ">
            <div class="card bg-info text-white h-100 card-hover" >
              <div class="card-body py-3 px-5 fs-4 ms-lg-0 ms-3 text-uppercase fw-bold d-flex justify-content-center">Employees</div>
              <div class="card-body  fs-4 d-flex justify-content-center text-uppercase fw-bold "><?php echo $total_count; ?></div>
              <div class="card-footer d-flex bg-secondary btn btn-primary text-white custom-footer " >
              <a href="index.php" class="text-white ">View Details</a>
                <span class="ms-auto">   
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark h-100">
            <div class="card-body py-3 px-5 fs-4 ms-lg-0 ms-3 text-uppercase text-white fw-bold d-flex justify-content-center">Departments </div>
              <div class="card-body  fs-4 d-flex justify-content-center text-uppercase fw-bold text-white"><?php echo $total_count_departments; ?></div>
              <div class="card-footer d-flex bg-secondary btn btn-primary text-white custom-footer">
              <a href="department.php" class="text-white ">View Details</a>
                <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
              <div class="card-body py-3 px-5 fs-4 ms-lg-0 ms-3 text-uppercase text-white fw-bold d-flex justify-content-center">Projects</div>
              <div class="card-body  fs-4 d-flex justify-content-center text-uppercase fw-bold text-white"><?php echo $total_count_projects; ?></div>
              <div class="card-footer d-flex bg-secondary btn btn-primary text-white custom-footer">
              <a href="projects.php" class="text-white ">View Details</a>
                <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white h-100">
              <div class="card-body py-3 px-5 fs-4 ms-lg-0 ms-3 text-uppercase text-white fw-bold d-flex justify-content-center">Tasks</div>
              <div class="card-body  fs-4 d-flex justify-content-center text-uppercase fw-bold text-white"><?php echo $total_count_tasks; ?></div>
              <div class="card-footer d-flex bg-secondary btn btn-primary text-white custom-footer">
              <a href="task.php" class="text-white ">View Details</a>
                <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
                Area Chart Example
              </div>
              <div class="card-body">
                <canvas class="chart" width="400" height="200"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
                Area Chart Example
              </div>
              <div class="card-body">
                <canvas class="chart" width="400" height="200"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
  </div>
</div>   
</div>        
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

    <script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#delete-alert, #success-alert").fadeOut("slow", function() {
                $(this).remove();
            });
        }, 2000);

        $('.update-btn').on('click', function() {
        var user_id = $(this).data('id');
        var user_name = $(this).data('name');
        var user_email = $(this).data('email');

        // Pass the data into the modal inputs
        $('#user_id').val(user_id);
        $('#employeename').val(user_name);
        $('#employeeemail').val(user_email);
    });


    });
    
</script>
    </body>
  </body>
</html>


