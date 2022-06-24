<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCollege</title>
    <link href="main.css" rel="stylesheet">    
<link href="bootstrap.min.css" rel="stylesheet">
<link href="main-style.css" rel="stylesheet">
<script src="jquery-3.3.1.min.js"></script>
<script src="popper.min.js"></script>
<script src="bootstrap.min.js"></script>
<script src="fontawesome-all.min.js"></script>
<script src="form-jquery.js" type="text/javascript"></script>	
<script src="main-js.js"></script>
 
    <script></script>
</head>
<body>
    <div class="nav_bar">
        <ul class="top-bar">
            <li>
                <img src="home.png" alt="home"style="width: 20px; height: 20px;">
                <a style="text-decoration: none;" class="Pseudo" href="Home.php">Home</a>
            </li>
            <li>
                <img src="user.png" alt="home"style="width: 20px; height: 20px;">
                <a style="text-decoration: none;" class="Pseudo" href="student.php">Students</a>
            </li>
            <li>
                <img src="note.png" alt="home"style="width: 20px; height: 20px;">
                <a style="text-decoration: none;" class="Pseudo" href="Course.php">Courses</a>
            </li>
        </ul>
</div>
<?php
$admin = 1;
 require_once 'dbconn.php';
 $conn = new mysqli($hn, $un, $pw, $db);
 if ($conn->connect_error) {
     echo "<p>Error: Could not connect to database.<br/>
     Please try again later.</p>";
       die($conn -> error);
   }
   
   if(isset($_POST['menu_course_add'])){
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $number_units = $_POST['number_units'];
 
    $query ="INSERT INTO courses (course_id, course_name, number_units,admin_id) VALUES
    ('$course_id ', '$course_name', '$number_units',$admin)";
 
   $result = $conn->query($query);
   if ($result) {
    $conn->close();
    header("location:course.php"); 
      exit;
   } else {
    echo "<p>Unable to execute the query.</p> ";
    echo $query;
    die ($conn -> error);
   }
 
  }
  if(isset($_POST['menu_course_delete'])){
    $id = $_POST['id_delete'];
  $query ="DELETE FROM courses WHERE id = $id ";
  $delete =  $conn->query($query);

  if($delete)
  {
      $conn->close();
      header("location:course.php"); 
        exit;
  }
  else
  {
      echo "<p>Unable to execute the query.</p> ";
      echo $query;
      die ($conn -> error);
  }    	
  
}
if(isset($_POST['menu_course_edit'])){
  $course_id = $_POST['course_id'];
  $course_name = $_POST['course_name'];
  $number_units = $_POST['number_units'];
  $id =$_POST['id'];
$query ="update courses set  course_name='$course_name', number_units=$number_units where  id=$id";
    $course_edit =  $conn->query($query);

    if($course_edit)
    {
        $conn->close();// Close connection
        header("location:course.php"); // redirects to all records page
        exit;
    }
    else
    {
        echo "<p>Unable to execute the query.</p> ";
        echo $query;
        die ($conn -> error);
    }    	

  }
   if(isset($_GET['course_add'])){

    echo '
<div class="modal fade" id="course_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Student</h5>
        <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
		<form class="contact-form "  action="course.php" method="post" id="" enctype="multipart/form-data">
						
						
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">material code</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="course_id"  >
						</div>
					  </div>
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">material Name</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="course_name"  >
						</div>
					  </div>
					  
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">Number Of Units</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="number_units" >
						</div>
					  </div>
					  
		   <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
        <button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">Back</button>
		 
        <button type="submit" name="menu_course_add" class="btn btn-success">Create</button>
		  </form>

      </div>
    </div>
  </div>
</div>				
		';
    
   }
   if(isset($_GET['course_delete'])){
        $id = $_GET['course_delete'];
        $sql = mysqli_query($conn , " select * from courses where id = '$id' ");
        $user= mysqli_fetch_assoc($sql);
echo '
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalCenterTitle"><h3>Are You Sure </h3></h5>
  <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
<form class="contact-form "  action="course.php" method="post" id="" enctype="multipart/form-data">
<div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
<input type="hidden" class="form-control" name="id_delete" value="'.$user['id'].'" >
<button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">Back</button>

<button type="submit" name="menu_course_delete" class="btn btn-success">Delete</button>
</form>

</div>
</div>
</div>
</div>				
';

   }
if(isset($_GET['course_edit'])){
 
  $id = $_GET['course_edit'];
        $sql = mysqli_query($conn , " select * from courses where id = '$id' ");
        $user= mysqli_fetch_assoc($sql);
echo '
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit User</h5>
        <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
		<form class="contact-form "  action="course.php" method="post" id="" enctype="multipart/form-data">
						
						
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">material code</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="course_id" value="'.$user['course_id'].'" >
						  <input type="hidden" class="form-control" name="id" value="'.$user['id'].'" >
						</div>
					  </div>
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">material Name</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="course_name" value="'.$user['course_name'].'" >
						</div>
					  </div>
					  
            <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">Number Of Units</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="number_units" value="'.$user['number_units'].'" >
						</div>
					  </div>
					  
		   <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
        <button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">Back</button>
		 
        <button type="submit" name="menu_course_edit" class="btn btn-success">Edit</button>
		  </form>

      </div>
    </div>
  </div>
</div>				
		';
  }
?>
<style>
  .h1_course{
    font-size: 25px;
    text-align: center;
    margin: 20px;
    color: #326091;
    box-shadow: 10px 5px 5px rgb(0 123 255 / 50%);
  }
  .bt_pos {

  }
</style>
<div class="bt_pos">
<form action="Course.php" method="get">
<div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
<button style="float:right; background:#ffffff;border-color:#007bff; margin-right:50px" type="submit" name="menu_course_edit" class="btn btn-success"><a href="?course_add=" style="color:black;text-decoration: none;">Create Mematerial</a></button>
  </form>
	<h1 class="h1_course" >Courses List</h1>
</div>
	<table class="table">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">Material Code</th>
		  <th scope="col">Meterial Name</th>
		  <th scope="col">Number Of Units</th>
      <th scope="col">Delete</th>
		  <th scope="col">Edit</th>
		</tr>
	  </thead>
	  <tbody>

	  <?php
	

		$sql = mysqli_query($conn ,"select * from courses ");
		$num = 1;
		while($user = mysqli_fetch_assoc($sql)){
			echo '
					<tr>
					  <th scope="row">'.$num++.'</th>
					  <td>'.$user['course_id'].'</td>
					  <td>'.$user['course_name'].'</td>
					  <td>'.$user['number_units'].'</td>
            <td><a href="?course_delete='.$user['id'].'" class="btn btn-warning">Delete</a></td>
					  <td><a href="?course_edit='.$user['id'].'" class="btn btn-warning">Edit</a></td>
					</tr>
			';
		}	
	?>
	
  </tbody>
</table>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#edit').modal('show');
    });
</script>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#delete').modal('show');
    });
</script>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#course_add').modal('show');
    });
</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#course').modal('show');
    });
</script>
<script>

function goBack() {
    window.history.back();
}
</script>


<script>
$('#edit').modal({
backdrop: 'static',
keyboard: false
})
</script>

<script>
$('#delete').modal({
backdrop: 'static',
keyboard: false
})
</script>

<script>
$('#course_add').modal({
backdrop: 'static',
keyboard: false
})
</script>

<script>
$('#course').modal({
backdrop: 'static',
keyboard: false
})
</script>
    <script type="text/javascript" src="validate.js"></script>
</body>
</html>