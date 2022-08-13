<?php 
session_start();

require_once '../dbconn/check_student.php';
if($flag){
if(!isset($_SESSION['user_id']) or !isset($_SESSION['user_name']) or !isset($_SESSION['last_name'])){
	header('location:login_std.php');
}
}
else{
	$_SESSION['user_id']="";
	$_SESSION['user_name']="";
	header('location:login_std.php');
}
 require_once '../dbconn/dbconn.php';
$student_id=$_SESSION['user_id'] ;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تنزيل مواد</title>
    <link rel="stylesheet" href="style1.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href="../bootstrap.min.css" rel="stylesheet">
    <link href="../main-style.css" rel="stylesheet">
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../popper.min.js"></script>
    <script src="../bootstrap.min.js"></script>
    <script src="../fontawesome-all.min.js"></script>
    <script src="../form-jquery.js" type="text/javascript"></script>
    <script src="../main-js.js"></script>

</head>

<body>
    <input type="checkbox" id="checkbox">
    <header class="header">
        <h2 class="u-name">My <b>College</b>
            <label for="checkbox">
                <i id="navbtn" class='bx bx-menu bx-flip-horizontal bx-flashing' style='color:#fdfdfd'></i>

            </label>
        </h2>
    </header>
    <div class="body">
        <nav class="side-bar">
            <div class="user-p">
                <img src="image/profile.png">
                <p><span style="color:white;"><?php echo $_SESSION['user_name']."  ".$_SESSION['last_name'] ?></span>
                </p>
            </div>
            <ul>
                <li>
                    <a href="main.php">
                        <i class='bx bx-home bx-flashing' style='color:#f9f4f4'></i><span> الرئيسي </span>

                    </a>
                </li>
                <li>
                    <a href="profile.php">
                        <i class='bx bx-user bx-flashing' style='color:#fdfdfd'></i><span>السجل الشخصي </span>
                    </a>
                </li>
                <li>
                    <a href="show_result.php">
                        <i class='bx bxs-spreadsheet bx-flashing' style='color:#fdfdfd'></i><span>عرض نتائج</span>
                    </a>
                </li>
                <li>
                    <a style="font-size: medium; text-decoration: none;" href="student_material.php"><i
                            class='bx bxs-download bx-flashing' style='color:white;'></i><span>تنزيل مقرر</span></a>
                </li>
                <li>
                    <a style="font-size: medium; text-decoration: none;" href="studentpage.php"><i
                            class='bx bx-desktop bx-flashing' style='color:#f9f4f4'></i><span>عرض مواد هذا
                            الفصل</span></a>
                </li>
                <li>
                    <a style="font-size: medium; text-decoration: none;" href="completed_courses.php"><i
                            class='bx bx-checkbox-checked bx-flashing' style='color:#f9f4f4'></i><span>عرض المواد
                            المنجزة</span></a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class='bx bx-log-out bx-flashing' style='color:#f9f4f4'></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="main-container">
            <?php
