<?php
session_start();

$_SESSION = array();

session_destroy();

// Assuming the logout is always successful
echo 'success';
?>