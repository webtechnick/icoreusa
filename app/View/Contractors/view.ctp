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
			<div class="clear"></div>
			<h2>Bio</h2>
			<?php echo h($contractor['Contractor']['description']); ?>
			<br /><br />
			<h2>Map</h2>
			<?php echo $this->element('Icing.map', array(
				'center' => array('lat' => $contractor['Contractor']['lat'], 'lon' => $contractor['Contractor']['lon']),
				'points' => array(
					array(
						'lat' => $contractor['Contractor']['lat'], 
						'lon' => $contractor['Contractor']['lon'],
						'info' => '<span style="color: #000;">Info Window</span>',
						'title' => 'Contractor'
					),
				),
				'width' => '100%',
				'height' => '500px'
			)); ?>
			<h2>Images</h2>
			<div id="images" class="center">
				<?php for($i = 1; $i <= count($contractor['Upload']); $i++): ?>
					<div title="<?php echo $i; ?>"><?php echo $this->FileUpload->image($contractor['Upload'][$i - 1]['name'], 500) ?></div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($contractor['Upload'])): ?>
	<?php echo $this->Js->buffer('
		jQuery("#images").jshowoff({
		 controlText: {next: "Next", previous:"Previous"},
		 speed: 5000,
		 autoPlay: false
		});
	'); ?>
<?php endif; ?>
