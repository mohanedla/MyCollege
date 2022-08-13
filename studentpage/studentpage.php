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
    <title>عرض مواد هذا الفصل</title>
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
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">رمز المقرر</th>
                        <th scope="col">اسم المقرر</th>
                        <th scope="col">عدد الوحدات</th>
                        <th scope="col">النتيجة</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
	$num = 1;
    $select ="SELECT * FROM student JOIN student_has_courses ON student.student_id=student_has_courses.student_id
	JOIN courses ON courses.course_id=student_has_courses.course_id WHERE result=-1 and student.student_id='$student_id' ";
	$result =  $conn->query($select);
     $rows=$result->num_rows;
 if($rows>0){
	while($row = $result->fetch_array(MYSQLI_ASSOC)){	
		echo '
				<tr>
				  <th scope="row">'.$num++.'</th>
				  <td>'.$row['course_id'].'</td>
				  <td>'.$row['course_name'].'</td>
				  <td>'.$row['number_units'].'</td>
                  <td>0</td>
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
</body>

</html>