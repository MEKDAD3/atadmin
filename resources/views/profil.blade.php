<?php 
session_start();
if(!isset($_SESSION['nom'])) {
	session_unset();
	session_destroy(); 
	header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Profile</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
<script src="js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js" charset="utf-8"></script>
</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>AjiTaxi</span>[Admin]</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['nom']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><span class="glyphicon glyphicon-user"></span> Profil</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-cog"></span> Paramètres</a></li>
							<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<!--<div class="form-group">
				<input type="text" class="form-control" placeholder="Chercher">
			</div>-->
			<a href="index.php"><img src="css/logo.png" id="logo_"></a>
		</form>
		<ul class="nav menu">
			<li><a href="index.php"><span class="glyphicon glyphicon-dashboard"></span> Carte</a></li>
			<li><a href="chauffeurs.php"><span class="glyphicon glyphicon-list-alt"></span> Chauffeurs</a></li>
			<li><a href="clients.php"><span class="glyphicon glyphicon-list-alt"></span> Clients</a></li>
			<li><a href="widgets.php"><span class="glyphicon glyphicon-th"></span> Widgets</a></li>
			<li class="active"><a href="charts.php"><span class="glyphicon glyphicon-stats"></span> Graphique</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active">Profil</li>
			</ol>
		</div><!--/.row-->
		 <div class="row">
        <form role="form" method="POST">
            <div class="col-lg-6">
				<?php 
					include '../log/app/bin/server.php';
					header('Content-Type:text/html; charset=UTF-8');
					$username = $_COOKIE["user_name"];
					$password = $_COOKIE["password"];
					$sql = "SELECT * FROM `users` WHERE `user_name` = '$username' and `password` = '$password'";
						$stmt = $GLOBALS['conn']->prepare($sql);
						$stmt->execute();
						$row = $stmt->fetch();
				?>
                <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Champ obligatoire</strong></div>
                <div class="form-group">
                    <label for="InputName">Nom : </label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="txt_nom" id="txt_nom" value="<?php echo($row["nom"]);?>" placeholder="Nom" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputEmail">Prénom : </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt_prenom" name="txt_prenom" value="<?php echo($row["prenom"]);?>" placeholder="Prénom" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputEmail">Nom d'utilisateur : </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="txt_user_name" name="txt_user_name" value="<?php echo($row["user_name"]);?>" placeholder="Nom d'utilisateur" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputMessage">Mot de passe : </label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="txt_pass" value="<?php echo($row["password"]);?>" id="txt_pass" placeholder="Mot de passe" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <input type="submit" name="done" id="done" value="Valider" class="btn btn-info pull-right">
            </div>
        </form>
    </div>
	<div class="container">

<!-- Registration form - START -->
   
<!-- Registration form - END -->

</div>	
		
		<!--<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Pie Chart</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="chart" id="pie-chart" ></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Doughnut Chart</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="chart" id="doughnut-chart" ></canvas>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		
		<!--<div class="row">
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>Label:</h4>
						<div class="easypiechart" id="easypiechart-blue" data-percent="92" ><span class="percent">92%</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>Label:</h4>
						<div class="easypiechart" id="easypiechart-orange" data-percent="65" ><span class="percent">65%</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>Label:</h4>
						<div class="easypiechart" id="easypiechart-teal" data-percent="56" ><span class="percent">56%</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>Label:</h4>
						<div class="easypiechart" id="easypiechart-red" data-percent="27" ><span class="percent">27%</span>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
											
	</div>	<!--/.main-->
	  

	<script src="js/bootstrap.min.js"></script>
	<script src="js/profil-script.js"></script>

	<script>
		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
