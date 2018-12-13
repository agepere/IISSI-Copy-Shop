<?php 
	session_start();
	
	
	if(!isset($_SESSION["loginCliente"])){
		$_SESSION["inicia"]="Debes iniciar sesión para acceder a esa funcionalidad.";
		header("location: Paginia inicio.php");
	}
	else{
		include_once("gestionBD.php");
		include_once("gestionarClientes.php");

	$conexion=crearConexionBD();
    $cliente=getCliente($conexion,$_SESSION["loginCliente"]);
    cerrarConexionBD($conexion);
    
    if (isset($_SESSION["erroresCliente"])) {
    	$errores=$_SESSION["erroresCliente"];
    	unset($_SESSION["erroresCliente"]);
    }

    ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Copycampus: Tu perfil</title>
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>
     
	<?php include_once("header.php"); 
		
	if (isset($errores)) {
		echo "<div class=errores><h2>Errores en el formulario:</h2>";
		foreach ($errores as $error) {
			echo "<br>".$error."</div>";
		}
	}

	?>

	

	<form  id="form1" action="accion_modifica_cliente.php" method="post" >
	<h1><strong>REGISTRO DE NUEVOS CLIENTES</strong></h1>
		<p>
			<i>Los campos obligatorios están marcados con </i><em>*</em>
		</p>

		<fieldset id="personales">
			<legend>Datos personales</legend>
			
			<label for="NIF">NIF </label><input type="text" id="NIF" name="NIF" placeholder="12345678X" pattern="^[0-9]{8}[A-Z]" title="Ocho dígitos seguidos de una letra mayúscula" maxlength="9" value="<?php echo $cliente['DNI'] ?>"><br>
			<label for="Nombre">Nombre: </label><input type="text" id="Nombre" name="Nombre" size=40 maxlength="50" value="<?php echo $cliente['NOMBRE'] ?>"><br>
			<label for="Apellidos">Apellidos:</label> <input type="text" id="Apellidos" name="Apellidos" size=80 maxlength="50" value="<?php echo $cliente['APELLIDOS'] ?>"><br>
			<label for="Email">Email:</label> <input type="email" id="Email" name="Email" placeholder="usuario@dominio.extension" maxlength="50" value="<?php echo $cliente['CORREO'] ?>"><br>
			<label for="Direccion">Dirección:</label> <input type="text" id="Direccion" name="Direccion"   maxlength="100" value="<?php echo $cliente['DIRECCION'] ?>"><br>
			<label for="Telefono">Teléfono:</label> <input type="text" id="Telefono" name="Telefono" pattern="[0-9]{7,20}" maxlength="9" value="<?php echo $cliente['TELEFONO'] ?>"><br> 
			
			<?php if($cliente['TIPO']=="Universitario"){  // ¿ES UNIVERSITARIO? ?>
			<label>Tipo: </label> 
				<label><input type="radio" name="Tipo" value="Universitario" checked> Universitario</label>
				<label><input type="radio"  name="Tipo" value="NoUniversitario" > No Universitario</label>
			<?php }
			else{ ?>
				<label>Tipo: </label> 
				<label><input type="radio" name="Tipo" value="Universitario" > Universitario</label>
				<label><input type="radio"  name="Tipo" value="NoUniversitario" checked > No Universitario</label>
				<?php } ?>
			

		</fieldset>

		<fieldset id="datosusuario">
		<legend>Datos de usuario</legend>
		<label for="Nickname"> Usuario: <em>*</em></label>
    	<input  id="Nickname" type="text" name="Nickname" required maxlength="50" value="<?php echo $cliente['USUARIO'] ?>" disabled /><br>
        
        <label for="Password"> Password:<em>*</em> </label>
    	<input id="Password" type="password" name="Password" maxlength="50" required value="<?php echo $cliente['PASS'] ?>" /><br>
    	
    	<label for="ConfirmarPassword"> Confirmar Password: </label>
    	<input name="ConfirmarPassword" id="ConfirmarPassword" type="password" required><br>



		</fieldset>

		
		<input type="submit" name="actCliente" value="Actualizar">
		
	</form>

	<form id="form1"action="Pagina inicio.php"> 
			<button type="submit" class="botonExcluido" name="cancelarModCliente">Cancelar</button>
	</form>
	<?php include_once("footer.php"); ?>
</body>

</html>





    <?php

    } ?>