<?php
	$legendas = array(
		'adicionar' => 'Adicionar',
		'visualizar' => 'Visualizar',
		'anexo' => 'Anexo',
		'arquivo' => 'PDF',
		'imagem' => 'Imagem',
		'editar' => 'Editar',
		'delete' => 'Excluir'
	);
?>

<div class='meerkat'>
<table border="0" class="legenda" >
	<thead>
		<tr>
			<th>
				<strong>legenda</strong>
			</th>
		</tr>
	</thead>
<?php 		$strip = 0;
			foreach ($legendas as $imagem => $texto) { ?>
	<tr class="strip-<?php echo $strip % 2 ?>">
		<td class="legenda-icone <?php echo $imagem ?>"><?php echo $texto ?></td>
	</tr>
<?php 			$strip++;
			} ?>
</table>
</div>