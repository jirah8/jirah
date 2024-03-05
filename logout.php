<?php 
session_start();

session_abort();
session_unset();

header("Location:index.php");

?>