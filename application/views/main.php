<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?PHP echo $title; ?></title>

	<!-- Bootstrap Core CSS -->
	<link href="<?PHP echo base_url(); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- MetisMenu CSS -->
	<link href="<?PHP echo base_url(); ?>/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

	<!-- Timeline CSS -->
	<link href="<?PHP echo base_url(); ?>/dist/css/timeline.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="<?PHP echo base_url(); ?>/dist/css/sb-admin-2.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="<?PHP echo base_url(); ?>/bower_components/morrisjs/morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="<?PHP echo base_url(); ?>/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<style type="text/css">
		p.footer {
			text-align: right;
			font-size: 11px;
			border-top: 1px solid #D0D0D0;
			line-height: 32px;
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}
	</style>

</head>

<body>

<div id="wrapper">
	<?PHP if ($Page != 'login' && $Page != 'reg'):?>
	<!-- Navigation -->
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.html">SB Admin v2.0</a>
		</div>
		<!-- /.navbar-header -->
		<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
					</li>
					<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
					</li>
					<li class="divider"></li>
					<li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
					</li>
				</ul>
				<!-- /.dropdown-user -->
			</li>
			<!-- /.dropdown -->
		</ul>
		<!-- /.navbar-top-links -->

		<?PHP echo $this->menu->show(); ?>
		<!-- /.navbar-static-side -->
	</nav>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><?PHP echo $title; ?></h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?PHP echo $this->msg->show(); ?>
			</div>
		</div>
		<?PHP $this->load->view($Page); ?>
	</div>
	<?PHP else: ?>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?PHP echo $title; ?></h3>
					</div>
					<?PHP $this->load->view($Page); ?>
				</div>
			</div>
		</div>
	</div>
	<?PHP endif; ?>
<!-- /#wrapper -->
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <strong>{memory_usage}</strong> mem. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
<!-- jQuery -->
<script src="<?PHP echo base_url(); ?>/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?PHP echo base_url(); ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?PHP echo base_url(); ?>/bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="<?PHP echo base_url(); ?>/bower_components/raphael/raphael-min.js"></script>
<script src="<?PHP echo base_url(); ?>/bower_components/morrisjs/morris.min.js"></script>
<script src="<?PHP echo base_url(); ?>/js/morris-data.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?PHP echo base_url(); ?>/dist/js/sb-admin-2.js"></script>

</body>

</html>
