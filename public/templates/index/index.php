<?php 
@include (TEMPLATES_DIR . "templates/inc/head.php");  
?>

<div class="card">
	<?php if (SESSION::has('message')) { ?>
		<div class="card-panel green accent-2">
			<ul>
				<?php 
				if (is_array($_SESSION['message'])) {
					foreach (SESSION::get('message') as $value) { ?>
						<li class="h5"><?= $value ?></li>	
					<?php }
				}else{ ?>
					<li class="h5"><?= SESSION::get('message') ?></li>
				<?php } ?>	
			</ul>
		</div>
	<?php } ?>

	<div class="card-content center red-text">
		<h4>Listado De Alumno</h4>
	</div>
	<div class="divider"></div>
	<div class="card-content">
		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Cedula</th>
					<th>Nombre y Apellido</th>
					<th>Sexo</th>
					<th>Sede</th>
				</tr>
			</thead>
			<tbody>
				<?php $acu = 1 ?>
				<?php foreach ($accounts as $account) {?>
					<tr>
						<td><?= $acu ?></td>
						<td><?= strtoupper($account[0]->cedula) ?></td>
						<td><?= strtoupper($account[0]->name) ?>  <?= strtoupper($account[0]->last_name) ?></td>
						<td><?= strtoupper($account[0]->sex) ?></td>
						<td><?= strtoupper($account[1])?></td>
					</tr>
					<?php $acu = $acu+1; };  ?>
				</tbody>
			</table>
		</div>
		<div class="divider"></div>
		<div class="card-content">
			<div class="row center">
				<div class="col s12">
					<ul class="pagination">
						<li class="<?=  $_GET['page'] == 1 ? 'disabled' : 'waves-effect' ?>"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
						<?php for ($i=0; $i < $paginate; $i++) { $val= $i+1?>
							<li class="<?=  $_GET['page'] == $val ? 'active red' : 'waves-effect' ?>"><a href="<?= url("").'?page='. $val ?>"><?= $val ?></a></li>
						<?php } ?>
						
						<li class='<?=  $_GET['page'] == $paginate ? 'disabled' : 'waves-effect' ?>'><a href='#!'><i class='material-icons'>chevron_right</i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>


	<?php 
	@include (TEMPLATES_DIR . "templates/inc/footer.php");

	?>