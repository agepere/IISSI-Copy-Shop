<?php
session_start();
//Comprobamos que ha llegado a la pagina rellando el formulario
    require_once("gestionBD.php");
	require_once("gestionarCatalogo.php");

if(isset($_SESSION["formularioCat"])){
	$nuevoCatalogo=$_SESSION["formularioCat"];
	$_SESSION["formularioCat"] = null;
	$_SESSION["erroresCat"] = null;
}

//En caso contrario se le redirige al formulario
else
header("location: formularioCatalogo.php");

 $conexion=crearConexionBD();
?>



<!DOCTYPE html>
<html>
<head>
	<title>Exito Alta de Catalogo</title>
</head>
<body>
		 <?php include_once("header.php"); ?>
		<h2>El nuevo catalogo ha sido dado de alta con éxito con los siguientes datos:</h2>
<ul>
		<li>Nombre: <?php echo  $nuevoCatalogo["Nombre"]?></li>
		<li>Descripcion: <?php echo  $nuevoCatalogo["Descripcion"]?></li>
		<li>Precio: <?php echo  $nuevoCatalogo["Precio"]?></li>
		<li>IVA: <?php echo  $nuevoCatalogo["IVA"]?></li>
		<li>Stock: <?php echo  $nuevoCatalogo["Stock"]?></li>
		<li>StockMinimo: <?php echo  $nuevoCatalogo["StockMinimo"]?></li>
		<li>TipoProducto: <?php echo  $nuevoCatalogo["TipoProducto"]?></li>
		<li>TipoCatalogo: <?php echo  $nuevoCatalogo["TipoCatalogo"]?></li>

	</ul><br>
<?php 
	if (alta_catalogo($conexion, $nuevoCatalogo)) { 
				echo "<p> El nuevo catalogo ha sido añadido a la base de datos correctamente.</p><br>";
			}
			else{
				echo "<h2> Los datos añadidos en el formulario son correctos pero hubo un fallo al añadirlo en la base de datos. Lo que significa que el catalogo ya existía.</h2>";
			}
		?>
	  Pulsa <a href="formularioCatalogo.php">aquí</a> para volver al formulario de altas de catalogos.

	  <?php include_once("footer.php"); ?>

</body>
</html>