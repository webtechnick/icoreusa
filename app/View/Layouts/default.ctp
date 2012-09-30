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
		echo $this->Html->css('style');
		//echo $this->Google->load('jquery');
		//echo $this->Google->load('jqueryui');
		//echo $this->Html->css('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<a href="/"><img src="/img/icoreusa.png" alt="iCoreUSA"/></a>
			<div id="top-search">
				<?php echo $this->element('filter', array('model' => 'Contractor', 'url' => array('admin' => false, 'controller' => 'contractors', 'action' => 'index'))) ?>
			</div>
			<div id="top-nav">
				<?php echo $this->Html->link('Contractors', array('admin' => false, 'controller' => 'contractors', 'action' => 'index'), array('class' => 'button grey')); ?>
				<?php if(empty($user)): ?>
					<?php echo $this->Html->link('Login', array('admin' => false, 'controller' => 'users', 'action' => 'login'), array('class' => 'button grey')); ?>
					<?php echo $this->Html->link('Register', array('admin' => false, 'controller' => 'users', 'action' => 'register'), array('class' => 'button red')); ?>
				<?php else: ?>
					<?php echo $this->Html->link('Account', array('admin' => false, 'controller' => 'users', 'action' => 'account'), array('class' => 'button red')); ?>
					<?php echo $this->Html->link('Logout', array('admin' => false, 'controller' => 'users', 'action' => 'logout'), array('class' => 'button grey')); ?>
					<?php if($isadmin): ?>
						<?php echo $this->Html->link('Admin', array('admin' => true, 'controller' => 'users', 'action' => 'index'), array('class' => 'button grey')); ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		<div id="content">
			<div id="flash-message">
				<?php echo $this->Session->flash(); ?>
			</div>
			<?php if(strpos($this->request->here,'admin')): ?>
				<?php echo $this->element('admin_nav'); ?>
			<?php endif; ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Js->writeBuffer(); ?>
		</div>
	</div>
</body>
</html>
