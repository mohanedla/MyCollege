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
    <title>بيانات الطالب</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <a style="text-decoration:none;" href="?change_pass=<?php $student_id ?>">
            <i class='bx bxs-user-account bx-burst' style='color:#f9f4f4'></i><span style="right;color:white;"> تغيير
                كلمة السر </span>
        </a>
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
			if(isset($_POST['menu_ar_change_pass'])){
				$password=$_POST['password'];
				$new_password=$_POST['new_password'];
				$confirm_password=$_POST['confirm_password'];
				if($new_password==$confirm_password){
				$sql = " select * from student where student_id = '$student_id' and student_password='$password' ";
				$result =  $conn->query($sql);
				$rows=$result->num_rows;
				if($rows == 1){
				$query ="update student set student_password='$new_password' where student_id='$student_id'";
    			$edit =  $conn->query($query);
				header('location:profile.php');
			}
			else {
				?>
            <div class="modal fade" id="validate_pass" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                <h3>كلمة السر غير صحيحة</h3>
                            </h5>
                            <button type="button" class="close" onclick="goBack()" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="contact-form " action="?change_pass=" method="post" id=""
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
            <div class="modal fade" id="validate_new_pass" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                <h3>كلمة السر الجديدة غير متطابقة</h3>
                            </h5>
                            <button type="button" class="close" onclick="goBack()" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="contact-form " action="?change_pass=" method="post" id=""
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
		if(isset($_GET['change_pass'])){
 
 $id = $_GET['change_pass'];
	   $sql = mysqli_query($conn , " select * from student where student_id = '$id' ");
	   $user= mysqli_fetch_assoc($sql);
?>
            <div class="modal fade" id="change_pass" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">تعديل إعدادت الدخول لحسابك </h5>
                            <button type="button" class="close" onclick="goBack()" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="contact-form " action="profile.php" method="post" id=""
                                enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">كلم السر الحالية</label>
                                    <div class="col-sm-9">
                                        <input type="password" required class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">كلمة السر الجديدة</label>
                                    <div class="col-sm-9">
                                        <input type="password" required class="form-control" name="new_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">تأكيد كلمة السر</label>
                                    <div class="col-sm-9">
                                        <input type="password" required class="form-control" name="confirm_password">
                                    </div>
                                </div>
                                <div id="product_ar_edit_result" class="text-center col-md-12" style="margin:10px 0;">
                                </div>
                                <button type="button" onclick="goBack()" class="btn btn-danger"
                                    data-dismiss="modal">رجوع</button>

                                <button type="submit" name="menu_ar_change_pass" class="btn btn-success">حفظ</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <?php
 }
 ?>
            <form action="profile.php" method="post">
                <div class="container">
                    <div class="card-body">

                        <form class="form-horizontal" action="profile.php" method="post"
                            style="background-color: azure;">

                            <span style="font-size:23px; color:#6c757d;">رقم القيد
                                :<?php echo $_SESSION['user_id'] ?></span>
                            <br><br><br>
                            <fieldset>
                                <?php  
        $sql = mysqli_query($conn , " select * from student where student_id = '$student_id' ");
        $user= mysqli_fetch_assoc($sql);
?>

                                <div class="form-group ">
                                    <label for="" class="control-label">الاسم الاول*</label>
                                    <input type="text" name="fName" class="col-xs-2 col-sm-2 col-md-2 text-right"
                                        disabled placeholder="الاسم الاول*" required=""
                                        value="<?php echo ''.$user['student_name'].''?>">
                                    <label for="" class="control-label">إسم الاب*</label>
                                    <input type="text" name="mName" class="col-xs-2 col-sm-2 col-md-2 text-right"
                                        disabled placeholder="إسم الاب*" required=""
                                        value="<?php echo ''.$user['mname'].''?>">
                                    <label for="" class="control-label"> اللقب* </label>
                                    <input type="text" name="lName" class="col-xs-2 col-sm-2 col-md-2 text-right"
                                        disabled placeholder=" اللقب*" required=""
                                        value="<?php echo ''.$user['lname'].''?>">
                                </div>
                                <fieldset>

                                    <fieldset>
                                        <div class="form-group">
                                            <label class="control-label" for="bday">تاريخ الميلاد</label>
                                            <?php if($user['birthday']=='' or $user['birthday']==null){?>
                                            <input class="col-xs-2 col-sm-2 col-md-2 " type="date"
                                                value="<?php echo date('Y-m-d',strtotime($user["birthday"])) ?>"
                                                name="bday" id="bday">
                                            <?php 
					} 
					else { 
						?>
                                            <input class="col-xs-2 col-sm-2 col-md-2 " type="date"
                                                value="<?php echo date('Y-m-d',strtotime($user["birthday"])) ?>"
                                                disabled name="bday" id="bday">
                                            <?php
					} 
					?>
                                            <label class="control-label" for="bplace">مكان الميلاد</label>
                                            <?php if($user['place_birth']==''or $user['place_birth']==null){?>
                                            <input class="col-xs-2 col-sm-2 col-md-2 " id="bplace" name="bplace"
                                                type="text" placeholder="مكان الميلاد" required=""
                                                value="<?php echo ''.$user['place_birth'].''?>">
                                            <?php }else{?>
                                            <input class="col-xs-2 col-sm-2 col-md-2 " id="bplace" name="bplace"
                                                type="text" disabled placeholder="مكان الميلاد" required=""
                                                value="<?php echo ''.$user['place_birth'].''?>">
                                            <?php
				}	?>
                                            <label class="control-label" for="gender">البلد</label>
                                            <?php if($user['country']==''or $user['country']==null){?>
                                            <input class="col-xs-2 col-sm-2 col-md-2 " name="cuntid" id="cuntid"
                                                type="text" placeholder="البلد" required=""
                                                value="<?php echo ''.$user['country'].''?>">
                                            <?php }
				else{ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2 " name="cuntid" id="cuntid"
                                                type="text" placeholder="البلد" required="" disabled
                                                value="<?php echo ''.$user['country'].''?>">
                                            <?php } ?>
                                        </div>
                                    </fieldset>
                                    <fieldset>

                                        <div class="form-group">
                                            <label class="control-label" for="gender">الجنس </label>
                                            <?php if($user['gender']==''or $user['gender']==null){ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" name="gender" id="gender"
                                                required="" placeholder="الجنس"
                                                value="<?php echo ''.$user['gender'].''?>">
                                            <?php }
	  else { ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" name="gender" id="gender"
                                                required="" disabled placeholder="الجنس"
                                                value="<?php echo ''.$user['gender'].''?>">
                                            <?php } ?>
                                            <label class="control-label" for="status">الحالة الاجتماعية</label>
                                            <?php if($user['marital_status']==''or $user['marital_status']==null){ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" name="status" id="status"
                                                required="" placeholder="الحالة الإجتماعية"
                                                value="<?php echo ''.$user['marital_status'].''?>">
                                            <?php }
		else{ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" name="status" id="status"
                                                required="" placeholder="الحالة الإجتماعية" disabled
                                                value="<?php echo ''.$user['marital_status'].''?>">
                                            <?php }	?>
                                            <label class="control-label" for="nationality">الجنسية</label>
                                            <?php if($user['Nationality']==''or $user['Nationality']==null){ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" name="natid" id="natid"
                                                required="" placeholder="الجنسية"
                                                value="<?php echo ''.$user['Nationality'].''?>">
                                            <?php }
		else{ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" name="natid" id="natid"
                                                required="" placeholder="الجنسية" disabled
                                                value="<?php echo ''.$user['Nationality'].''?>">
                                            <?php
		}	?>
                                        </div>
                                    </fieldset>

                                    <fieldset>

                                        <div class="form-group">
                                            <label class="control-label" for="age">الرقم الوطنى أو جواز السفر
                                                للمغتربين*</label>
                                            <?php if($user['identity']==''or $user['identity']==null){ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" id="nid" name="nid" type="text"
                                                placeholder="الرقم الوطنى أو جواز السفر للمغتربين*" maxlength="12"
                                                required="" value="<?php echo ''.$user['identity'].''?>">
                                            <?php
						 }
						 else {
							?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" id="nid" name="nid" type="text"
                                                placeholder="الرقم الوطنى أو جواز السفر للمغتربين*" disabled
                                                maxlength="12" required="" value="<?php echo ''.$user['identity'].''?>">
                                            <?php
						}
							?>
                                            <label class="control-label" for="contact">رقم الهاتف*</label>
                                            <?php if($user['phone']==''or $user['phone']==null){ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" id="contact" name="contact"
                                                type="tel" placeholder="رقم الهاتف*" maxlength="10" required=""
                                                pattern="09.+" value="<?php echo ''.$user['phone'].''?>">
                                            <?php
						  }
						  else{
							?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" id="contact" name="contact"
                                                type="tel" placeholder="رقم الهاتف*" disabled maxlength="10" required=""
                                                pattern="09.+" value="<?php echo ''.$user['phone'].''?>">
                                            <?php
						  }
						  ?>
                                            <label class="control-label" for="email">البريد الالكتروني*</label>
                                            <?php if($user['email']==''or $user['email']==null){ ?>

                                            <input class="col-xs-2 col-sm-2 col-md-2" id="email" name="email"
                                                type="email" placeholder="البريد الالكتروني*" required=""
                                                value="<?php echo ''.$user['email'].''?>" <?php
						  }
						  else {
							?> <input class="col-xs-2 col-sm-2 col-md-2" id="email" name="email" type="email"
                                                placeholder="البريد الالكتروني*" disabled required=""
                                                value="<?php echo ''.$user['email'].''?>" <?php

						  }
						  ?> </div>
                                    </fieldset>

                                    <fieldset>

                                        <div class="form-group">
                                            <label class="control-label" for="home">عنوان السكن</label>
                                            <?php if($user['address']==''or $user['address']==null){ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" id="addhome" name="addhome"
                                                type="text" placeholder="عنوان السكن"
                                                value="<?php echo ''.$user['address'].''?>">

                                            <?php
						 }
						else{
							?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" id="addhome" name="addhome"
                                                type="text" placeholder="عنوان السكن" disabled
                                                value="<?php echo ''.$user['address'].''?>">
                                            <?php
						 } 
						 ?>
                                            <label class="control-label" for="home">المدينة</label>
                                            <?php
						if($user['city']==''or $user['city']==null){ ?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" id="city" name="city" type="text"
                                                placeholder="المدينة" value="<?php echo ''.$user['city'].''?>">
                                            <?php
						}
						else {
							?>
                                            <input class="col-xs-2 col-sm-2 col-md-2" id="city" name="city" type="text"
                                                placeholder="المدينة" disabled value="<?php echo ''.$user['city'].''?>">
                                            <?php
						}
						?>
                                        </div>

                                    </fieldset>

                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php
						if($user['birthday']!='' or $user['birthday']!=null and $user['place_birth']!='' or $user['place_birth']!=null
						and $user['birthday']!='' or $user['birthday']!=null and $user['country']!='' or $user['country']!=null
						and $user['gender']!='' or $user['gender']!=null and $user['marital_status']!='' or $user['marital_status']!=null
						and $user['Nationality']!='' or $user['Nationality']!=null and $user['identity']!='' or $user['identity']!=null
						and $user['phone']!='' or $user['phone']!=null and $user['address']!='' or $user['address']!=null
						and $user['city']!='' or $user['city']!=null ){
							?>
                                                    <input type="submit" id="submit" class="btn btn-primary" disabled
                                                        value="حفظ" name="edit">
                                                    <?php
						}
						else{
							?>
                                                    <input type="submit" id="submit" class="btn btn-primary" value="حفظ"
                                                        name="edit">
                                                    <?php
						} ?>
                                                </td>

                                                <td>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </fieldset>
                        </form>
                    </div>
                </div>
        </div>

        <script>
        function goBack() {
            window.history.back();
        }
        </script>

        <script type="text/javascript">
        $(window).on('load', function() {
            $('#change_pass').modal('show');
        });
        </script>
        <script type="text/javascript">
        $(window).on('load', function() {
            $('#validate_pass').modal('show');
        });
        </script>
        <script type="text/javascript">
        $(window).on('load', function() {
            $('#validate_new_pass').modal('show');
        });
        </script>

        <script>
        $('#validate_pass').modal({
            backdrop: 'static',
            keyboard: false
        })
        </script>

        <script>
        $('#validate_new_pass').modal({
            backdrop: 'static',
            keyboard: false
        })
        </script>
        <script>
        $('#change_pass').modal({
            backdrop: 'static',
            keyboard: false
        })
        </script>
</body>

</html>
<?php
if(isset($_POST['edit'])){
	$birthday=$_POST['bday'];
	$place_birth=$_POST['bplace'];
	$country=$_POST['cuntid'];
	$gender=$_POST['gender'];
	$marital_status=$_POST['status'];
	$Nationality=$_POST['natid'];
	$identity=$_POST['nid'];
	$phone=$_POST['contact'];
	$address=$_POST['addhome'];
	$city=$_POST['city'];

	$query ="update student set birthday='$birthday',place_birth='$place_birth',country='$country',gender='$gender',
	marital_status='$marital_status',Nationality='$Nationality',identity='$identity',address='$address',phone='$phone',city='$city' where student_id='$student_id'";

   $result = $conn->query($query);
}
?>