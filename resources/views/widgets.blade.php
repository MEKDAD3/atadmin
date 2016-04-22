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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Widgets</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
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
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <span id="namee"><?php echo $_SESSION['nom']; ?></span> <span class="caret"></span></a>
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
			<li><a href="clients.php"><span class="glyphicon glyphicon-list-alt"></span> Clients</a></li>
			<li class="active"><a href="widgets.php"><span class="glyphicon glyphicon-th"></span> Widgets</a></li>
			<li><a href="charts.php"><span class="glyphicon glyphicon-stats"></span> Graphique</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">		
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active">Widgets</li>
			</ol>
		</div><!--/.row-->
		
								
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-ok glyphicon-l"></em>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
						<?php
						include '../log/app/bin/server.php';
						header('Content-Type:text/html; charset=UTF-8');
						$stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) as count_c ,(SELECT COUNT(*) FROM `course` WHERE `etat` = 3) as count_a FROM `course` WHERE `etat` = 2"); 
						$stmt->execute(); 
						$row = $stmt->fetch();
						?>
							<div class="large"><?php echo($row["count_c"]); ?></div>
							<div class="text-muted">Course Confirmé</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-remove glyphicon-l"></em>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo($row["count_a"]); ?></div>
							<div class="text-muted">Courses Annulé</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-comment glyphicon-l"></em>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<?php 
							$stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*)+(SELECT COUNT(*)FROM `reclamation_client`) as count_r,(SELECT COUNT(*) FROM chauffeur) as count_ch FROM `reclamation_chauffeur`"); 
							$stmt->execute(); 
							$row = $stmt->fetch();?>
							<div class="large"><?php echo($row["count_r"]); ?></div>
							<div class="text-muted">Réclamations</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-user glyphicon-l"></em>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo($row["count_ch"]); ?></div>
							<div class="text-muted">Chauffeurs</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="glyphicon glyphicon-envelope"></span> Réclamations</div>
					<div class="panel-body reclamation-panel">
						<form class="form-horizontal" action="" method="post">
							<table class="table table-striped table-bordered table-hover table-condensed">
								<thead>
								  <tr>
									<th>Nom et prénom</th>
									<th>Date</th>
									<th class="message_t">Message</th>
									<th>Message</th>
									<th>Type</th>
									<th></th>
								  </tr>
								</thead>
								<tbody>
								<?php 
									$sql = "SELECT CONCAT(ch.nom,\" \",ch.prenom) as name ,`date`,`message`,`type` FROM `reclamation_chauffeur` rf ,`chauffeur` ch  WHERE `chauffeur` = ch.id UNION ALL SELECT CONCAT(cl.nom,\" \",cl.prenom) as name ,`date`,`message`,`type` FROM `reclamation_client` rc ,`client` cl  WHERE `chauffeur` = cl.id order by `date` desc";
									$result = $GLOBALS['conn']->prepare($sql);
									$result->execute();
									$rows = $result->fetchAll(PDO::FETCH_ASSOC);
									$i = 1;
									if ($result->rowCount() > 0) {
										foreach ($rows as $row) {?>
											<tr>
												<td><?php echo ($row["name"]); ?></td>
												<td><?php echo ($row["date"]); ?></td>
												<td class="message_t <?php echo("r_".$i."_") ?>"><?php echo ($row["message"]); ?></td>
												<td><?php echo (substr($row["message"],0,10)."..."); ?></td>
												<td><?php echo (htmlentities($row["type"],ENT_NOQUOTES, 'ISO-8859-15')); ?></td>
												<td class="msg btn btn-link <?php echo("r_".$i) ?>">Détail</td>
											</tr>	
										<?php $i++;}
									}
									 $result->closeCursor();?>
								</tbody>
							 </table>
						</form>
					</div>
				</div>
				
				<div class="panel panel-default chat">
					<div class="panel-heading" id="accordion">
					<span class="glyphicon glyphicon-comment"></span> Détail
						<p> </p>
					</div>
				
					<div class="panel-body">
						<!--<ul>
							<li class="left clearfix">
								<span class="chat-img pull-left">
									<img src="http://placehold.it/80/30a5ff/fff" alt="User Avatar" class="img-circle" />
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="primary-font">John Doe</strong> <small class="text-muted">32 mins ago</small>
									</div>
									<p>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ante turpis, rutrum ut ullamcorper sed, dapibus ac nunc. Vivamus luctus convallis mauris, eu gravida tortor aliquam ultricies. 
									</p>
								</div>
							</li>
							<li class="right clearfix">
								<span class="chat-img pull-right">
									<img src="http://placehold.it/80/dde0e6/5f6468" alt="User Avatar" class="img-circle" />
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="pull-left primary-font">Jane Doe</strong> <small class="text-muted">6 mins ago</small>
									</div>
									<p>
										Mauris dignissim porta enim, sed commodo sem blandit non. Ut scelerisque sapien eu mauris faucibus ultrices. Nulla ac odio nisl. Proin est metus, interdum scelerisque quam eu, eleifend pretium nunc. Suspendisse finibus auctor lectus, eu interdum sapien.
									</p>
								</div>
							</li>
							<li class="left clearfix">
								<span class="chat-img pull-left">
									<img src="http://placehold.it/80/30a5ff/fff" alt="User Avatar" class="img-circle" />
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="primary-font">John Doe</strong> <small class="text-muted">32 mins ago</small>
									</div>
									<p>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ante turpis, rutrum ut ullamcorper sed, dapibus ac nunc. Vivamus luctus convallis mauris, eu gravida tortor aliquam ultricies. 
									</p>
								</div>
							</li>
						</ul>-->
					</div>
					
					<!--<div class="panel-footer">
						<div class="input-group">
							<input id="btn-input" type="text" class="form-control input-md" placeholder="Type your message here..." />
							<span class="input-group-btn">
								<button class="btn btn-success btn-md" id="btn-chat">Send</button>
							</span>
						</div>
					</div>-->
				</div>
				
			</div><!--/.col-->
			
			<div class="col-md-4">
			
				<div class="panel panel-red">
					<div class="panel-heading dark-overlay"><span class="glyphicon glyphicon-calendar"></span>Calendrier</div>
					<div class="panel-body">
						<div id="calendar"></div>
					</div>
				</div>
				
				<div class="panel panel-blue">
					<div class="panel-heading dark-overlay"><span class="glyphicon glyphicon-check"></span>Tache a faire Liste</div>
					<div class="panel-body">
						<ul class="todo-list">
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox" />
									<label for="checkbox">Appeler Flan</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<div class="input-group">
							<input id="btn-input" type="text" class="form-control input-md" placeholder="Ajouter une tache" />
							<span class="input-group-btn">
								<button class="btn btn-primary btn-md" id="btn-todo">Ajouter</button>
							</span>
						</div>
					</div>
				</div>
								
			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->
		  

	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		$('#calendar').datepicker({
		});

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
	
	$(".msg").click(function() {
		var array_ = $(this).attr('class').split(" ");
		$("#accordion p").html($("."+array_[3]+"_").text());
	});
	</script>	
</body>

</html>
