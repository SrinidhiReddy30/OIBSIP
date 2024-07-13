<?php
session_start();
$username=$_SESSION['username'];
require 'connect.php';
$sql="delete from todolist where username='$username'";
$res=$conn->query($sql);
$q="delete from events where username='$username'";
$result=$conn->query($q);
if($res && $result)
{
    echo "Deleted";
}
session_unset();
session_destroy();

header("location:welcome.php");
exit;
?>
