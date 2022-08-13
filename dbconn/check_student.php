<?php 
require_once '../dbconn/dbconn.php';
$sql = mysqli_query($conn ,"select * from student");
		$flag = false;
		while($user = mysqli_fetch_assoc($sql)){
        if($_SESSION['user_id']==$user['student_id']){
            $flag=true;
        }
        }          
?>