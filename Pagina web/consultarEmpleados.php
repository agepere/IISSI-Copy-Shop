<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarEmpleados.php");

	$conexion = crearConexionBD();
	$filas = consultar_empleados($conexion);
	cerrarConexionBD($conexion);

	if(!isset($_SESSION["loginEmp"])){
		header("location: Pagina inicio.php");
	}
	else{
		if(isset($_SESSION["empleadoMod"])){ //LO UTILIZAREMOS PARA MODIFICAR EMPLEADO (viene del controlador)
	$empleadoMod=$_SESSION["empleadoMod"];
	unset($_SESSION["empleadoMod"]);}

	if (isset($_SESSION["errorAct"])) {
		$error=$_SESSION["errorAct"];
		unset($_SESSION["errorAct"]);
	}


	?>

	
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Empleados de Copycampus</title>
</head>
<body>
<?php include_once("header.php"); ?>




	<?php if(isset($error))

	echo" <div id='erroresConsultaEmp' class='errores'><p>".$error.".</p></div>"?>


 
<?php




foreach ($filas as $fila) { ?>

<article class="empleado" >
<div id="filaEmpleado" class="col-10">
<form  action="controladorEmpleado.php" method="post" >
<div id="soloDatos" class="col-6">
<div class="DatosEmpleado">
<input type="hidden" name="IDEMPLEADO" value="<?php echo $fila['IDEMPLEADO'] ?>">
<input type="hidden" name="NOMBRE" value="<?php echo $fila['NOMBRE'] ?>">
<input type="hidden" name="APELLIDOS" value="<?php echo $fila['APELLIDOS'] ?>">
<input type="hidden" name="CORREO" value="<?php echo $fila['CORREO'] ?>">
<input type="hidden" name="SALARIO" value="<?php echo $fila['SALARIO'] ?>">
</div>

<div id="datosPersonalesEmpleado">
<div id="nombreApeEmp">
<?php  echo "<b>".$fila["NOMBRE"]." "; ?>
<?php  echo $fila["APELLIDOS"]."</b>: "; ?>
</div>
<?php  if(isset($empleadoMod) && $empleadoMod["IDEMPLEADO"]==$fila["IDEMPLEADO"] && $_SESSION["editando"]=="correo"){
	//MOSTRANDO EL INPUT
	?>
	<input type="text" name="correoMod" value="<?php echo $fila["CORREO"] ?>" required maxlength="50">

<?php }else
//MOSTRANDO CORREO
echo "<em>".$fila["CORREO"]."</em> ";

 ?>
</div>

<div id="fechasEmpleado">
<?php  echo "<p>".$fila["FECHAINICIO"]." - "; ?>
<?php  echo $fila["FECHAFIN"]."</p> "; ?>
</div>
<div id="salarioEmpleado">
<?php if(isset($empleadoMod) && $empleadoMod["IDEMPLEADO"]==$fila["IDEMPLEADO"] && $_SESSION["editando"]=="salario"){
	?>
	<input type="number" name="salarioMod" value="<?php echo $fila["SALARIO"] ?>" required maxlength="50" min=0>

	<?php
}
else
 echo "<p>". $fila["SALARIO"]."  €</p>  "; 

 ?>
</div>
<?php if ($_SESSION["loginEmp"]=='admin') {
	
 ?>
 </div>

<div id="botonesEmpleado" class="col-4">
<?php if(isset($empleadoMod) && $empleadoMod["IDEMPLEADO"]==$fila["IDEMPLEADO"]){ //Si estamos modificando esta fila mostramos solo el boton de confirmar cambios
	?>
	
	<button id="confirmar" class="botonMod" name="cancelar" type="submit">Cancelar</button>
	<button id="confirmar" class="botonMod" name="confirmar" type="submit">Confirmar cambios</button>
	<?php } else{ //En caso contrario mostramos el resto de botones
		if($fila["USUARIO"]!="admin"){
		?>
		<button id="despedir" name="despedir" type="submit" title="Actualiza su fecha fin y elimina su cuenta" >Despedir</button>

	<button id="actCorreo" name="actCorreo" type="submit">Actualiza Correo</button>
	

		<button id="borrarEmp" name="borrarEmp" type="submit" >Eliminar</button>
	
	
	<button id="actSalario" name="actSalario" type="submit">Actualiza Salario</button>

	


	<?php }  }?>



</div>
<?php } ?>


</form>
</div>
</article>





<?php
}

?>


<?php if ($_SESSION["loginEmp"]=='admin') {
	
 ?>
<div id="irFormEmpl">
<p>Para insertar un nuevo empleado pulse <a href="formularioEmpleados.php">aquí</a> y le llevaremos al formulario de empleados (Sólo admins).<p>
</div>
<?php }?>


<?php include_once("footer.php"); ?>
</body>
</html>

<?php
}
?>