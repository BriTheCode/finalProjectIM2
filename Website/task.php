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


try {
// Add Tasks Logic
if (isset($_POST['submit'])) {
  $userid = $_POST['userid'];
  $task_name = $_POST['task'];
  $stats = $_POST['stat'];

  // Check if the Tasks already exists for the given user_id
  $checkQuery = "SELECT * FROM tasks WHERE task_id = '$userid' OR task_name = '$task_name' OR project_id = '$userid'";
  $checkResult = mysqli_query($connect, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
      // If a record already exists, show a message and don't insert
      $alerting = '<div id="delete-alert" class="alert alert-warning" role="alert">This department already exists for this user!</div>';
  } else {
      // If no duplicate found, insert the new Tasks
      if (!empty($task_name) && !empty($stats)) {
          $insertQuery = "INSERT INTO tasks (project_id, task_name, stats) VALUES ('$userid', '$task_name', '$stats')";

          if (mysqli_query($connect, $insertQuery)) {
              $alerting = '<div id="success-alert" class="alert alert-success success-alert" role="alert">Department added successfully!</div>';
          } else {
              $alerting = '<div id="delete-alert" class="alert alert-danger" role="alert">Error adding department. Please try again.</div>';
          }
      }
  }
}
} catch (mysqli_sql_exception){
  $alerting = '<div id="delete-alert" class="alert alert-danger" role="alert">Error adding task. Please Specify ID to the Department!.</div>';
}


   // Deleting message 
   if (isset($_GET['delete_error'])&& empty($alerting)) {
    $alerting ='<div id="delete-alert" class="alert alert-danger" role="alert">' . $_GET['delete_error'] . '</div>';
  }

 // Updating employees
 if(isset($_POST['update-button'])){
  $updateid = $_POST['user_id'];
  $task_name = $_POST['task'];
  $stats = $_POST['stat'];
  $updatequery = "UPDATE tasks set task_name = '$task_name', stats = '$stats' WHERE task_id = '$updateid'";
  
  if(mysqli_query($connect, $updatequery)){
    $alerting ='<div id="success-alert" class="alert alert-success" role="alert">You Successfully updated the data!<div>';
  }
  else{
    $alerting ='<div id="error-alert" class="alert alert-danger" role="alert">You Successfully updated the data!<div>';
  }
 }


// SEARCH
$search = "";
if (isset($_POST['searchquery'])) {
    $search = $_POST['searchquery']; // Get the search input
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
          name="searchquery"
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

        <!-- SEARCH BUTTON -->
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
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
              <!-- ENDING SEARCH -->
            </div>
          </form>
        <!-- ENDING SEARCH  -->

               
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
                <span class="me-2"><i class="bi bi-pencil-square"></i></span>
                <span>Task</span>
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
                    <a href="index.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-pencil-square"></i></span>
                      <span>Task</span>
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
            <h4>Task</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Data Table Task
                <div class="d-flex justify-content-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Task</button>
</div>

<!-- Form for Adding Departments -->
<div class="card-body">
    <form action="" method="post">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">ADD TASKS</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="userid">Project_ID:</label>
                            <input type="text" name="userid" class="form-control" required>
                            <label for="department_name">Task Name:</label>
                            <input type="text" name="task" class="form-control" required>
                            <div class="col-md-7">
                            <label for="validationCustom04" class="form-label">State</label>
                            <select name="stat" class="form-select" id="validationCustom04" required>
                            <option selected disabled value="">Choose...</option>
                            <option>In Progress</option>
                            <option>Completed</option>
                            </select>
                            <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="submit" class="btn btn-primary" value="Add Department">
                    </div>
                </div>
            </div>
        </div>   
    </form>
</div>

<table class="table table-borderless table-hover">
    <thead>
        <tr><?php echo $alerting; ?>
            <th>Project ID</th>
            <th>Department ID</th>
            <th>Project Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Task ID</th>
            <th>Task Name</th>
            <th>Stats</th>
            <th>Action</th>
            
        </tr>
        <tbody>
          <?php
            // Assuming $search contains the search keyword
 // Perform search query
$search = "";
if (isset($_POST['searchquery'])) {
    $search = $_POST['searchquery']; // Get the search input
}

if ($search != "") {
    // Search query with JOIN
    $retrieve = "SELECT p.project_id, p.department_id, p.project_name, p.startDate, p.endDate, 
                        t.task_id, t.task_name, t.stats 
                 FROM projects p 
                 JOIN tasks t ON p.project_id = t.project_id
                 WHERE t.task_name LIKE '%$search%' OR p.project_name LIKE '%$search%'
                    OR p.project_id LIKE '%$search%'";
} else {
    // Default query with JOIN
    $retrieve = "SELECT p.project_id, p.department_id, p.project_name, p.startDate, p.endDate, 
                        t.task_id, t.task_name, t.stats 
                 FROM projects p 
                 JOIN tasks t ON p.project_id = t.project_id";
}
          $result = mysqli_query($connect, $retrieve);  
          while ($rows = mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?php echo htmlspecialchars($rows['project_id']); ?></td>
                <td><?php echo htmlspecialchars($rows['department_id']); ?></td>
                <td><?php echo htmlspecialchars($rows['project_name']); ?></td>
                <td><?php echo htmlspecialchars($rows['startDate']); ?></td>
                <td><?php echo htmlspecialchars($rows['endDate']); ?></td>
                <td><?php echo htmlspecialchars($rows['task_id']); ?></td>
                <td><?php echo htmlspecialchars($rows['task_name']); ?></td>
                <td><?php echo htmlspecialchars($rows['stats']); ?></td>
                <td><a href="#" class="btn btn-success update-btn" data-id="<?php echo $rows['task_id']; ?>" data-name="<?php echo $rows['task_name']; ?>" data-email="<?php echo $rows['stats']; ?>" data-bs-toggle="modal" data-bs-target="#updateModal">Update</a></td>
                <td><a href="deletetasks.php?user_id=<?php echo $rows['task_id']; ?>" class="btn btn-danger">Delete</a></td>
            </tr>

            <?php
               }
            ?>

            
<!-- Update Employee Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Tasks</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <!-- Hidden field to pass user_id -->
          <input type="hidden" id="user_id" name="user_id">
          <div class="form-group">
            <label for="task">Task Name:</label>
            <input type="text" id="tasks" name="task" class="form-control" required>
          </div>
        <div class="col-md-7">
            <label for="validationCustom04" class="form-label">State</label>
                <select name="stat" class="form-select" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
            <div class="invalid-feedback">
            Please select a valid state.
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" name="update-button" class="btn btn-primary" value="Update">
      </div>
        </form>
    </div>
  </div>
</div>
  </tbody>
      </thead>
        </table>
            </div>
                <div class="table-responsive">
                  <table
                    id="example"
                    class="table table-striped data-table"
                    style="width: 100%">
                  <!-- Data Charts Table -->
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
         <!-- Data Charts Table -->
                 
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
        var task_name = $(this).data('name');
        var stats = $(this).data('email');

        // Pass the data into the modal inputs
        $('#user_id').val(user_id);
        $('#tasks').val(task_name);
        $('#stats').val(stats);
    });
    }); 
</script>

    </body>
  </body>
</html>


