<!DOCTYPE html>
<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<meta charset="UTF-8">
<link href="css/style-login.css" rel="stylesheet">
<title>AjiTaxi Adminstration Authentification</title>

</head>

<body>

<div class="logo"></div>
<div class="login-block">
    <h1>CONNEXION</h1>
	<form action="checkAndRedirect.php" method="POST">
		<input type="text" value="" placeholder="Nom d'utilisateur" id="username"  name="username"/>
		<input type="password" value="" placeholder="Mot de pass" id="password" name="password"/>
		<button id ="log">CONNEXION</button>
	</form>
</div>
</body>

</html>