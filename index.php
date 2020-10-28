<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <title>Notedaker</title>
</head>
<?php
    $insert = false;
    $update = false;
    $delete = false;
    $deleteAll = false;
    $username = "root";
    $servername = "localhost";
    $password = "";
    $database = "Notes";

  $conn = mysqli_connect($servername, $username, $password, $database);
  if (!$conn) {
    die("sorry we could not connect" . mysqli_connect_error());
  }
    if(isset($_GET['delete'])){
      $sno = $_GET['delete']; 
      $sql = 'DELETE FROM `Notes` WHERE `Notes`.`SNo` = '.$sno;
      $result = mysqli_query($conn, $sql);
      if($result){
        $delete = True;
      }
    }
    elseif(isset($_GET['deleteAll'])){
      $sql = "delete from `Notes`";
      $result = mysqli_query($conn, $sql);
      if($result){
        $deleteAll = true;
      }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if(isset($_POST['snoEdit'])){
        $title = $_POST['edittitle'];
        $description = $_POST['editdescription'];
        $sno = $_POST['snoEdit'];
        $sql = "UPDATE `Notes` SET `Title`='$title', `Description` ='$description' WHERE `Notes`.`SNo` =$sno ";
        $result = mysqli_query($conn, $sql);
        if($result){
          $update = True;
      }
      }
      else{
      $title = $_POST['title'];
      $sql = "SELECT * FROM Notes";
      $result = mysqli_query($conn, $sql);
      $num = mysqli_num_rows($result);
      $num = $num+1;
      $description = $_POST['description'];
      $sql = "INSERT INTO `Notes` (`Title`, `Description`) VALUES('$title', '$description')";
      $result = mysqli_query($conn, $sql);
      if ($result){
        $insert = True;
      }
    }
  }
?>

<body>
<!-- Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editmodalLabel">Update Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <form action='index.php' method="POST">
      <div class="form-group">
        <input type="hidden" id="snoEdit" name="snoEdit">
      </div>
      <div class="form-group">
        <label for="edittitle">Note Title</label>
        <input type="text" class="form-control" id="edittitle" name="edittitle">
      </div>
      <div class="form-group">
        <label for="editdescription">Note Description</label>
        <textarea class="form-control" id="editdescription" rows="3" name="editdescription"></textarea>
      </div>
      <div class="modal-footer">
        <button type="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
      </div>
    </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Noteaker</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/crud/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">contact</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <?php
    if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    if($delete){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been Deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    if($update){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been Updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
    if($deleteAll){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> All Notes have been deleted.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
    }
  ?>
  <div class="container my-4">
    <h2>Add A Note</h2>
    <form action='index.php' method="POST">
      <div class="form-group">
        <label for="title">Note Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="form-group">
        <label for="description">Note Description</label>
        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
      <button type="button" class="deleteAll btn btn-primary"> Delete All </button>
    </form>
  </div>
  <?php
  echo '<hr>';
  echo '<div class="container my-4">';
    echo '<table class="table my-4" id="myTable">
    <thead>
      <tr>
        <th scope = "col"> S.No </th>
        <th scope = "col"> Title </th>
        <th scope = "col"> Description </th>
        <th scope = "col"> Actions </th>
      </tr>
      </thead>
      <tbody>';
  $sql = "SELECT * FROM Notes";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  $Sno = 0;
  while ($row = mysqli_fetch_assoc($result)) {
            $Sno += 1;
            echo '
            <tr>
              <td scope="row">'.$Sno.'</td>
              <td>'.$row["Title"].'</td>
              <td>'.$row["Description"].'</td>
              <td> <button class="edit btn btn-sm btn-primary" id='.$row["SNo"].'>Edit</button> <button class="delete btn btn-sm btn-primary" method="get" id=d'.$row['SNo'].'>Delete</button>  </td> 
            </tr>';
    // echo $row['SerialNo'] . ".) " . $row['Title'] . '<br>' . $row['Description'] .'<form action = "/crud/" method"$_POST" style="display:inline; align:right"><button type="submit" class="close" name=del">
    //     <span aria-hidden="true">&times;</span>
    //     </button></form>' . '<br>' . $row['tstamp'];
    // echo "<br><hr>";
  }
  echo '</tbody>';
  echo "</table>";
  echo "</div>";
  echo '<hr>'
  ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
      $('#myTable').DataTable();
    } );
  </script>
</body>
<script>
  edits = document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener("click", (e)=>{
      console.log("clicked",e.target.parentNode.parentNode)
      tr = e.target.parentNode.parentNode
      title = tr.getElementsByTagName("td")[1].innerText;
      description = tr.getElementsByTagName("td")[2].innerText;
      $('#editmodal').modal('toggle')
      edittitle.value = title;
      editdescription.value = description;
      snoEdit.value = e.target.id;
    })
  })
  deletes = document.getElementsByClassName('delete')
  Array.from(deletes).forEach((element)=>{
    element.addEventListener('click', (e)=>{
      sno = e.target.id.substr(1,)
      if(confirm("do you want to delete this")){
        console.log('yes')
        window.location = `/crud/index.php?delete=${sno}`
      }
      else(
        console.log('no')
      )
    })
  })
  delAll = document.getElementsByClassName('deleteAll')
  Array.from(delAll).forEach((element)=>{
    element.addEventListener('click', (e)=>{
      if(confirm("do you want to delete every note")){
      console.log('yes');
      window.location="/crud/index.php?deleteAll= true";
    }
  })
    })
</script>

</html>