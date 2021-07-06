<?php 
    $insert=false;
    $update=false;
    $delete=false;
    $servername="localhost";
    $username="root";
    $password="";
    $database="note";
    $con=mysqli_connect($servername,$username,$password,$database);
    if(!$con){
      die("Sorry we failed to connect");
    }
    if(isset($_GET['delete'])){
      $sno = $_GET['delete'];
      $delete = true;
      $sql = "DELETE FROM `notes` WHERE `sno` ='$sno'";
      $result = mysqli_query($con, $sql);
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
      if(isset($_POST['snoEdit'])){
        $title=$_POST["titleEdit"];
        $description=$_POST["descriptionEdit"];
        $sno=$_POST["snoEdit"];
        $sql="UPDATE `notes` SET `title` = '$title',`description`='$description' WHERE `notes`.`sno` ='$sno'";
        $result=mysqli_query($con,$sql);
        if($result){
          $update=true;
         }
         else{
           echo "The record cannot update successfully.<br>".mysqli_connect_error($con);
         }
      }
      else{
      $title=$_POST["title"];
      $description=$_POST["description"];
      $sql="INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
      $result=mysqli_query($con,$sql);
      if($result){
       $insert=true;
      }
      else{
        echo "The record cannot insert successfully.<br>".mysqli_connect_error($con);
      }
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <title>CRUD_PRO</title>
   
  </head>
  <body>
 <!-- Button trigger modal
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
      Edit Modal
    </button> -->

<!--edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="/NOTE_CRUD/index.php" method="post">
          <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="mb-3">
              <label for="title" class="form-label">Note title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                  <label for="description" name="description" class="form-label">Note Description</label>
                  <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer  d-block mr-auto">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
          </div>
      </div>
    </div>
      <!-- navbar start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="/NOTE_CRUD/index.php">MyNote</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
              </li>
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
      <?php
      if($insert){
        echo '<div class="alert alert-success" role="alert">
        The record is inserted successfully!!</div>';
      }
      if($update){
        echo '<div class="alert alert-success" role="alert">
        The record is update successfully!!</div>';
      }
      if($delete){
        echo '<div class="alert alert-success" role="alert">
        The record is delete successfully!!</div>';
      }

      ?>

      <!-- form start -->
      <div class="container my-4">
          <h2>Add a Note</h2>
                <form action="/NOTE_CRUD/index.php" method="post">
                <div class="mb-3">
                <label for="title" class="form-label">Note title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="description" name="description" class="form-label">title Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                  </div>
                <button type="submit" class="btn btn-primary">Add Note</button>
            </form>
      </div>

      <div class="container mb-4">
            <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                <?php
                    $sql="SELECT * FROM `notes`";
                    $result=mysqli_query($con,$sql);
                
                    $sno=0;
                    while($row=mysqli_fetch_assoc($result)){
                      $sno=$sno+1;
                      echo "<tr>
                      <th scope='row'>".$sno."</th>
                      <td>".$row['title']."</td>
                      <td>".$row['description']."</td>
                      <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
                      
                    </tr>";
                    }
                     ?>
                       </tbody>
              </table>
        
      </div>
      <hr>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
      $('#myTable').DataTable();
      } );
    </script>
     <script>
      edits=document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          console.log("edit",);
          tr=e.target.parentNode.parentNode;
          title=tr.getElementsByTagName("td")[0].innerText;
          description=tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit.value=title;
          descriptionEdit.value=description;
          snoEdit.value=e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');

        })
      })
      deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/NOTE_CRUD/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
    </script>
  </body>
</html>