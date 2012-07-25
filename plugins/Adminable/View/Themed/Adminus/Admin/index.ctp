<div class="expand-10">
	
	<h2 class="title-grid"><?php echo $this->fetch('title'); ?></h2>
	
	<div class="content-grid">
		
		<p><?php echo $this->Html->link('<i class="icon-plus icon-white"></i> Adicionar', $this->fetch('add_link'), array('escape' => false, 'class' => 'btn btn-success', 'title' => 'Adicionar')); ?></p>
		
		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</div>