<?php
session_start();

if (isset($_REQUEST["IDEMPLEADO"])) {
	$empleadoMod["IDEMPLEADO"]=$_REQUEST["IDEMPLEADO"];
	$empleadoMod["NOMBRE"]=$_REQUEST["NOMBRE"];
	$empleadoMod["APELLIDOS"]=$_REQUEST["APELLIDOS"];
	$empleadoMod["CORREO"]=$_REQUEST["CORREO"];
	$empleadoMod["SALARIO"]=$_REQUEST["SALARIO"];
	
	if (isset($_REQUEST["confirmar"]) && $_SESSION["editando"]=="salario") {
		$salario=$_REQUEST["salarioMod"];
		if($salario<0 || $salario==null || $salario==""){ //VALIDAMOS EN SERVIDOR
			$_SESSION["errorAct"]="El salario debe de ser mayor que 0";
			header("location: consultarEmpleados.php");
			unset($_SESSION["editando"]);
		}

		else{
		//CAMBIAMOS EL SALARIO POR EL NUEVO
		$empleadoMod["SALARIO"]=$salario;
		unset($_SESSION["editando"]);
		}
	}
	if (isset($_REQUEST["confirmar"]) && $_SESSION["editando"]=="correo"){
			$correo=$_REQUEST["correoMod"];
			if ($correo=="" || $correo==null || !filter_var($correo,  FILTER_VALIDATE_EMAIL)) {
				$_SESSION["errorAct"]="El correo no sigue el formato predeterminado x@y.z";
				header("location: consultarEmpleados.php");
				unset($_SESSION["editando"]);
				
			}
			else{

		$empleadoMod["CORREO"]=$correo;
		unset($_SESSION["editando"]);
		}


	}


	$_SESSION["empleadoMod"]=$empleadoMod;


}
if (isset($_REQUEST["borrarEmp"])) {
	header("location: accionBorrarEmpleados.php");
}
else if (isset($_REQUEST["despedir"])) {
	header("location: accionDespedirEmpleados.php");
}
else if(isset($_REQUEST["confirmar"])){
	header("location: accionActualizarEmpleados.php");
}
else if(isset($_REQUEST["actSalario"])){ 
	$_SESSION["editando"]="salario";

	header("location: consultarEmpleados.php");
}
else if(isset($_REQUEST["actCorreo"])){
	$_SESSION["editando"]="correo";

	header("location: consultarEmpleados.php");
}
else if(isset($_REQUEST["cancelar"])){
	unset($_SESSION["editando"]);
	unset($_SESSION["empleadoMod"]);
	header("location: consultarEmpleados.php");
}

else{
	header("location: consultarEmpleados.php");
}


?>