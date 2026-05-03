<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['username'] = 'agent_test_2';
$_POST['email'] = 'agent2@test.com';
$_POST['password'] = 'agent123';
$_POST['name'] = 'Agent2';
$_POST['surname'] = 'Test2';
include 'register.php';
?>
