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
   
   if(isset($_POST['menu_ar_add'])){
    $full_name = $_POST['full_name_add'];
    $username = $_POST['username_add'];
    $password = $_POST['password_add'];
 
    $query ="INSERT INTO student (student_id, student_name, student_password,admin_id) VALUES
    ('$username', '$full_name', '$password',$admin)";
 
   $result = $conn->query($query);
   if ($result) {
    $conn->close();
    header("location:Student.php"); 
      exit;
   } else {
    echo "<p>Unable to execute the query.</p> ";
    echo $query;
    die ($conn -> error);
   }
 
  }
  if(isset($_POST['menu_ar_delete'])){
    $id = $_POST['id_delete'];
  $query ="DELETE FROM student WHERE id = $id ";
  $delete =  $conn->query($query);

  if($delete)
  {
      $conn->close();
      header("location:Student.php"); 
        exit;
  }
  else
  {
      echo "<p>Unable to execute the query.</p> ";
      echo $query;
      die ($conn -> error);
  }    	
  
}
if(isset($_POST['menu_ar_edit'])){
  $full_name = $_POST['full_name'];
  $username = $_POST['user_name'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $id =$_POST['id'];
$query ="update student set student_id='$username', student_name='$full_name',email='$email', student_password=$password where  id=$id";
    $edit =  $conn->query($query);

    if($edit)
    {
        $conn->close();// Close connection
        header("location:Student.php"); // redirects to all records page
        exit;
    }
    else
    {
        echo "<p>Unable to execute the query.</p> ";
        echo $query;
        die ($conn -> error);
    }    	

  }
   if(isset($_GET['user_add'])){

    echo '
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Student</h5>
        <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
		<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
						
						
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">Full Name</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="full_name_add"  >
						</div>
					  </div>
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">User Name</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="username_add"  >
						</div>
					  </div>
					  
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">Password</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="password_add" >
						</div>
					  </div>
					  
		   <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
        <button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">Back</button>
		 
        <button type="submit" name="menu_ar_add" class="btn btn-success">Create</button>
		  </form>

      </div>
    </div>
  </div>
</div>				
		';
    
   }
   if(isset($_GET['user_delete'])){
        $id = $_GET['user_delete'];
        $sql = mysqli_query($conn , " select * from student where id = '$id' ");
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
<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
<div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
<input type="hidden" class="form-control" name="id_delete" value="'.$user['id'].'" >
<button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">Back</button>

<button type="submit" name="menu_ar_delete" class="btn btn-success">Delete</button>
</form>

</div>
</div>
</div>
</div>				
';

   }
if(isset($_GET['user_edit'])){
 
  $id = $_GET['user_edit'];
        $sql = mysqli_query($conn , " select * from student where id = '$id' ");
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
	  
		<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
						
						
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">Full Name</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="full_name" value="'.$user['student_name'].'" >
						  <input type="hidden" class="form-control" name="id" value="'.$user['id'].'" >
						</div>
					  </div>
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">User Name</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="user_name" value="'.$user['student_id'].'" >
						</div>
					  </div>
					  
            <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">Password</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="password" value="'.$user['password'].'" >
						</div>
					  </div>
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">Email</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="email" value="'.$user['email'].'" >
						</div>
					  </div>
					  
		   <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
        <button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">Back</button>
		 
        <button type="submit" name="menu_ar_edit" class="btn btn-success">Edit</button>
		  </form>

      </div>
    </div>
  </div>
</div>				
		';
  }
  if(isset($_GET['user_Course'])){
     $id = $_GET['user_Course'];
           $sql = mysqli_query($conn , " select * from courses_has_student where student_id = '$id' ");
           $user= mysqli_fetch_assoc($sql);
    
           echo '
        
        <div class="modal fade" id="course" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><h3>Courses For Student </h3></h5>
          <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">courses</th>
            <th scope="col">Number Of Units</th>
            <th scope="col">Result</th>
          </tr>
        </thead>
        <tbody>';
        $sql = mysqli_query($conn ,"select * from courses_has_student ");
        $num = 1;
        while($user = mysqli_fetch_assoc($sql)){
                   echo ' <tr>
                      <th scope="row">'.$num++.'</th>
                      <td>'.$user['student_id'].'</td>
                    </tr>
                    ';
        }	
        echo '
        </tbody>
        </table> 
        <div class="modal-body">
        <form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
        <button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">Back</button>
        
        <button type="submit" name="menu_ar_delete" class="btn btn-success">Ok</button>
        </form>
        
        </div>
        </div>
        </div>
        </div>	
        ';
     }
?>
<style>
  .h1_student{
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
<form action="Student.php" method="get">
<div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
<button style="float:right; background:#ffffff;border-color:#007bff; margin-right:50px" type="submit" name="menu_ar_edit" class="btn btn-success"><a href="?user_add=" style="color:black;text-decoration: none;">Create Student</a></button>
  </form>
	<h1 class="h1_student" >Students List</h1>
</div>
	<table class="table">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">Full Name</th>
		  <th scope="col">User Name</th>
		  <th scope="col">Email</th>
      <th scope="col">Delete</th>
		  <th scope="col">Edit</th>
      <th scope="col">Courses</th>
		</tr>
	  </thead>
	  <tbody>

	  <?php
	

		$sql = mysqli_query($conn ,"select * from student ");
		$num = 1;
		while($user = mysqli_fetch_assoc($sql)){
			echo '
					<tr>
					  <th scope="row">'.$num++.'</th>
					  <td>'.$user['student_name'].'</td>
					  <td>'.$user['student_id'].'</td>
					  <td>'.$user['email'].'</td>
            <td><a href="?user_delete='.$user['id'].'" class="btn btn-warning">Delete</a></td>
					  <td><a href="?user_edit='.$user['id'].'" class="btn btn-warning">Edit</a></td>
            <td><a href="?user_Course='.$user['id'].'" class="btn btn-warning">Select</a></td>
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
        $('#add').modal('show');
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
$('#add').modal({
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