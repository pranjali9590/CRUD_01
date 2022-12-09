<?php
//connect to database
$insert = false ;
$update = false ;
$delete = false ;
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
$conn = mysqli_connect($servername, $username, $password, $database);

if (isset($_GET['delete'])){
  $slno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `slno` = $slno";
  $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (isset( $_POST['slnoEdit'])){
    //update the record::::
    $slno = $_POST['slnoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];

    $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`slno` = $slno; ";
    $result = mysqli_query($conn, $sql);
    if($result){
      $update = true;
  }
  else{
      echo "We could not update the record successfully";
  }
  }
  else{
  $title = $_POST['title'];
  $description = $_POST['description'];

  $sql = "INSERT INTO `notes` (`title`, `description`) values ('$title', '$description')";
  $result = mysqli_query($conn, $sql);

 if($result){
  $insert = true;
 }
 else{
  echo "not <br>". mysqli_error($conn);
 }
}
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project-1 PHP CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> 
  
  </head>
  <body>
    <!-- Edit modal 
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> --> 

<!--  Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Record</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/crud/index.php" method= "post" >
      <input type = "hidden" name = "slnoEdit" id = "slnoEdit">      
      <div class="form-group mb-3">
              <label for="title" class="form-label">NOTE TITTLE</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
        
            </div>
            <div class="form-group mb-3">
              <label for="description" class="form-label">NOTE DESCRIPTION</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div> 
            
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="sumbit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="/crud/logo.png" height="28px">  i-NOTES</a>
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
                <a class="nav-link" href="#">Contact US</a>
              </li>             
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

      <?php
      if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>SUCCESSFULL!!!!</strong>Record inserted successfully..!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }

      if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>SUCCESSFULL!!!!</strong>Record updated successfully..!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }

      if($delete){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>ALERT!!!!</strong>Record deleted successfully..!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }

      ?>


      <div class = "container my-4">
        <h2> ADD YOUR NOTES TO i-NOTES</h2>
        <form action="/crud/index.php" method= "post" >
            <div class="mb-3">
              <label for="title" class="form-label">NOTE TITTLE</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">NOTE DESCRIPTION</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            
           
            <button type="submit" class="btn btn-primary">ADD NOTE</button>
          </form>        
      </div>
      <div class="container">
          <table class="table" id="myTable">
            <thead>
              <tr>
                <th scope="col">SLNO.</th>
                <th scope="col">TITTLE</th>
                <th scope="col">DESCRIPTION</th>
                <th scope="col">ACTIONS</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $sql = "select * from notes";
            $result = mysqli_query($conn, $sql);
            $slno =0;
                while($row = mysqli_fetch_assoc($result)){
                $slno= $slno+1;    
                echo "<tr>
                <th scope= 'row'> ". $slno . " </th>
                <td>" . $row['title'] . "</td>
                <td>" . $row ['description']  . "</td>
                <td> <button class='edit btn btn-sm btn-primary' id =".$row['slno'].">EDIT</button>  <button class='delete btn btn-sm btn-primary' id =d".$row['slno'].">DELETE</button> </td>
              </tr>";
                }

            ?>         
              
              
              
            </tbody>
          </table>  
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
        $('#myTable').DataTable();
        } );
    </script>
    <script> 
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit" , );
          tr =  e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title , description);
          titleEdit.value = title
          descriptionEdit.value = description
          slnoEdit.value = e.target.id;
          console.log(e.target.id)
          $('#editModal').modal('toggle');
        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit" , );
          slno = e.target.id.substr(1,);
          if (confirm("Are you sure you want to delete..!!!!")){
            console.log("yes")
            window.location = `/crud/index.php?delete=${slno}`;
          }                       
          else{
            console.log("no");
          }
        })
      })
   </script>
  </body>
</html>