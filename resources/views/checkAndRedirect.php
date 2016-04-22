<?php
include '../log/app/bin/server.php';

		$user_name = $_POST['username'];
		$password = $_POST['password'];
			$sql = "SELECT `nom`,`prenom`,`user_name`,`password` FROM `users` WHERE `user_name` ='$user_name' and `password` = '$password'";
			$result = $GLOBALS['conn']->prepare($sql);
			$result->execute();
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			if ($result->rowCount() > 0) {
				foreach ($rows as $row) {
					session_start();
					$_SESSION['nom'] = $row["nom"];
					//$_SESSION['user_name'] = $row["user_name"];
					//$_SESSION['password'] = $row["password"];
					setcookie("user_name", $row["user_name"], time() + (86400 * 30), "/"); // 86400 = 1 day
					setcookie("password", $row["password"], time() + (86400 * 30), "/"); // 86400 = 1 day
					header('Location: index.php');  	
				}
			}else	{
				header('Location: login.php');  
			} 
		$result->closeCursor();
	
?>