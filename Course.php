<?php
session_start();
require_once 'dbconn/dbconn.php';
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
                <img src="user.png" alt="home" style="width: 20px; height: 20px;">
                <a style="text-decoration: none;" class="Pseudo" href="student.php">Students</a>
            </li>
            <li>
                <img src="note.png" alt="home" style="width: 20px; height: 20px;">
                <a style="text-decoration: none;" class="Pseudo" href="Course.php">Courses</a>
            </li>
            <li style="float:right;padding-left:500px">
                <img src="note.png" alt="home" style="width: 20px; height: 20px;">
                <a style="text-decoration: none;float:right;" class="Pseudo" href="adminpage/logout.php">Log out</a>
            </li>
        </ul>
    </div>
    <?php
 
if (!isset($_SESSION['id']) ||(trim ($_SESSION['id']) == '')) {
  header('index.php');
  exit();
}
$admin = $_SESSION['id'];

   if(isset($_POST['menu_course_add'])){
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $number_units = $_POST['number_units'];
    $class_of = $_POST['class_of'];
    $sql = " select * from courses where course_id ='$course_id'";
        $result =  $conn->query($sql);
        $rows=$result->num_rows;
        if($rows > 0){
          ?>
    <div class="modal fade" id="validate_material" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        <h3>لديك رمز مادة مسجل بالفعل مسبقا </h3>
                    </h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="contact-form " action="Course.php" method="post" id="" enctype="multipart/form-data">
                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <input type="hidden" class="form-control" name="course_id"
                            value="<?php echo ''.$user['course_id'].''?>">
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" class="btn btn-success">موافق</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
        }
        else  if($rows == 0){
          $conn->begin_transaction();
          try {
            $query ="INSERT INTO courses (course_id, course_name, number_units,class_of,admin_id) VALUES
            ('$course_id', '$course_name',$number_units,$class_of,$admin)";
         
           $result = $conn->query($query);
             $conn->commit();
             header("location:Course.php"); 
          } catch (mysqli_sql_exception $exception) {
            
              echo 'Transaction Failed!!';
              $conn->rollback();
              $conn=null;
              echo'<br>';
              echo $exception->getMessage();
              header("location:?course_add=");
          }
  }
  }
  if(isset($_POST['menu_course_delete'])){
    $course_id = $_POST['id_delete'];
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn->begin_transaction();
try {
        $query ="DELETE FROM requirements where course_id='$course_id'";
        $delete = $conn->query($query);

        $query ="DELETE FROM student_has_courses WHERE course_id='$course_id'";
        $stmt = $conn->query($query);
        $query ="DELETE FROM courses where course_id='$course_id'";
        $delete = $conn->query($query);
   $conn->commit();
   header("location:course.php"); 
}
catch (mysqli_sql_exception $exception) {
    echo 'Transaction Failed!!';
    $conn->rollback();
    $conn=null;
    echo'<br>';
    echo $exception->getMessage();
    header("location:course.php");
}
}
if(isset($_POST['menu_course_edit'])){

  $course_id = $_POST['course_id'];
  $course_name = $_POST['course_name'];
  $number_units = $_POST['number_units'];
  $class_of = $_POST['class_of'];
    $conn->begin_transaction();
    try {
      $query ="update courses set  course_name='$course_name', number_units=$number_units , class_of=$class_of where  course_id='$course_id'";
      $course_edit =  $conn->query($query);
       $conn->commit();
       header("location:Course.php"); 
    } catch (mysqli_sql_exception $exception) {
      
        echo 'Transaction Failed!!';
        $conn->rollback();
        $conn=null;
        echo'<br>';
        echo $exception->getMessage();
        header("location:?course_edit=");
    }	

  }
  
