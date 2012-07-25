<?php if ($this->Paginator->hasPrev() || $this->Paginator->hasNext()) : ?>
	<div class="pagination">
		<ul>
			<li><?php echo $this->Paginator->prev('Anterior', array(), null, array('class' => 'disabled', 'tag' => 'a')) ?></li>
			<?php echo $this->Paginator->numbers(array('separator' => false, 'tag' => 'li', 'currentClass' => 'active', 'first' => 'first', 'last' => 'last')); ?>
			<li><?php echo $this->Paginator->next('Próximo', array(), null, array('class' => 'disabled', 'tag' => 'a')); ?></li>
		</ul>
	</div>
<?php endif ?>

<p class="cleaning bold">
	<?php echo $this->Paginator->counter('Total: {:count}'); ?>
</p>

<?php echo $this->Html->scriptBlock("
	text = jQuery('.pagination .active').text();
	jQuery('.pagination .active').empty().append('<a>' + text + '</a>');
", array('inline' => false)) ?>