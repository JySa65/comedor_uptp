<?php 
@include (TEMPLATES_DIR . "templates/inc/head.php"); 
sessionLocal(); 
?>

<div class="card">
	<div class="card-content center red-text">
		<h4>Dias Olvidados</h4>
	</div>
	<div class="divider"></div>
	<div class="card-content">
		<div class="row">
			<div class="col s12">
				<form method="GET">
					<div class="input-field col s9">
						<input class="validate" id="id_get_cedula" name="get_cedula" type="search" autocomplete="off" required maxlength="8" minlength="7">
						<label for="id_cedula">Cedula Del Alumno</label>
					</div>
					<div class="col s3">
						<button class="btn-floating btn-large waves-effect waves-light blue" type="submit">
							<i class="material-icons right">search</i>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="divider"></div>
	<div class="card-content">
		<div class="row">
			<div class="col s12">
				<?php 
				if (isset($acc)) {
					if (!empty($acc)) { ?>
						<form method="POST" >
							<input type="hidden" value="<?= csrf_token() ?>" name="csrftoken" required>
							<table>
								<tbody>
									<tr>
										<th>Cedula</th>
										<th>Nombre y Apellido</th>
										<th>PNF</th>
									</tr>
									<tr>
										<td><?= strtoupper($acc[0]->nacionality) ?> - <?= strtoupper($acc[0]->cedula) ?></td>
										<td><?= strtoupper($acc[0]->name) ?> <?= strtoupper($acc[0]->last_name) ?></td>
										<td><?= strtoupper($acc[1]) ?></td>
									</tr>
									<tr>
										<th>Sexo</th>
										<th>Sede</th>
										<th>Tuvo Su Almuerzo</th>
									</tr>
									<tr>
										<td><?= strtoupper($acc[0]->sex) ?></td>
										<td><?= strtoupper($acc[2]) ?></td>
										<td>
											<div class="switch">
												<label>
													No
													<input type="checkbox" name="comida">
													<span class="lever"></span>
													Si
												</label>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="divider"></div>
							<div class="row">
								<div class="col s12">
									<br>
									<div class="input-field col s12">
										<input type="text" class="datepicker validate" name="date" required>
										<label for="id_cedula">Ingrese Fecha</label>
									</div>
								</div>
							</div>
							<div class="divider"></div>	
							<div class="card-action center">
								<button class="btn waves-effect waves-light blue" type="submit">Aceptar
									<i class="material-icons right">send</i>
								</button>
								<a class="btn waves-effect waves-light red" href="<?= url("") ?>">Regresar
									<i class="material-icons right">arrow_back</i>
								</a>
							</div>
						</form>
					<?php }else{ ?>
						<h3 class="center">No hay Alumno Registrado Con Esa Cedula <a href="<?= url('account/new') ?>">Presione aqui para registrar</a></h3>
					<?php }	
				}
				?>
			</div>
		</div>
	</div>
	<?php if (SESSION::has('error')) { ?>
		<div class="row">
			<div class="col s12">
				<div class="card-panel red lighten-3">
					<ul>
						<?php 
						if (is_array($_SESSION['error'])) {
							foreach (SESSION::get('error') as $value) { ?>
								<li class="h5 center"><?= $value ?></li>	
							<?php }
						}else{ ?>
							<li class="h5 center"><?= SESSION::get('error') ?></li>
						<?php } ?>	
					</ul>
				</div>
			</div>
		</div>
	<?php } ?>
</div>


<?php 
@include (TEMPLATES_DIR . "templates/inc/footer.php");

?>