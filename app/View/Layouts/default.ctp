<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		iCoreUSA :: 
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('style');
		echo $this->Google->load('jquery');
		echo $this->Google->load('jqueryui');
		echo $this->Html->css('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><a href="/">iCoreUSA</a></h1>
			<div id="top-nav">
				<?php if(empty($user)): ?>
					<?php echo $this->Html->link('Login', array('admin' => false, 'controller' => 'users', 'action' => 'login')); ?>
					<?php echo $this->Html->link('Register', array('admin' => false, 'controller' => 'users', 'action' => 'register')); ?>
					<?php if($isadmin): ?>
						<?php echo $this->Html->link('Admin', array('admin' => true, 'controller' => 'users', 'action' => 'index')); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo $this->Html->link('Account', array('admin' => false, 'controller' => 'users', 'action' => 'account')); ?>
					<?php echo $this->Html->link('Logout', array('admin' => false, 'controller' => 'users', 'action' => 'logout')); ?>
				<?php endif; ?>
			</div>
		</div>
		<div id="content">
			<div id="flash-message">
				<?php echo $this->Session->flash(); ?>
			</div>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Js->writeBuffer(); ?>
		</div>
	</div>
</body>
</html>
