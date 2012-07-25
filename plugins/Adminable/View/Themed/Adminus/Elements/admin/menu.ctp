<ul class="nav">
	<li class="<?php echo ($this->request->params['controller'] == 'users') ? 'active' : ''; ?>">
		<?php echo $this->Html->link('Usuários', '/admin/users'); ?>
	</li>
	
	<li class="dropdown">
		<a data-toggle="dropdown" class="dropdown-toggle" href="#">Submenu <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li class="nav-header">Model</li>
			<li><?php echo $this->Html->link('Item 1', '/admin/controller/action') ?></li>
			<li><?php echo $this->Html->link('Item 2', '/admin/controller/action') ?></li>
		</ul>
	</li>
	
	<li class="divider-vertical"></li>
</ul>