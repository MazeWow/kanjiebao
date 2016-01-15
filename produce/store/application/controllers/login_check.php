<?php
require_once('conn.php');

@$username=$_POST['username'];
@$passwd=md5($_POST['passwd']);//'or '1'='1'#
$username= mysqli_real_escape_string($conn,$username);
$passwd= mysqli_real_escape_string($conn,$passwd);
$check="select * from admin where username='$username' and passwd='$passwd'";
$stmt=$conn->stmt_init(); 

$result=mysqli_query($conn,$check);
$numrows=mysqli_num_rows($result);

if($numrows!=0)

{
    @$_SESSION['valid_user']=$username;
   
      echo "<script>alert('登陆成功!')</script>";

 echo' <meta http-equiv="refresh" content="1;url=index.php">';
    
}
else {
   echo "<script>alert('用户名或密码错误，请重新登陆!')</script>";
   
    ?>
    <meta http-equiv="refresh" content="1;url=login.php">
    <?php 
}










?>