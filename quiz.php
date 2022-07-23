<?php

// الاتصال بي داتا بيز
require_once 'dbconn.php';
$conn = new mysqli($hn, $un, $pw, $db);
 if ($conn->connect_error) {
     echo "<p>Error: Could not connect to database.<br/>
     Please try again later.</p>";
       die($conn -> error);
   }
   //مفتاح المادة 
    $course_id = $_POST['id_delete'];
/* لي تعريف try,catch يجب تعريفها عن طريق */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


/* البداية transaction */
$conn->begin_transaction();
try {
        // حدف المتطلب 
        $query ="DELETE FROM requirements where course_id='$course_id'";
        $delete = $conn->query($query);
       
        // حدف المقرر
        $query ="DELETE FROM courses where course_id='$course_id'";
        $delete = $conn->query($query);
   // في حالت كانت البيانات تم حدفها بشكل صحيح فيتم عمل لها كوميت  
   $conn->commit();
   echo 'The amount has been transferred successfully';
}

    /* في حالت وجود خطأ في الكويري سينتقل الى كاتش ويرجع البيانات كما كانت
     عن طريق rollback */
catch (mysqli_sql_exception $exception) {
    echo 'Transaction Failed!!';
    // يتم ارجاع البيانات كما كانت في داتا بيز
    $conn->rollback();
    $conn=null;
    echo'<br>';
    // عرض الخطأ
    echo $exception->getMessage();
}
?>
