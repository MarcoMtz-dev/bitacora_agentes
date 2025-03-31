<?php
	session_start();
	
	if( isset($_SESSION["userId"]) ){
		header('Location: menu');
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitacora Bancoppel</title>

	<link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/estilosLogin.css">

    <script src="http://10.30.248.4:50/utiles/componentes.js"></script>
	<script src="js/sweetalert2.min.js"></script>
	<script src="js/eventosGenerales.js"></script>
	<script src="js/eventosLogin.js"></script>
	
</head>
<body>
    
<main>
	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form action="#" id="formularioSignup">
				<h1>Crear cuenta</h1>
				<div class="social-container"></div>
				<span>Añade tu información Coppel</span>
				<input type="text" placeholder="# Empleado" name="num_empleado" onlyNumbers required/>
				<input type="text" placeholder="Nombre" name="nombre_empleado" onlyLetters required/>
				<input type="password" placeholder="Contraseña" name="password" validText required/>
				<button>Registrarse</button>
			</form>
		</div>
		<div class="form-container sign-in-container">
			<form action="#" id="formularioSignin">
				<h1>Iniciar Sesión</h1>
				<div class="social-container"></div>
				<span>Administra tus credenciales</span>
				<input type="text" placeholder="# Empleado" name="num_empleado" onlyNumbers required/>
				<input type="password" placeholder="Contraseña" name="password" validText required/>
				<button>Ingresar</button>
				<span id="spanUpdatePass" style="position:absolute;bottom:15px;right:15px;cursor:pointer;"><u>Actualizar Contraseña</u></span>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<!-- <h1>Welcome Back!</h1> -->
					<!-- <h1>Helao?</h1> -->
					<!-- <h1>General Kenobi!</h1> -->
					<h1>¿Ya tienes una cuenta?</h1>
					<p>Si ya tienes una cuenta, ingresa con tus datos</p>
					<button class="ghost" id="signIn">Ingresar</button>
				</div>
				<div class="overlay-panel overlay-right">
					<!-- <h1>Hello, Friend!</h1> -->
					<!-- <h1>Bieeenvenios al Himalaya!</h1> -->
					<!-- <h1>Hello there</h1> -->
					<h1>¿No tienes una cuenta? !Registrate!</h1>
					<p>Registra tu información para ingresar en el sistema</p>
					<button class="ghost" id="signUp">Registrarse</button>
				</div>
			</div>
		</div>
	</div>
</main>

<footer>
	<p>Para cualquier duda o aclaración, comuniquese con el equipo de <u>Creacion Atn</u></p>
</footer>

<script>
    const container = document.getElementById('container');

    document.getElementById('signUp').addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    document.getElementById('signIn').addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
	
</script>

</body>
</html>