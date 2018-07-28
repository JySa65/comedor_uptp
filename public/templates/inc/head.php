<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="id=edge">
	<title>Comedor UPTP</title>
	<link rel="shortcut icon" href= <?= STATIC_DIR . "img/bg.png"; ?> type="image/x-icon">
	<link rel="stylesheet" href= <?= STATIC_DIR . "css/app.css"; ?> >
	<link rel="stylesheet" href=<?= STATIC_DIR . "css/iconfont/material-icons.css"; ?>>
</head>
<body class="">
	<div class="opacity_back"></div>
	<main>
		<div>
			<ul id="slide-out" class="side-nav fixed show-on-large-only">
				<li style="padding-top: 10px;">
					<div class="background">
						<img src="<?= STATIC_DIR . "img/bg.png"; ?>" width=300 height=200>
					</div> 
				</li>
				<li><a class="waves-effect" href="<?= url("account/new") ?>">  <i class="small material-icons red-text">person_add</i>Registra Alumnos</a></li>
				<li><a class="waves-effect" href="<?= url("") ?>"><i class="small material-icons red-text">group</i>Listado Alumnos</a></li>
				<li><div class="divider"></div></li>
				<li><a href="<?= url('account/runtine') ?>" class="waves-effect"><i class="small material-icons red-text">account_balance_wallet</i>Rutina De Alumno</a></li>
				<li><a class="waves-effect" href="<?= url('reporte') ?>"><i class="small material-icons red-text">picture_as_pdf</i>Reporte Alumno</a></li>
				<li><div class="divider"></div></li>
				<li><a class="waves-effect" href="<?= url('dayforget') ?>"><i class="small material-icons red-text">event_note</i>Dias olvidados</a></li>
			</ul>
		</div>
		<div class="navbar-fixed">
			<nav class="nav-wrapper red">
				<div class="container">
					<a href="#!" class="brand-logo center">UPTP Comedor</a>
					<a href="#" data-activates="slide-out" class="button-collapse hide-on-large-only"><i class="material-icons">menu</i></a>
				</div>   
			</nav>
		</div>
	</main>

	<section class="padi-context ">
		<div class="row">
			<div class="col-lg-12">