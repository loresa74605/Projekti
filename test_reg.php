<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['username'] = 'agent_test';
$_POST['email'] = 'agent@test.com';
$_POST['password'] = 'agent123';
$_POST['confirmpassword'] = 'agent123';
$_POST['name'] = 'Agent';
$_POST['surname'] = 'Test';
include 'RegisterForm.php';
?>
