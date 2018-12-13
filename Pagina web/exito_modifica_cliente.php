<?php 
session_start();
require_once("gestionBD.php");
require_once("gestionarClientes.php");
if(!isset($_SESSION["formModCliente"])){
	header("location: Pagina inicio.php");
}
else{


$conexion=crearConexionBD();
$cliente=$_SESSION["formModCliente"];
unset($_SESSION["formModCliente"]);
$clienteAntiguo=getCliente($conexion,$_SESSION["loginCliente"]);
//Actualizamos las variables que dejamos disabled y el id cliente
$cliente["IDCLIENTE"]=$clienteAntiguo["IDCLIENTE"];

$cliente["Nickname"]=$_SESSION["loginCliente"];
$res=actualiza_cliente($conexion,$cliente);
cerrarConexionBD($conexion);

if($res==false){
$_SESSION["excepcion"]="Error al modificar el cliente";
header("location: excepcion.php");
}
else{



?>
<!DOCTYPE html>
<html>
<head>
	<title>Éxito al modificar tus datos</title>
</head>
<body>
<div id=exitoModificaCliente>
<h1>Sus datos han sido modificados correctamente.</h1>
<p>Pulsa <a href="Pagina inicio.php">aquí</a> para volver a la página de inicio.</p>
</div>
</body>
</html>

<?php	
}




}

?>