if(isset($_POST['menu_std_course_add'])){
	$course_id=$_POST['course_id'];
	$sql = " select * from requirements where course_id ='$course_id'";
        $result =  $conn->query($sql);
        $rows=$result->num_rows;
		$count=0;
		$requir[$rows]=0;
			for( $i=0 ; $i < $rows ; ++$i ){
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$requir[$i]=$row['Requirement_id'];
				$count++;
			}
			$flag=0;
	if($requir!=''){
		$sql = " select * from student_has_courses where student_id='$student_id'";
        $result =  $conn->query($sql);
        $rows=$result->num_rows;
		for( $i=0 ; $i < $rows ; ++$i ){
			$row = $result->fetch_array(MYSQLI_ASSOC);
				for($j=0 ; $j < $count ; ++$j){
					if($row['course_id'] ==$requir[$j]){
						if($row['result']>=50){
							$flag++;
						}
					else{
						continue;
					}
				}
			}
			if($flag==$count){
				break;
			}
		}
			}
		
		if($flag==$count){
			$sum=0;
			$sql = " select * from student_has_courses where result=-1 and student_id='$student_id'";
        	$result =  $conn->query($sql);
        	$rows=$result->num_rows;
			for( $i=0 ; $i < $rows ; ++$i ){
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$course=$row['course_id'];
			$sql = " select * from courses where course_id='$course'";
			$cours =  $conn->query($sql);
        	$rows_cours=$cours->num_rows;
			$rows_cours = $cours->fetch_array(MYSQLI_ASSOC);
			$sum+=$rows_cours['number_units'];
		}		
			if($sum<=21)
			{
				$sql = " select * from courses where course_id='$course_id'";
				$cours =  $conn->query($sql);
        		$rows_cours=$cours->num_rows;
				$rows_cours = $cours->fetch_array(MYSQLI_ASSOC);
				if($sum==18 and $rows_cours['number_units']==4){
					goto x;
				}
				if($sum==19 and $rows_cours['number_units']==4 or $sum==19 and $rows_cours['number_units']==3)
				{
					goto x;
				}
				if($sum==20 and $rows_cours['number_units']==4 or $sum==20 and $rows_cours['number_units']==3 or $sum==20 and $rows_cours['number_units']==2){
					goto x;
				}
				if($sum==21 and $rows_cours['number_units']==4 or $sum==21 and $rows_cours['number_units']==3 or $sum==21 and $rows_cours['number_units']==2
				or $sum==21 and $rows_cours['number_units']==1){
					goto x;
				}
				$num=1;
				$sql = " select * from student_has_courses where course_id='$course_id'";
				$num_course =  $conn->query($sql);
        		$num=$num_course->num_rows;
				if($num<$rows_cours['class_of']){
                    $conn->begin_transaction();
                    try {
                        $insert ="INSERT INTO student_has_courses ( student_id,course_id )VALUE ('$student_id','$course_id') ";
                        $result = mysqli_query($conn, $insert);
                       $conn->commit();
                       header("location:student_material.php");
                    } catch (mysqli_sql_exception $exception) {
                        echo 'Transaction Failed!!';
                        $conn->rollback();
                        $conn=null;
                        echo'<br>';
                        echo $exception->getMessage();
                    }
                } 
				else{
					?>
            <div class="modal fade" id="class_of" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                <h3>تم اخد العدد الكافي للطلبة</h3>
                            </h5>
                            <button type="button" class="close" onclick="goBack()" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="contact-form " action="student_material.php" method="post" id=""
                                enctype="multipart/form-data">
                                <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;">
                                </div>
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
			else{
				x:
				?>
            <div class="modal fade" id="validate_material" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                <h3>لقد تم تجاوز عدد الوحدات المسموحه لهذا الفصل</h3>
                            </h5>
                            <button type="button" class="close" onclick="goBack()" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="contact-form " action="student_material.php" method="post" id=""
                                enctype="multipart/form-data">
                                <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;">
                                </div>
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

else {
	?>
            <div class="modal fade" id="validate_material" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                <h3>يجب اتمام المتطلبات المقرر اولا </h3>
                            </h5>
                            <button type="button" class="close" onclick="goBack()" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="contact-form " action="student_material.php" method="post" id=""
                                enctype="multipart/form-data">
                                <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;">
                                </div>
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
			if(isset($_GET['std_course_add'])){
        $course_id = $_GET['std_course_add'];
        $sql = mysqli_query($conn , " select * from courses where course_id='$course_id'");
        $user= mysqli_fetch_assoc($sql);
?>
            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                <h3>تأكيد التنزيل </h3>
                            </h5>
                            <button type="button" class="close" onclick="goBack()" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="contact-form " action="student_material.php" method="post" id=""
                                enctype="multipart/form-data">
                                <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;">
                                </div>
                                <input type="hidden" class="form-control" name="course_id"
                                    value="<?php echo ''.$user['course_id'].''?>">
                                <button type="button" onclick="goBack()" class="btn btn-danger"
                                    data-dismiss="modal">رجوع</button>

                                <button type="submit" name="menu_std_course_add" class="btn btn-success">إضافة</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <?php
   }
   ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">رمز المقرر</th>
                        <th scope="col">اسم المقرر</th>
                        <th scope="col">عدد الوحدات</th>
                        <th scope="col">إضافة مقرر</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
	
		$select ="SELECT * FROM student_has_courses WHERE student_id='$student_id'";
		$result = mysqli_query($conn, $select);
		   $rows=$result->num_rows;
		if($rows>0){
			for($i=0;$i<$rows;$i++){
			  $row = mysqli_fetch_array($result);
			  $courses[$i]=$row['course_id'];
			  $grad[$i]=$row['result'];
			}
		}
		else{
			goto wait;
		}
			$sql = mysqli_query($conn ,"select * from courses ");
			if($rows>0){
		$num = 1;
		while($user = mysqli_fetch_assoc($sql)){
			$flag=0;
			for($i=0;$i<$rows;$i++){	
			if($courses[$i]==$user['course_id']){
				$flag=1;
				if($grad[$i]>-1 and $grad[$i]<50){
					$flag=0;
				}
				
			}
		}
		if($flag){
			continue;
		}
			else{
			echo '
					<tr>
					  <th scope="row">'.$num++.'</th>
					  <td>'.$user['course_id'].'</td>
					  <td>'.$user['course_name'].'</td>
					  <td>'.$user['number_units'].'</td>
            <td><a href="?std_course_add='.$user['course_id'].'" class="btn btn-warning">إضافة</a></td>
					</tr>
			';
		}	
	}
}
else{
	wait:
	$num = 1;
	$sql = mysqli_query($conn ,"select * from courses ");
	while($user = mysqli_fetch_assoc($sql)){	
		echo '
				<tr>
				  <th scope="row">'.$num++.'</th>
				  <td>'.$user['course_id'].'</td>
				  <td>'.$user['course_name'].'</td>
				  <td>'.$user['number_units'].'</td>
		<td><a href="?std_course_add='.$user['course_id'].'" class="btn btn-warning">Add</a></td>
				</tr>
		';	
}
}
	?>

                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
    $(window).on('load', function() {
        $('#add').modal('show');
    });
    </script>
    <script type="text/javascript">
    $(window).on('load', function() {
        $('#class_of').modal('show');
    });
    </script>
    <script>
    $('#course_show').modal({
        backdrop: 'static',
        keyboard: false
    })
    </script>
    <script>
    $('#class_of').modal({
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
    </div>

</body>

</html>