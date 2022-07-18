<?php

// Connect to the database
$serverName = "localhost";
$userName = "root";
$password = "";
$database = "student_database";

// Create a connection
$connection = mysqli_connect($serverName, $userName, $password, $database);

// Die if connection was not successful
if (!$connection) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `data` WHERE `data`.`sno` = $sno";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>The student record has been deleted successfully</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>The student record delete has been failed</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $_POST["snoEdit"];
        $id = $_POST['studentIdEdit'];
        $name = $_POST['studentNameEdit'];
        $dept = $_POST['deptNameEdit'];
        $phone = $_POST['phoneEdit'];
        $dob = $_POST['dobEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descEdit'];

        // SQL query to be executed
        $sql = "UPDATE `data` SET `id` = '$id',`name` = '$name',`dept` = '$dept',`phone` = '$phone', `dob` = '$dob' WHERE `data`.`sno` = '$sno'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>The student record has been updated successfully</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>The student record update has been failed</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
        }
    } else {
        $id = $_POST['studentId'];
        $name = $_POST['studentName'];
        $dept = $_POST['deptName'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];

        // SQL query to be executed
        $sql = "INSERT INTO `data` (`id`, `name`, `dept`, `phone`, `dob`) VALUES ('$id', '$name', '$dept', '$phone', '$dob')";
        $result = mysqli_query($connection, $sql);

        // Add a new data to the data table in student_database
        if ($result) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>The student record has been created successfully</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>The student record creation has been failed</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <title>CRUD - Student Database</title>

</head>

<body>
   

    <!-----------------Edit Modal ---------------------------------->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/crud/studentCrud.php" method="post">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="title">ID</label>
                            <input type="text" class="form-control" id="studentIdEdit" name="studentIdEdit" aria-describedby="emailHelp" />

                        </div>
                        <div class="form-group">
                                <label for="title">Name</label>
                                <input type="text" class="form-control" id="studentNameEdit" name="studentNameEdit" aria-describedby="emailHelp" />

                            </div>
                            <div class="form-group">
                                <label for="title">Department</label>
                                <input type="text" class="form-control" id="deptNameEdit" name="deptNameEdit" aria-describedby="emailHelp" />

                            </div>
                            <div class="form-group">
                                <label for="title">Phone</label>
                                <input type="text" class="form-control" id="phoneEdit" name="phoneEdit" aria-describedby="emailHelp" />

                            </div>
                            <div class="form-group">
                                <label for="title">Birth Date</label>
                                <input type="date" class="form-control" id="dobEdit" name="dobEdit" aria-describedby="emailHelp" />

                            </div>
                        
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!----------------- Add Data Modal  ---------------------------->
    <div class="container my-4">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add Student
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Student Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/crud/studentCrud.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">ID</label>
                                <input type="text" class="form-control" id="studentId" name="studentId" aria-describedby="emailHelp" />

                            </div>
                            <div class="form-group">
                                <label for="title">Name</label>
                                <input type="text" class="form-control" id="studentName" name="studentName" aria-describedby="emailHelp" />

                            </div>
                            <div class="form-group">
                                <label for="title">Department</label>
                                <input type="text" class="form-control" id="deptName" name="deptName" aria-describedby="emailHelp" />

                            </div>
                            <div class="form-group">
                                <label for="title">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" />

                            </div>
                            <div class="form-group">
                                <label for="title">Birth Date</label>
                                <input type="date" class="form-control" id="dob" name="dob" aria-describedby="emailHelp" />

                            </div>
                            <button type="submit" class="btn btn-primary">Add Data</button>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Displaying Data Here ---------->
    <div class="container my-6">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Phone</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `data`";
                $result = mysqli_query($connection, $sql);
                $serial = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
          <th scope='row'>" . $serial . "</th>
          <td>" . $row['id'] . "</td>
          <td>" . $row['name'] . "</td>
          <td>" . $row['dept'] . "</td>
          <td>" . $row['phone'] . "</td>
          <td>" . $row['dob'] . "</td>
          <td class='d-flex'>
            <a class='btn btn-secondary mr-2 edit' id=" . $row['sno'] . ">Edit</a>
            <a class='btn btn-danger delete' id=d" . $row['sno'] . ">Delete</a>
          </td>
        </tr>";
                    $serial++;
                }
                ?>


            </tbody>
        </table>
    </div>
    <hr>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                id = tr.getElementsByTagName("td")[0].innerText;
                name = tr.getElementsByTagName("td")[1].innerText;
                dept = tr.getElementsByTagName("td")[2].innerText;
                phone = tr.getElementsByTagName("td")[3].innerText;
                dob = tr.getElementsByTagName("td")[4].innerText;
               
                snoEdit.value = e.target.id;
                studentIdEdit.value = id;
                studentNameEdit.value = name;
                deptNameEdit.value = dept;
                phoneEdit.value = phone;
                dobEdit.value = dob;
                //console.log(e.target.id);
                $('#editModal').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                sno = e.target.id.substr(1, );

                if (confirm("are you sure want to delete this ?")) {
                    //console.log(sno);
                    window.location = `/crud/studentCrud.php?delete=${sno}`;
                } else {
                    //console.log("no");
                }
            })
        })
    </script>
</body>

</html>