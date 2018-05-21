<?php 
session_start();

function checkAuthorizate(){
	if (empty($_SESSION['user'])){
		return true;
	}else{
		redirect('list');

	}
}


function redirect ($page){
	header("Location:$page.php");
	die();
}

function getUsers(){

	$file = file_get_contents('users.json');
	$data = json_decode($file, true);
	if(!$data){
		return [];
	}
	return $data;
}


function delTest($testname)
{
   unlink('tests/'.$testname);
   redirect('list');
}







 ?>