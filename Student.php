<?php
session_start();
$id_result;
if(!isset($_SESSION['id'])){
   header('location:adminpage/login_form.php');
}

?>


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
    <link rel="stylesheet" href="bootstrap.min1.css">
    <link rel="stylesheet" href="dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="font-awesome.min.css">

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
                <img src="user.png" alt="home"style="width: 20px; height: 20px;">
                <a style="text-decoration: none;" class="Pseudo" href="student.php">Students</a>
            </li>
            <li>
                <img src="note.png" alt="home"style="width: 20px; height: 20px;">
                <a style="text-decoration: none;" class="Pseudo" href="Course.php">Courses</a>
            </li>
            <li style="float:right;padding-left:500px" >
                <img src="note.png" alt="home"style="width: 20px; height: 20px;">
                <a  style="text-decoration: none;float:right;" class="Pseudo" href="adminpage/logout.php">Log out</a>
            </li>
        </ul>
</div>
<?php
 
if (!isset($_SESSION['id']) ||(trim ($_SESSION['id']) == '')) {
  header('index.php');
  exit();
}
$admin = $_SESSION['id'];

 require_once 'dbconn/dbconn.php';
   
   if(isset($_POST['menu_ar_add'])){
    $full_name = $_POST['full_name_add'];
    $mname = $_POST['mname_add'];
    $lname = $_POST['lname_add'];
    $username = $_POST['username_add'];
    $email = $_POST['email_add'];
    $sql = " select * from student where email = '$email' or student_id = '$username' ";
        $result =  $conn->query($sql);
        $rows=$result->num_rows;
        if($rows == 1){
          ?>
<div class="modal fade" id="validate_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalCenterTitle"><h3>لديك حساب أو اسم مستخدم مسجل بالفعل </h3></h5>
  <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
<div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
<input type="hidden" class="form-control" name="id_delete" value="<?php echo ''.$user['student_id'].''?>" >
<button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">Back</button>

<button type="submit"  class="btn btn-success">Ok</button>
</form>

</div>
</div>
</div>
</div>				
<?php
        }
    elseif($rows==0){
    $query ="INSERT INTO student (student_id, student_name, mname, lname, student_password, email, admin_id) VALUES
    ('$username', '$full_name', '$mname', '$lname', '$username','$email',$admin)";
 
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
  }
  if(isset($_POST['menu_ar_delete'])){
    $id = $_POST['id_delete'];
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->begin_transaction();
try {
        $query ="DELETE FROM student_has_courses WHERE student_id='$id'";
        $stmt = $conn->query($query);
       
        $query ="DELETE FROM student WHERE student_id='$id'";
        $stmt = $conn->query($query);
   $conn->commit();
   header("location:Student.php"); 
} catch (mysqli_sql_exception $exception) {
    echo 'Transaction Failed!!';
    $conn->rollback();
    $conn=null;
    echo'<br>';
    echo $exception->getMessage();
}
  
}
if(isset($_POST['menu_ar_edit'])){
  $full_name = $_POST['full_name'];
  $mname=$_POST['mname'];
  $name=$_POST['name'];
  $username = $_POST['user_name'];
  $email = $_POST['email'];
$query ="update student set student_name='$full_name',mname='$mname',lname='$lname',email='$email' where 
 student_id='$username'";
    $edit =  $conn->query($query);

    if($edit)
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
  if(isset($_POST['menu_ar_result'])){
    $student_id=$_SESSION['std_result'];
    $course_id=$_POST['course_id'];
    $result=$_POST['result'];
  $query ="update student_has_courses set result=$result where 
  student_id='$student_id' and course_id='$course_id' ";
      $edit =  $conn->query($query);
  
      if($edit)
      {
          $conn->close();
          header("location:?user_Course=$student_id"); 
          exit;
      }
      else
      {
        header("location:?result_edit=");
      }    	
  
    }
    if(isset($_POST['menu_ar_result_delete'])){
      $student_id=$_SESSION['std_result'];
      $course_id=$_POST['course_id'];
      $result=$_POST['result'];
      $course_id=$_POST['course_id'];
    $query ="DELETE FROM student_has_courses where student_id='$student_id' and course_id='$course_id'";
        $delete =  $conn->query($query);
    
        if($delete)
        {
            $conn->close();
            header("location:?user_Course=$student_id"); 
            exit;
        }
        else
        {
          header("location:Student.php");
        }   
      }
    
    if(isset($_GET['result_delete'])){
      $id = $_GET['result_delete'];
?>
<div class="modal fade" id="grad_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalCenterTitle"><h3>تأكيد الحدف </h3></h5>
<button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
<div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
<input type="hidden" class="form-control" name="course_id" value="<?php echo $id ?>" >
<button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">رجوع</button>

<button type="submit" name="menu_ar_result_delete" class="btn btn-success">حدف</button>
</form>

</div>
</div>
</div>
</div>				
<?php

 }
  if(isset($_GET['result_edit'])){
    $student_id=$_SESSION['std_result'];
    $course_id = $_GET['result_edit'];
    $sql = mysqli_query($conn , " select * from student_has_courses where
    student_id ='$student_id' and course_id='$course_id'");
    $user= mysqli_fetch_assoc($sql);
?>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalCenterTitle"><h3>إضافة درجة</h3></h5>
<button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
<div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
<input type="number" class="form-control" name="result" value="<?php echo ''.$user['result'].''?>" >
<br><br>
<input type="hidden" class="form-control" name="course_id" value="<?php echo ''.$user['course_id'].''?>" >
<button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">رجوع</button>

<button type="submit" name="menu_ar_result" class="btn btn-success">إضافة</button>
</form>

</div>
</div>
</div>
</div>				
<?php

}
   if(isset($_GET['user_add'])){

    ?>
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">إضافة</h5>
        <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
		<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
						
						
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">الاسم الاول</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" required name="full_name_add"  >
						</div>
					  </div>
            <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">إسم الاب</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" required name="mname_add"  >
						</div>
					  </div>
            <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">اللقب</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" required name="lname_add"  >
						</div>
					  </div>
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">رقم القيد</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" required name="username_add"  >
						</div>
					  </div>
					  
            <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">البريد الإلكتروني</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control"  name="email_add"  >
						</div>
					  </div>
					  
		   <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
        <button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">رجوع</button>
		 
        <button type="submit" name="menu_ar_add" class="btn btn-success">انشاء</button>
		  </form>

      </div>
    </div>
  </div>
</div>				
		<?php
    
   }
   if(isset($_GET['user_delete'])){
        $id = $_GET['user_delete'];
        $sql = mysqli_query($conn , " select * from student where student_id = '$id' ");
        $user= mysqli_fetch_assoc($sql);
?>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalCenterTitle"><h3>تأكيد الحدف </h3></h5>
  <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
<div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
<input type="hidden" class="form-control" name="id_delete" value="<?php echo ''.$user['student_id'].''?>" >
<button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">رجوع</button>

<button type="submit" name="menu_ar_delete" class="btn btn-success">حدف</button>
</form>

</div>
</div>
</div>
</div>				
<?php

   }
if(isset($_GET['user_edit'])){
 
  $id = $_GET['user_edit'];
        $sql = mysqli_query($conn , " select * from student where student_id = '$id' ");
        $user= mysqli_fetch_assoc($sql);
?>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">تعديل بيانات الطالب</h5>
        <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  
		<form class="contact-form "  action="Student.php" method="post" id="" enctype="multipart/form-data">
						
						
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">الاسم الاول</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="full_name" value="<?php echo ''.$user['student_name'].''?>" >
						</div>
					  </div>
            <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">إسم الاب</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="mname" value="<?php echo ''.$user['mname'].''?>" >
						</div>
					  </div>
            <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">اللقب</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="lname" value="<?php echo ''.$user['lname'].''?>" >
						</div>
					  </div>
					  <div class="form-group row">
						  <input type="hidden" class="form-control" required name="user_name" value="<?php echo ''.$user['student_id'].'' ?>" >
					  </div>
					  
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-3 col-form-label">Email</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="email" value="<?php echo ''.$user['email'].''?>" >
						</div>
					  </div>
					  
		   <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
        <button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">رجوع</button>
		 
        <button type="submit" name="menu_ar_edit" class="btn btn-success">تعديل</button>
		  </form>

      </div>
    </div>
  </div>
</div>				
		<?php
  }

  if(isset($_GET['user_Course'])){
     $id = $_GET['user_Course'];
           $sql = mysqli_query($conn , " select * from student_has_courses where student_id ='$id'");
           $user= mysqli_fetch_assoc($sql);
    
        ?>
        
        <div class="modal fade" id="select" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><h3>مقررات الطالب </h3></h5>
          <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <table class="table">
        <thead>
          <tr>
            <th scope="col">رمز المقرر</th>
            <th scope="col">إسم المقرر</th>
            <th scope="col">عدد الوحدات</th>
            <th scope="col">النتيجة</th>
            <th scope="col">تعديل النتيجة</th>
            <th scope="col">حدف المقرر</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $_SESSION['std_result']=$id;
          $select ="SELECT * FROM student JOIN student_has_courses ON student.student_id=student_has_courses.student_id
	        JOIN courses ON courses.course_id=student_has_courses.course_id WHERE student.student_id='$id' ";
	        $result =  $conn->query($select);
          $rows=$result->num_rows;
          $num = 1;
          $grad[$rows]=0;
	        while($row = $result->fetch_array(MYSQLI_ASSOC)){	
              if($row['result']==-1){
                $grad[$num++]=0;
              }
            else{
              $grad[$num++]=$row['result'];
            }
	        	echo '
	        			<tr>
	        			  <td>'.$row['course_id'].'</td>
	        			  <td>'.$row['course_name'].'</td>
	        			  <td>'.$row['number_units'].'</td>
                  <td>'.$grad[$num-1].'</td>
                  <td><a href="?result_edit='.$row['course_id'].'" class="btn btn-warning">تعديل</a></td>
                  <td><a href="?result_delete='.$row['course_id'].'" class="btn btn-warning">حدف</a></td>

                  </tr>
	        	';	
          }
	      ?>
        </tbody>
        </table> 
        <form class="contact-form " action="Student.php" method="post" id="" enctype="multipart/form-data">
        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
        <button type="button" onclick="goBack()" class="btn btn-danger" data-dismiss="modal">رجوع</button>
        
        <button type="submit" name="menu_ar_select" class="btn btn-success">موافق</button>
        </form>
        
        </div>
        </div>
        </div>
        </div>	
      <?php
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
<button style="float:right; background:#ffffff;border-color:#007bff; margin-right:50px" type="submit" name="menu_ar_edit" class="btn btn-success"><a href="?user_add=" style="color:black;text-decoration: none;">إضافة طالب</a></button>
  </form>
	<h1 class="h1_student" >Students List</h1>
</div>
	<table class="table">
	  <thead>
		<tr>
		  <th scope="col">#</th>
		  <th scope="col">الاسم</th>
      <th scope="col">رقم القيد</th>
		  <th scope="col">بريد الالكتروني</th>
      <th scope="col">حدف</th>
		  <th scope="col">تعديل</th>
      <th scope="col">المقررات</th>
		</tr>
	  </thead>
	  <tbody>
	  <?php

		$sql = mysqli_query($conn ,"select * from student");
		$num = 1;
		while($user = mysqli_fetch_assoc($sql)){
			echo '
					<tr>
					  <th scope="row">'.$num++.'</th>
					  <td>'.$user['student_name']." ".$user['mname']." ".$user['lname'].'</td>
					  <td>'.$user['student_id'].'</td>
					  <td>'.$user['email'].'</td>
            <td><a href="?user_delete='.$user['student_id'].'" class="btn btn-warning">حدف</a></td>
					  <td><a href="?user_edit='.$user['student_id'].'" class="btn btn-warning">تعديل</a></td>
            <td><a href="?user_Course='.$user['student_id'].'" class="btn btn-warning">مقررات</a></td>
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
        $('#grad_delete').modal('show');
    });
</script>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#add').modal('show');
    });
</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#validate_email').modal('show');
    });
</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#select').modal('show');
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
$('#validate_email').modal({
backdrop: 'static',
keyboard: false
})
</script>

<script>
$('#select').modal({
backdrop: 'static',
keyboard: false
})
</script>
<script>
$('#grad_delete').modal({
backdrop: 'static',
keyboard: false
})
</script>
<script type="text/javascript" src="validate.js"></script>
    <script src="bootstrap.bundle.min.js"></script>
  <script src="dataTables.bootstrap4.min.js"></script>
  <script src="jquery-3.3.1.slim.min.js"></script>
  <script src="jquery.dataTables.min.js"></script>
</body>
</html>