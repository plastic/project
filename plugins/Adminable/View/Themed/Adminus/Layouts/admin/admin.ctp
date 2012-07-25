<?php echo $this->Html->docType('html5'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Painel de Controle</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<?php echo $this->element('admin/header'); ?>
</head>

<body>

<?php if (SessionHelper::read('Auth.User.id')) : ?>	

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
			
				<a class="brand" href="#">Project</a>
				
				<?php echo $this->element('admin/menu') ?>
				<?php echo $this->Form->create(Inflector::camelize(Inflector::singularize($this->request->params['controller'])), array('type' => 'GET', 'url' => array('controller' => $this->request->params['controller'], 'action' => 'search'), 'class' => 'navbar-search pull-left')) ?>
					<?php echo $this->Form->input('search', array('type' => 'text', 'placeholder' => 'Busca', 'class' => 'search-query', 'div' => false, 'label' => false)) ?>
				<?php echo $this->Form->end() ?>
				
				<div class="btn-group pull-right">
					<a href="<?php echo $this->Html->url('/admin/users/edit/' . SessionHelper::read('Auth.User.id')); ?>" class="btn btn-primary"><i class="icon-user icon-white"></i> <?php echo SessionHelper::read('Auth.User.name'); ?></a><a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $this->Html->url('/admin/users/edit/' . SessionHelper::read('Auth.User.id')) ?>"><i class="icon-pencil"></i> Editar</a></li>
						<li class="divider"></li>
						<li><?php echo $this->Html->link('<i class="icon-off"></i> Sair', '/admin/users/logout', array('escape' => false)) ?></li>
					</ul>
				</div>
				
			</div>
		</div>
	</div>
		
<?php endif ?>
	
	<div class="container">
		<?php echo $this->element('admin/flash'); ?>
		<?php echo $this->fetch('content'); ?>
	</div>
	
<?php echo $this->element('admin/footer'); ?>
<?php echo $this->element('sql_dump'); ?>

<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('css'); ?>

<?php if ( isset($success) || isset($error) ) : ?>
	<script type="text/javascript">
		jQuery.jGrowl("<?php echo isset($success) ? $success : $error; ?>");
	</script>
<?php endif ?>
</body>
</html>