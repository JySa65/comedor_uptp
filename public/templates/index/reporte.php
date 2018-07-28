<?php 
@include (TEMPLATES_DIR . "templates/inc/head.php");  
?>

<div class="card">
	<div class="card-content center red-text">
		<h4>Rutinas de Alumno</h4>
	</div>
	<div class="divider"></div>
	<div class="card-content">
		<div class="row">
			<div class="col s12">
				<form method="GET" target="_blank">
					<div class="input-field col s9">
						<input type="text" class="datepicker" value="<?= date("Y-m-d") ?>" name="get_date">
						<label for="id_cedula">Ingrese Fecha Para Emitir Reporte</label>
					</div>
					<div class="col s3">
						<button class="btn-floating btn-large waves-effect waves-light blue" target="_blank"  type="submit">
							<i class="material-icons right">search</i>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php 
@include (TEMPLATES_DIR . "templates/inc/footer.php");

?>