<!DOCTYPE html>
<?php 
session_start();
if(!isset($_SESSION['nom'])) {
	session_unset();
	session_destroy(); 
	header('Location: login.php');
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Clients</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/grid-0.5.5.min.css" />
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

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
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Utilisateur <span class="caret"></span></a>
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

		<ul class="nav menu">
			<li><a href="index.php"><span class="glyphicon glyphicon-dashboard"></span> Carte</a></li>
			<li><a href="chauffeurs.php"><span class="glyphicon glyphicon-list-alt"></span> Chauffeurs</a></li>
			<li><a href="courses.php"><span class="glyphicon glyphicon-stats"></span> Courses</a></li>
			<li class="active"><a href="clients.php"><span class="glyphicon glyphicon-list-alt"></span> Clients</a></li>
			<li><a href="widgets.php"><span class="glyphicon glyphicon-th"></span> Widgets</a></li>
			<li><a href="charts.php"><span class="glyphicon glyphicon-stats"></span> Graphique</a></li>
		</ul>
	</div><!--/.sidebar-->
		
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">      
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
        <li class="active">Clients</li>
      </ol>
    </div><!--/.row-->
    
    <!--<div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Liste des Clients</h1>
      </div>
    </div><!--/.row-->
        
    
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-body">
		    <input class="form-control" placeholder="Chercher client" type="text" id="btn_find">
            <button id="btnAdd">Ajouter un Client</button>
            <br><br>
            <table id="grid"></table>
            <div id="dialog" style="display:none">
              <input type="hidden" id="ID">
              <table border="0">
                <tbody>
                <tr style="display:none;">
                  <td><label for="id">ID :</label></td>
                  <td><input type="text" id="id"></td>
                </tr>
                <tr>
                  <td><label for="nom">Nom :</label></td>
                  <td><input type="text" id="nom"></td>
                </tr>
                <tr>
                  <td><label for="prenom">Prénom:</label></td>
                  <td><input type="text" id="prenom"></td>
                </tr>
                <tr>
                  <td><label for="num1">Numéro de Téléphone (1) :</label></td>
                  <td><input type="text" id="num1"></td>
                </tr>
                <tr>
                  <td><label for="num2">Numéro de Téléphone (2) :</label></td>
                  <td><input type="text" id="num2"></td>
                </tr>
                <tr>
                  <td><label for="password">Mot de passe :</label></td>
                  <td><input type="text" id="password"></td>
                </tr>
                <tr>
                  <td><label for="email">Email :</label></td>
                  <td><input type="email" id="email"></td>
                </tr>
                <tr>
                  <td><label for="password">Sexe :</label></td>
                  <td><input type="radio" name="sexe" id="m" value="M"> Masculain <input type="radio" name="sexe" id="f" value="F"> Féminin</td>
                </tr>
              </tbody></table>
            </div>
          </div>
        </div>
      </div>
    </div><!--/.row-->  
    
    
  </div><!--/.main-->

	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-table.js"></script>
	 <script type="text/javascript" src="js/jquery.cookie.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="js/grid-0.5.5.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/script-datatable-client.js" charset="utf-8"></script>
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
