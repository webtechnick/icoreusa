<?php echo $this->Html->script('jshowoff/jquery.jshowoff.min.js'); ?>
<?php echo $this->Html->css('/js/jshowoff/jshowoff.css'); ?>
<div class="contractors view">
<h2><?php echo h($contractor['Contractor']['first_name']); ?> <?php echo h($contractor['Contractor']['last_name']); ?></h2>
	<div class="contractor">
		<div class="image" style="float: left">
			<?php if(!empty($contractor['Image']['id'])): ?>
				<?php echo $this->Html->link($this->FileUpload->image($contractor['Image']['name'], 300), "/files/{$contractor['Image']['name']}", array('escape' => false, 'target' => '_blank')); ?><br />
			<?php endif; ?>
		</div>
		<div class="info">
			<br />
			<?php echo h($contractor['Contractor']['first_name']); ?> <?php echo h($contractor['Contractor']['last_name']); ?><br />
			<?php echo h($contractor['Contractor']['phone_number']); ?><br />
			<?php echo h($contractor['Contractor']['email']); ?><br /><br /><br />
			<h3>Bio</h3>
			<?php echo h($contractor['Contractor']['description']); ?>
			<br /><br />
			<h3>Images</h3>
			<div id="images">
				<?php for($i = 1; $i <= count($contractor['Upload']); $i++): ?>
					<div title="<?php echo $i; ?>"><?php echo $this->FileUpload->image($contractor['Upload'][$i - 1]['name'], 500) ?></div>
				<?php endfor; ?>
			</ul>
		</div>
	</div>
</div>
<?php echo $this->Js->buffer('
	jQuery("#images").jshowoff({
	 controlText: {next: "Next", previous:"Previous"},
	 speed: 5000
	});
'); ?>
