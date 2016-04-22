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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Courses</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/grid-0.5.5.min.css" />
<link id="style" href="css/clean.css" rel="stylesheet" media="screen">
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
			<li class="active"><a href="courses.php"><span class="glyphicon glyphicon-stats"></span> Courses</a></li>
			<li><a href="clients.php"><span class="glyphicon glyphicon-list-alt"></span> Clients</a></li>
			<li><a href="widgets.php"><span class="glyphicon glyphicon-th"></span> Widgets</a></li>
			<li><a href="charts.php"><span class="glyphicon glyphicon-stats"></span> Graphique</a></li>
		</ul>
	</div><!--/.sidebar-->
		
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">      
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
        <li class="active">Courses</li>
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
				<div id="div_hours">
					<label>Jour :</label> 
					<select class="form-control" id="s_depart"></select> &agrave  
					<select class="form-control" id="s_fini"></select>
					<div class="alert alert-info" id="day_night_info">
					  Indiquer quand la tarif jour commenc&egrave et fini !!
					</div>
				</div>
				<form class="form-horizontal" action="" method="post">
					<label>Date : </label> <input class="form-control datepicker" id="datepck" data-provide="datepicker" data-date-format="dd/mm/yyyy">
					<button type="button" id="search_btn" class="btn btn-primary">Valider</button>
				</form>
		   	<br/><br/><br/>
			<div id="courses"></div>
            </div>
          </div>
        </div>
      </div>
    </div><!--/.row-->  
    
    
  </div><!--/.main-->

	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/bootstrap-table.js"></script>
	<script src="js/script_courses.js"></script>
	 <script type="text/javascript" src="js/jquery.cookie.js" charset="utf-8"></script>
	 <script src="plugins/gotopage.js"></script>
     <script src="plugins/ajaxpaging.js"></script>
     <script src="js/jquery.columns.min.js"></script>
	<script>
			$('.datepicker').datepicker({
				format: 'dd/mm/yyyy',
				setDate: new Date(),
				autoclose:"true"
		});
		$(".datepicker").datepicker("setDate", new Date());
		$(".datepicker").datepicker('update');
		
		

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
		var hours = ["00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23"];
		for	(index = 0; index < hours.length; index++) {
			$("#s_depart").append("<option>"+hours[index]+"</option>");
			$("#s_fini").append("<option>"+hours[index]+"</option>");
			// hours[index];
		}
	</script>	
</body>

</html>
