<ul class="nav">
	<li class="<?php echo ($this->request->params['controller'] == 'users') ? 'active' : ''; ?>">
		<?php echo $this->Html->link('Usuários', '/admin/users'); ?>
	</li>
	
	<?php /* para usar como submenu*/ ?>
	<!-- <li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php #echo SessionHelper::read('Auth.User.name') ?> <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="#">Action</a></li>
				<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li class="divider"></li>
				<li class="nav-header">Nav header</li>
				<li><a href="#">Separated link</a></li>
				<li><a href="#">One more separated link</a></li>
			</ul>
		</li> -->
	
	<li class="divider-vertical"></li>
</ul>