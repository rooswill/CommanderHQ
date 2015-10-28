<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $this->fetch('title'); ?>
		</title>
		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->css('Libs/styles');
			echo $this->fetch('meta');
		?>
		<link href="/css/Libs/jquery.mmenu.all.css" rel="stylesheet" type="text/css">
	    <script src="/js/Libs/jquery-1.10.1.min.js"></script>
     	<script src="/js/Libs/jquery.mmenu.min.all.js"></script>
	    <script src="/js/Libs/functions.js"></script>
	</head>
	<script type="text/javascript">
		$(window).load(function() {
			// Animate loader off screen
			$(".se-pre-con").fadeOut("slow");
		});
	</script>
	<body>
		<div class="se-pre-con"></div>
		<div id="container">
			<div id="header">
				<?php echo $this->element('header'); ?>
			</div>
			<div id="navigation">
				<?php echo $this->element('menu'); ?>
				<?php echo $this->element('navbar'); ?>
			</div>
			<div id="content">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
			<div id="footer">
				<?php echo $this->element('footer'); ?>
			</div>
		</div>
		<?php //echo $this->element('sql_dump'); ?>
		<script>
			$(document).ready(function() {
				$("#my-menu").mmenu();
				$("#activities").mmenu();
				$("#exerciseList").mmenu();
			});
		</script>
	</body>
</html>
