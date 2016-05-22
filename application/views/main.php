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

	<title>{title}</title>
	
	<?PHP $this->loadlib->show_css(); ?>

	<!-- Timeline CSS -->
	<link href="<?PHP echo base_url(); ?>/dist/css/timeline.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="<?PHP echo base_url(); ?>/bower_components/morrisjs/morris.css" rel="stylesheet">

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
				<h1 class="page-header">{title}</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?PHP echo $this->msg->show(); ?>
			</div>
		</div>
		{Page}
	</div>
<!-- /#wrapper -->
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <strong>{memory_usage}</strong> mem. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>

<?PHP $this->loadlib->show_js(); ?>

<!-- Morris Charts JavaScript -->
<script src="<?PHP echo base_url(); ?>/bower_components/raphael/raphael-min.js"></script>
<script src="<?PHP echo base_url(); ?>/bower_components/morrisjs/morris.min.js"></script>
<script src="<?PHP echo base_url(); ?>/js/morris-data.js"></script>

</body>

</html>
