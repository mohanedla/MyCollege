<?php 
session_start();
if(!isset($_SESSION['user_id']) or !isset($_SESSION['user_name']) or !isset($_SESSION['last_name'])){
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
	<title>صفحة الرئيسية</title>
	<link rel="stylesheet" href="style1.css">
	<link rel="stylesheet" href="search/css/main.css">
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
<script>
	function validate(){
	if(document.getElementById('search').value==''){
		return false;
	}
	return true;
	}
</script>
</head>
<body>
	<input type="checkbox" id="checkbox">
	<header class="header">
		<h2 class="u-name">My <b>College</b>
			<label for="checkbox">
				<i id="navbtn" class='bx bx-menu bx-flip-horizontal bx-flashing' style='color:#fdfdfd'  ></i>
				 
			</label>
		</h2>
	</header>
	<div class="body">
		<nav class="side-bar">
			<div class="user-p">
				<img src="image/profile.png">
				<p ><span style="color:white;"><?php echo $_SESSION['user_name']."  ".$_SESSION['last_name'] ?></span></p>
			</div>
			<ul>
				<li>
					<a href="main.php">
					<i class='bx bx-home bx-flashing' style='color:#f9f4f4' ></i><span> الرئيسي  </span>
						
					</a>
				</li>
				<li>
					<a href="profile.php">
							<i class='bx bx-user bx-flashing' style='color:#fdfdfd' ></i><span>السجل الشخصي </span>
					</a>
				</li>
				<li>
					<a href="show_result.php">
					<i class='bx bxs-spreadsheet bx-flashing' style='color:#fdfdfd' ></i><span>عرض نتائج</span>
					</a>
				</li>
				<li>
					<a style="font-size: medium; text-decoration: none;" href="student_material.php"><i class='bx bxs-download bx-flashing' style='color:white;' ></i><span>تنزيل مقرر</span></a>
				</li>
				<li>
							<a style="font-size: medium; text-decoration: none;" href="studentpage.php"><i class='bx bx-desktop bx-flashing' style='color:#f9f4f4' ></i><span>عرض مواد هذا الفصل</span></a>
				</li>
				<li>
					<a style="font-size: medium; text-decoration: none;" href="completed_courses.php"><i class='bx bx-checkbox-checked bx-flashing' style='color:#f9f4f4' ></i><span>عرض المواد المنجزة</span></a>
				</li>
				<li>
					<a href="logout.php">
					<i class='bx bx-log-out bx-flashing' style='color:#f9f4f4' ></i>
						<span>Logout</span>
					</a>
				</li>
			</ul>
		</nav>
	
		<div class="s009">
      <form style="padding-bottom: 200px;"action="main.php" method="post">
        <div style="text-align: center;">
          <h1 class="address">يمكنك الحصول على معلومات عن أي مادة </h1>
        </div>
        <div class="inner-form">
          <div class="basic-search">
            <div class="input-field">
              <input id="search" name="course_id" type="search" placeholder=" مثال رمز المادة : cs-100" />
              <div class="icon-wrap">
                <svg class="svg-inline--fa fa-search fa-w-16" fill="#ccc" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                </svg>
              </div>
            </div>
          </div>
          <div class="advance-search">
            <div class="row third">
              <div class="input-field">
                <div class="result-count"></div>
                <div class="group-btn">
                  <button id="submit" name="search" class="btn-search" onclick="return validate();">البحث</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="continer" style="float: right;">
		<div>
		<h3 id="notfound"></h3>
		</div>
        <div class="course">
          <label for=""><span id="course_id">....</span><i>:</i>رمز المادة</label>
        </div>
        <div class="course">
          <label for=""><span style="float:left" id="course_name">....</span><i>:</i>اسم المادة</label>
        </div>
        <div class="course">
          <label for=""><span id="num_unit">....</span><i>:</i>عدد الوحدات</label>
        </div>
        <div class="course">
          <label for=""><span id="requir">....</span><i>:</i>المواد المطلوبة</label>
        </div>
        </div>
      </form>
    </div>

	</div>
	<script src="js/extention/choices.js"></script>
    <script>
      const customSelects = document.querySelectorAll("select");
      const deleteBtn = document.getElementById('delete')
      const choices = new Choices('select',
      {
        searchEnabled: false,
        itemSelectText: '',
        removeItemButton: true,
      });
      deleteBtn.addEventListener("click", function(e)
      {
        e.preventDefault()
        const deleteAll = document.querySelectorAll('.choices__button')
        for (let i = 0; i < deleteAll.length; i++)
        {
          deleteAll[i].click();
        }
      });

    </script>
</body>
</html>

<?php

if(isset($_POST['search'])){

$id_course=$_POST['course_id'];
$query = "SELECT * FROM courses WHERE course_id LIKE '%$id_course'";
$result=$conn->query($query);
$rows=$result->num_rows;
$sql= "SELECT * FROM requirements WHERE course_id='$id_course'";
$result_req=$conn->query($sql);
$rows_req=$result_req->num_rows;

if($rows==0){
	?>
	<script>
			document.getElementById('notfound').innerHTML= " الرجاء كتابة اسم المقرر بشكل صحيح";
			document.getElementById('notfound').style.color="red";
	</script>		
			<?php
}
elseif($rows>0){
	$row=$result->fetch_array(MYSQLI_ASSOC);
	?>
	<script>
		
	document.getElementById('course_id').innerHTML= "<?php echo ''.$row['course_id'].'' ?>" ;
	document.getElementById('course_name').innerHTML= "<?php echo ''.$row['course_name'].'' ?>";
	document.getElementById('num_unit').innerHTML= "<?php echo ''.$row['number_units'].'' ?>";
	<?php
		if($rows_req>0){
			?>
			document.getElementById('requir').innerHTML= " ";
		<?php
	for($i=0;$i<$rows_req;++$i){
		$row_req=$result_req->fetch_array(MYSQLI_ASSOC);
			?>
			document.getElementById('requir').insertAdjacentText("afterbegin", "<?php echo ''.$row_req['Requirement_id'].''?>  ");
			<?php
	}
}
else{
	?>
			document.getElementById('requir').innerHTML= "none ";
			<?php
}
}
		?>
  </script>
  <?php	
}
?>