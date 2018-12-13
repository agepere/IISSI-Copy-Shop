<?php
    session_start();

    // Miramos si en session esta la variable formulario, y si no esta iniciamos el formulario a los valores por defecto
    if (!isset($_SESSION['formularioClientes'])) {
        $formularioClientes['NIF'] = "";
        $formularioClientes['Nombre'] = "";
        $formularioClientes['Apellidos'] = "";
        $formularioClientes['Email'] = "";
        $formularioClientes['Direccion'] = "";
        $formularioClientes['Telefono'] = "";
        $formularioClientes['Tipo'] = "";
        $formularioClientes['Nickname'] = "";
        $formularioClientes['Password'] = "";
        $formularioClientes['ConfirmarPassword'] = "";
    
        $_SESSION['formularioClientes'] = $formularioClientes;
    }
    // Si ya existían valores, los cogemos para inicializar el formulario
    else
        $formularioClientes = $_SESSION['formularioClientes'];
            
    // Recogemos los errores en caso de que los haya 
    if (isset($_SESSION["erroresCliente"]))
        $errores = $_SESSION["erroresCliente"];
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Copycampus: Alta clientes</title>
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>
     
	<?php include_once("header.php"); ?>

	<?php 
    
    // Si existen errores los mostramos 

    if(isset($errores)){
        echo "<div id= \"div_errores\" class= \"error\">";
        echo  "<h4> Errores en el formulario  </h4> " ;
        foreach ($errores as $error) {
            echo "<br>". $error ;
            
        }
        echo "</div>";

    }
    
    ?>

	<form action="accion_alta_cliente.php" method="post" novalidate>
	<h1><strong>REGISTRO DE NUEVOS CLIENTES</strong></h1>
		<p>
			<i>Los campos obligatorios están marcados con </i><em>*</em>
		</p>

		<fieldset id="personales">
			<legend>Datos personales</legend>
			<label for="NIF">NIF<em>*</em> </label><input type="text" id="NIF" name="NIF" required="" placeholder="12345678X" pattern="^[0-9]{8}[A-Z]" title="Ocho dígitos seguidos de una letra mayúscula" maxlength="9"><br>
			<label for="Nombre">Nombre:<em>*</em> </label><input type="text" id="Nombre" name="Nombre" required="" size=40 maxlength="50"><br>
			<label for="Apellidos">Apellidos:</label> <input type="text" id="Apellidos" name="Apellidos" size=80 maxlength="50"><br>
			<label for="Email">Email:<em>*</em></label> <input type="email" id="Email" name="Email" required="" placeholder="usuario@dominio.extension" maxlength="50"><br>
			<label for="Direccion">Dirección:<em>*</em></label> <input type="text" id="Direccion" name="Direccion" required=""  maxlength="100"><br>
			<label for="Telefono">Teléfono:<em>*</em></label> <input type="text" id="Telefono" name="Telefono" pattern="[0-9]{7,20}" maxlength="9"><br>
			<label>Tipo: </label> 
				<label><input type="radio" name="Tipo" value="Universitario" checked> Universitario</label>
				<label><input type="radio"  name="Tipo" value="NoUniversitario" > No Universitario</label>
				
			

		</fieldset>

		<fieldset id="datosusuario">
		<legend>Datos de usuario</legend>
		<label for="Nickname"> Usuario: </label>
    	<input  id="Nickname" type="text" name="Nickname" required maxlength="50" /><br>
        
        <label for="Password"> Password:<em>*</em> </label>
    	<input id="Password" type="password" name="Password" maxlength="50" required /><br>
    	
    	<label for="ConfirmarPassword"> Confirmar Password: </label>
    	<input name="ConfirmarPassword" id="ConfirmarPassword" type="password" required><br>



		</fieldset><br>

		
		<input type="submit" class="botonIniciaSesion" value="Enviar">
		
	</form>

	<?php include_once("footer.php"); ?>
</body>

</html>