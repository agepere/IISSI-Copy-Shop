<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Copycampus: Empleados</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>

<?php include_once("header.php"); ?>

<h1 id="Bienvenido">¡Bienvenid@ a copycampus! </h1>


<!-- LOGIN EMPLEADOS -->

<?php 
	if(isset($_SESSION["loginCliente"])){

		header("location: Pagina inicio.php");
	}


else if (!isset($_SESSION["loginEmp"])&& !isset($_SESSION["loginCliente"])) {
  
?>

<div id="IniciaSesionEmpleado">
<div id="ErrorEmpleado">
<?php
if (isset($_SESSION["errorLoginEmp"])) {

  echo "<div id='ErrorLoginEmp' class='col-10'>";
  echo "<p> Fallo al iniciar sesión. El usuario o la contraseña son incorrectos. </p>";
  echo "</div>";
  $_SESSION["errorLoginEmp"]=null;
}
?>
</div> <br>
<div id="BotonEmp">
<button id="BotonIniciaSesion" class="botonIniciaSesion"value="Iniciar Sesion"  onclick="apareceFormIniciarSesionEmpleado(); this.style.visibility='hidden'">Iniciar Sesion</button>
</div>

<div id="logEmpleado" style='display: none'>
<p>¿Eres un empleado? Inicia sesión metiendo tus datos en: </p>
<form action="loginEmp.php" method="post">
<label for="Nickname">Usuario:</label><input type="text" name="Nickname" id="Nickname" required="">
<label for="Password">Contraseña:</label><input type="Password" name="Password" id="Password" required="">
<input class="botonIniciaSesiconCliente" type="submit" name="submit" value="Inicia Sesión" />
  
  

</form></div>
</div>
<?php

}

else{
  if(isset($_SESSION["loginEmp"])){
 
//EMPLEADO LOGEADO
  ?>
<div id="EmpleadoLogeado" >

<div id="LogOutEmp">
<h2 id="mensajeBienvenidaEmpleado"></h2>
<form action="loginEmp.php">
<a href="consultarEmpleados.php">Listado de empleados</a>
<a href="consultarCompras.php">Detalles de compras</a>
<a href="consultarVentas.php">Detalles de ventas</a>
<a href="formularioCatalogo.php">Formulario catalogo</a>
<div  >
<br><br>
<input class="botonLogout" type="submit" name="salirEmp" value="Log Out" />
</div>
</form>
  </div>
  </div>

<?php 
	}

}
?>

	
		<?php include_once("footer.php"); ?>



<script type="text/javascript">
	function apareceFormIniciarSesionEmpleado() {
      document.getElementById('logEmpleado').style.display = 'block'; 
      document.getElementById('BotonEmp').style.display = 'none'; 
}
</script>

    <script type="text/javascript">
  var msj2;
  var fecha = new Date();

  if      (fecha.getHours() < 7)  { msj2 = "Buenas noches, <?php echo $_SESSION["loginEmp"]?>.";}
  else if (fecha.getHours() < 12) { msj2 = "Buenos días, <?php echo $_SESSION["loginEmp"]?>.";}
  else if (fecha.getHours() < 21) { msj2 = "Buenas tardes, <?php echo $_SESSION["loginEmp"]?>.";}
  else                                          { msj2 = "Buenas noches, <?php echo $_SESSION["loginEmp"]?>.";}

 document.getElementById("mensajeBienvenidaEmpleado").innerHTML    = msj2;
</script>
</body>

</html>