if(isset($_POST['menu_course_requir'])){
  $found=0;
  $course_id = $_POST['course_id'];
  $requir_id = $_POST['requir_id'];
  
  if($requir_id == $course_id){
    ?>
    <div class="modal fade" id="validate_requir" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        <h3>لا يمكن إضافة هذا المتطلب </h3>
                    </h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="contact-form " action="Course.php" method="post" id="" enctype="multipart/form-data">
                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <input type="hidden" class="form-control" name="course_id"
                            value="<?php echo ''.$user['course_id'].''?>">
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" class="btn btn-success">موافق</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
  }
  else{
  $sql = " select * from requirements where course_id='$course_id'";
      $result =  $conn->query($sql);
      $rows=$result->num_rows;
      for( $i=0 ; $i < $rows ; ++$i ){
          $row = $result->fetch_array(MYSQLI_ASSOC);
          if( $row['Requirement_id'] == $requir_id){
              $found=1;
          }
      }
      if($found==0){
        $found_course=0;
        $sql = " select * from courses ";
      $result =  $conn->query($sql);
      $rows=$result->num_rows;
      for( $i=0 ; $i < $rows ; ++$i ){
          $row = $result->fetch_array(MYSQLI_ASSOC);
          if( $row['course_id'] == $requir_id){
            echo $row['course_id'].$requir_id;
            $found_course=1;
          }
        }
          if($found_course==1){
  $query ="INSERT INTO requirements (Requirement_id,course_id, admin_id) VALUES
  ('$requir_id','$course_id',$admin)";
  $course_requir =  $conn->query($query);

  if($course_requir)
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
elseif($found_course==0){
  ?>
    <div class="modal fade" id="course_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        <h3>لم يتم العثور على هذه المادة</h3>
                    </h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="contact-form " action="Course.php" method="post" id="" enctype="multipart/form-data">
                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <input type="hidden" class="form-control" name="course_id"
                            value="<?php echo ''.$user['course_id'].''?>">
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" class="btn btn-success">موافق</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php  
}


}
elseif($found==1) {
  ?>
    <div class="modal fade" id="validate_requir" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        <h3>لديك رمز المادة مسجل بالفعل</h3>
                    </h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="contact-form " action="Course.php" method="post" id="" enctype="multipart/form-data">
                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <input type="hidden" class="form-control" name="course_id"
                            value="<?php echo ''.$user['course_id'].''?>">
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" class="btn btn-success">موافق</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
}  
  }
} 	
  if(isset($_GET['course_add'])){

    ?>
    <div class="modal fade" id="course_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">إضافة مقرر</h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="contact-form " action="Course.php" method="post" id="" enctype="multipart/form-data">


                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">رمز المادة</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="course_id">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">إسم المقرر</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="course_name">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">عدد الوحدات</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="number_units">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">عدد الطلبة لهذا المقرر</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="class_of">
                            </div>
                        </div>

                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" name="menu_course_add" class="btn btn-success">إنشاء</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
    
   }
   if(isset($_GET['course_delete'])){
        $course_id = $_GET['course_delete'];
        $sql = mysqli_query($conn , " select * from courses where course_id='$course_id'");
        $user= mysqli_fetch_assoc($sql);
?>
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        <h3>تأكيد الحدف </h3>
                    </h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="contact-form " action="course.php" method="post" id="" enctype="multipart/form-data">
                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <input type="hidden" class="form-control" name="id_delete"
                            value="<?php echo ''.$user['course_id'].''?>">
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" name="menu_course_delete" class="btn btn-success">حدف</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
   }
if(isset($_GET['course_edit'])){
 
  $course_id = $_GET['course_edit'];
        $sql = mysqli_query($conn , " select * from courses where course_id ='$course_id'");
        $user= mysqli_fetch_assoc($sql);
?>
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">تعديل مقرر</h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="contact-form " action="Course.php" method="post" id="" enctype="multipart/form-data">


                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">رمز المقرر</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="course_id"
                                    value="<?php echo ''.$user['course_id'].'';?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">إسم المقرر</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="course_name"
                                    value="<?php echo ''.$user['course_name'].'';?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">عدد الوحدات</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="number_units"
                                    value="<?php echo ''.$user['number_units'].'';?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">عدد الطلبة لهذا المقرر</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="class_of"
                                    value="<?php echo ''.$user['class_of'].'';?>">
                            </div>
                        </div>

                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" name="menu_course_edit" class="btn btn-success">تعديل</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
  }
  
if(isset($_GET['course_requir'])){
  $course_id = $_GET['course_requir'];
  ?>
    <div class="modal fade" id="course_requir" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">إضافة متطلب</h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="contact-form " action="Course.php" method="post" id="" enctype="multipart/form-data">


                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">رمز المقرر</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" required name="requir_id">
                                <input type="hidden" lass="form-control" name="course_id"
                                    value="<?php echo $course_id ?>">
                            </div>
                        </div>


                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" name="menu_course_requir" class="btn btn-success">إضافة</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
  
  }
  if(isset($_GET['course_show'])){
    $course_id = $_GET['course_show'];
    ?>
    <div class="modal fade" id="course_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">عرض المتطلبات</h5>
                    <button type="button" class="close" onclick="goBack()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="contact-form " action="course.php" method="post" id="" enctype="multipart/form-data">


                        <div class="form-group row">
                            <div class="col-sm-9">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">رمز المقرر</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
      $sql = " select * from requirements where course_id='$course_id'";
      $result =  $conn->query($sql);
      $rows=$result->num_rows;
      for( $i=0 ; $i < $rows ; ){
          $row = $result->fetch_array(MYSQLI_ASSOC);
          echo '
					<tr>
					  <th scope="row">'.++$i.'</th>
					  <td>'.$row['Requirement_id'].'</td>
            ';
          } 
      ?>
                                    </tbody>
                                </table>
                                <input type="hidden" lass="form-control" name="course_id"
                                    value="<?php echo $course_id ?>">
                            </div>
                        </div>
                        <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
                        <button type="button" onclick="goBack()" class="btn btn-danger"
                            data-dismiss="modal">رجوع</button>

                        <button type="submit" class="btn btn-success">موافق</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
    
    }
  ?>

    <style>
    .h1_course {
        font-size: 25px;
        text-align: center;
        margin: 20px;
        color: #326091;
        box-shadow: 10px 5px 5px rgb(0 123 255 / 50%);
    }
    </style>
    <div class="bt_pos">
        <form action="Course.php" method="get">
            <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;"></div>
            <button style="float:right; background:#ffffff;border-color:#007bff; margin-right:50px" type="submit"
                name="menu_course_edit" class="btn btn-success"><a href="?course_add="
                    style="color:black;text-decoration: none;">إضافة مقرر</a></button>
        </form>
        <h1 class="h1_course">Courses List</h1>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">رمز المقرر</th>
                <th scope="col">إٍسم المقرر</th>
                <th scope="col">عدد الوحدات</th>
                <th scope="col">حدف</th>
                <th scope="col">تعديل</th>
                <th scope="col">المتطلبات</th>
                <th scope="col">عرض</th>

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
            <td><a href="?course_delete='.$user['course_id'].'" class="btn btn-warning">حدف</a></td>
					  <td><a href="?course_edit='.$user['course_id'].'" class="btn btn-warning">تعديل</a></td>
            <td><a href="?course_requir='.$user['course_id'].'" class="btn btn-warning">إضافة</a></td>
            <td><a href="?course_show='.$user['course_id'].'" class="btn btn-warning">عرض</a></td>

					</tr>
			';
		}	
	?>

        </tbody>
    </table>

    <script type="text/javascript">
    $(window).on('load', function() {
        $('#edit').modal('show');
    });
    </script>
    <script type="text/javascript">
    $(window).on('load', function() {
        $('#delete').modal('show');
    });
    </script>
    <script type="text/javascript">
    $(window).on('load', function() {
        $('#course_add').modal('show');
    });
    </script>

    <script type="text/javascript">
    $(window).on('load', function() {
        $('#course').modal('show');
    });
    </script>
    <script type="text/javascript">
    $(window).on('load', function() {
        $('#course_requir').modal('show');
    });
    </script>

    <script type="text/javascript">
    $(window).on('load', function() {
        $('#validate_material').modal('show');
    });
    </script>
    <script type="text/javascript">
    $(window).on('load', function() {
        $('#course_show').modal('show');
    });
    </script>
    <script>
    $('#validate_material').modal({
        backdrop: 'static',
        keyboard: false
    })
    </script>
    <script>
    $('#validate_requir').modal({
        backdrop: 'static',
        keyboard: false
    })
    </script>
    <script>
    $('#course_show').modal({
        backdrop: 'static',
        keyboard: false
    })
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
    <script>
    $('#course_requir').modal({
        backdrop: 'static',
        keyboard: false
    })
    </script>
    <script type="text/javascript" src="validate.js"></script>
</body>

</html>