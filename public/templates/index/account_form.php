<?php 
@include (TEMPLATES_DIR . "templates/inc/head.php");  
?>

<div class="card">
	<form method="POST">
		<input type="hidden" value="<?= csrf_token() ?>" name="csrftoken" required>
		<div class="card-content center red-text">
			<h4>Registro de Alumno</h4>
		</div>
		<div class="divider"></div>
		<div class="card-content">
			<div class="">
				<div class="row">
					<div class="col s12">
						<div class="row">
							<div class="input-field col s6">
								<select name="nacionality" id="id_nacionality" autofocus="on" autocomplete="off" required value="">
									<option value="" disabled selected>Cedula <span class="ast-input">*</span></option>
									<option value="V">V-</option>
									<option value="E">E-</option>
								</select>
								<label>Cedula</label>
							</div>

							<div class="input-field col s6">
								<input class="validate" id="id_cedula" name="cedula" type="number" min="1" max="99999999" autocomplete="off" required >
								<label for="id_cedula">Cedula Del Alumno <span class="ast-input">*</span></label>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s6">
								<input class="validate" id="id_name" name="name" type="text" maxlength="50" autocomplete="off" required>
								<label for="id_name">Nombre Del Alumno <span class="ast-input">*</span></label>
							</div>

							<div class="input-field col s6">
								<input class="validate" id="id_last_name" name="last_name" type="text" maxlength="50" autocomplete="off" required>
								<label for="id_last_name">Apellido Del Alumno <span class="ast-input">*</span></label>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s6">
								<select name="sex" id="is_sex" autocomplete="off" required value="">
									<option value="" selected>Sexo <span class="ast-input">*</span></option>
									<option value="masculino">MASCULINO</option>
									<option value="femenino">FEMENINO</option>
									<option value="indefinido">INDEFINIDO</option>
								</select>
								<label>Sexo</label>
							</div>

							<div class="input-field col s6">
								<select name="sede" id="id_sede" autocomplete="off" required value="">
									<option value="">Sede <span class="ast-input">*</span></option>
									<?php foreach ($sedes as $sede) {?>
										<option value="<?= $sede->id ?>"><?= $sede->nombre ?></option>
									<?php } ?>
								</select>
								<label>Sede</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s6">
								<select name="pnf" id="id_pnf" autocomplete="off" required value="">
									<option value="">Pnf <span class="ast-input">*</span></option>
									<?php foreach ($pnfs as $pnf) {?>
										<option value="<?= $pnf->id ?>"><?= $pnf->nombre ?></option>
									<?php } ?>
								</select>
								<label>Pnf</label>
							</div>

							<div class="input-field col s6">
								<select name="turno" id="is_turno" autocomplete="off" required value="">
									<option value="" selected>Turno<span class="ast-input">*</span></option>
									<option value="masculino">DIURNO</option>
									<option value="femenino">NOCTURNO</option>
								</select>
								<label>Turno</label>
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
													<li class="h5"><?= $value ?></li>	
												<?php }
											}else{ ?>
												<li class="h5"><?= SESSION::get('error') ?></li>
											<?php } ?>	
										</ul>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="card-action center">
			<button class="btn waves-effect waves-light blue" type="submit">Añadir
				<i class="material-icons right">send</i>
			</button>
			<a class="btn waves-effect waves-light red" href="<?= url("/") ?>">Regresar
				<i class="material-icons right">arrow_back</i>
			</a>
		</div>
	</form>
</div>


<?php 
@include (TEMPLATES_DIR . "templates/inc/footer.php");

?>