
<?php 
session_start();

/*Comprobamos que venimos del formulario viendo si la variable DNI  esta definida  */

    if (isset($_SESSION['formularioCat'])) {
        $nuevoCatalogo['Nombre'] = $_REQUEST["Nombre"];
		$nuevoCatalogo['Descripcion'] =  $_REQUEST["Descripcion"];      
		$nuevoCatalogo['Precio'] =  $_REQUEST["Precio"];
        $nuevoCatalogo['IVA'] =  $_REQUEST["IVA"];
        $nuevoCatalogo['Stock'] = $_REQUEST["Stock"];
        $nuevoCatalogo['StockMinimo'] =  $_REQUEST["StockMinimo"];
        $nuevoCatalogo['TipoProducto'] =  $_REQUEST["TipoProducto"];
        $nuevoCatalogo['TipoCatalogo'] =  $_REQUEST["TipoCatalogo"];
    
    }

/*En caso contrario redireccionamos de nuevo al formulario*/

else{
header("Location: formularioCatalogo.php");
}

$_SESSION["formularioCat"]= $nuevoCatalogo;

// Validamos el formulario en servidor 
	$erroresCat = validarDatosCatalogo($nuevoCatalogo);
	
	// Si se han detectado errores
	if (count($erroresCat)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresCat"] = $erroresCat;
		 Header('Location: formularioCatalogo.php');
	} else
		// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
		Header('Location: exito_alta_catalogo.php');

		function validarDatosCatalogo($nuevoCatalogo){
	

	//Validacion del nombre

		if($nuevoCatalogo["Nombre"]==""){
			$erroresCat[]="El nombre no debe estar vacío";

		}
		else if(strlen($nuevoCatalogo["Nombre"])>50){
		$erroresCat[]="El Nombre no puede tener más de 50 caracteres";
	}
		//Validacion de la descripcion

		if($nuevoCatalogo["Descripcion"]==""){
			$erroresCat[]="La descripción no puede estar vacía";

		}

		//Validacion del Precio
		if($nuevoCatalogo["Precio"]<0.0){
		$erroresCat[]="El Precio debe ser mayor que 0";

	}
	//Validacion del Precia
    $Precio=$nuevoCatalogo["Precio"];
	$findme=",";
	$coma=strpos($Precio,$findme);
	if($coma==false){
		$erroresCat[]="El precio tiene que ser introducido con una coma";
	}

	//Validacion del IVA

	
	if($nuevoCatalogo["IVA"]<1.0){
		$nuevoCatalogo[]="El iva debe ser";
	}
	$Iva=$nuevoCatalogo["IVA"];
	$findme=",";
	$coma=strpos($Iva,$findme);
	if($coma==false){
		$erroresCat[]="El iva tiene que ser introducido con una coma";
	}

	//Validación del stock

	if($nuevoCatalogo["Stock"]<0){
		$erroresCat[]="El stock no puede ser negativo";
	}

	else if ($nuevoCatalogo["Stock"]<$nuevoCatalogo["stockMinimo"]) {
		$erroresCat[]="El stock no puede ser menos que el stock minimo";
	}

	//Validación del stockMinimo

	if($nuevoCatalogo["stockMinimo"]<0){
		$erroresCat[]="El stock minimo no puede ser negativo";
	}

		return $erroresCat;

		}

?>


