<!DOCTYPE html>
<html manifest="manifest.php" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Commander HQ</title>
		<meta charset="UTF-8">
		<meta name="Description" content="" />
		<meta name="Keywords" content="" />
		<meta http-equiv="cache-control" content="private" />
		<meta http-equiv="expires" content="Fri, 30 Dec 2011 12:00:00 GMT" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic|Fjalla+One' rel='stylesheet' type='text/css'>
		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->css(array('admin/style', 'admin/glDatePicker.flatwhite'));

			echo $this->fetch('meta');

			echo $this->Html->script(array('Libs/jquery-1.10.1.min', 'Libs/glDatePicker.min', 'Libs/functions'))
		?>
		<script type="text/javascript">
	        $(window).load(function()
	        {
	            $('#mydate').glDatePicker({
	            	cssName: 'flatwhite',
	            	 onClick: function(target, cell, date, data) {
				        target.val(date.getFullYear() + '-' +
				                    date.getMonth() + '-' +
				                    date.getDate());

				        if(data != null) {
				            alert(data.message + '\n' + date);
				        }
				    }
	            });
	        });
    	</script>
	</head>
	<body class="smallBG">
		<div id="wrapper">
			<div class="header">
				<?php echo $this->element('admin/header_small'); ?>
				<!-- Header info goes here -->
			</div>
			<div class="content">
				<?php
					if($this->view != 'login')
						echo $this->element('admin/navigation');
				?>
				<div class="spacer"></div>
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
			<div class="footer">
				<?php echo $this->element('admin/footer'); ?>
				<!-- Footer Content goes here -->
			</div>
		</div>
	</body>
</html>

