<div class="expand-10">
	
	<h2 class="title-grid">Usuários</h2>
	
	<div class="content-grid">
		
		<p><?php echo $this->Html->link('<i class="icon-plus icon-white"></i> Adicionar', array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success', 'title' => 'Adicionar Usuário')); ?></p>
		
		<div id="content">
		
			<?php if (!empty($users)): ?>
			
				<table border="0" cellpadding="3" cellspacing="3" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Nome</th>
							<th>E-mail</th>
							<th>Ações</th>
						</tr>
					</thead>
					<?php $count = 0; ?>
					<?php foreach($users as $key => $user) : ?>
						<tr class="grid-item strip-<?php echo $count % 2; ?>">
							<td><?php echo $user['User']['name']; ?></td>
							<td><?php echo $user['User']['email']; ?></td>
							<td>
								<?php echo $this->Html->link('<i class="icon-pencil icon-white"></i>', array('action' => 'edit', $user['User']['id']), array('title' => 'Editar', 'escape' => false, 'class' => 'btn btn-small btn-warning')); ?>
								<?php echo $this->Html->link('<i class="icon-trash icon-white"></i>', array('action' => 'del', $user['User']['id']), array('escape' => false, 'class' => 'btn btn-danger btn-small', 'title' => 'Excluir'), 'Deseja realmente excluir este usuário?'); ?>
							</td>
						</tr>
						<?php $count++ ?>
					<?php endforeach; ?>
					
				</table>
			
				<p><?php echo $this->element('admin/pagination') ?></p>
			
			<?php else : ?>
				
				<?php echo $this->Admin->warning('Não existem usuários!') ?>
				
			<?php endif ?>
		
		</div>
		
	</div>
	
</div>