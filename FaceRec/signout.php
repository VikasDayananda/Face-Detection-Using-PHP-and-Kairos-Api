<?php
session_start();
$_SESSION['uname']=null;
session_destroy();
header("Location:index.php");
?>