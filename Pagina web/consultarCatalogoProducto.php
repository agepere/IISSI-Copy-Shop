<?php
	session_start();

	if(!isset($_SESSION["loginEmp"]) && !isset($_SESSION["loginCliente"])){
		$_SESSION["inicia"]="Debes iniciar sesión para acceder a esa funcionalidad.";
	header("location: Pagina inicio.php");
}
else{

	require_once("gestionBD.php");
	require_once("gestionarCatalogo.php");
	require_once("paginacion_consulta.php");


	$_SESSION["TIPOCATALOGO"]="Producto";

	
	// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
	// ¿Hay una sesión activa?
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"]; 
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]:
												(isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);
	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]:
										(isset($paginacion)? (int)$paginacion["PAG_TAM"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;
		
	// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	//COMPROBAMOS SI EXISTE UNA VARIABLE DE SESION, SI EXISTE LA GUARDAMOS EN UNA VARIABLE NUEVA Y BORRAMOS LA ORIGINAL

	if(isset($_SESSION["catMod"])){
		$catMod = $_SESSION["catMod"];
		unset($_SESSION["catMod"]);
	}


	
	

	//$filas = consultar_catalogo($conexion);
	
	

	$query= "SELECT IDCATALOGO,NOMBRE,TIPOPRODUCTO,TIPOCATALOGO,DESCRIPCION,PRECIO,IVA,STOCK,STOCKMINIMO FROM CATALOGO WHERE (TipoCatalogo='Producto') ";
	

	$total_registros = total_consulta($conexion,$query);
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	
	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	
	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);
	
	cerrarConexionBD($conexion);
?>

	
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Productos de Copycampus</title>
</head>
<body>
<?php include_once("header.php"); ?>

	<?php if(isset($error))

	echo" <div id=erroresConsultaCat class=errores><h2>Errores: </h2><p>".$error.".</p></div>"?>

	<main>
	 <nav>
		<div id="enlaces">
			<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ ) 
					if ( $pagina == $pagina_seleccionada) { 	?>
						<span class="current"><?php echo $pagina; ?></span>
			<?php }	else { ?>			
						<a href="consultarCatalogoProducto.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
			<?php } ?>			
		</div>
		
		<form id="formulario" method="get" action="consultarCatalogoProducto.php">
			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
			Mostrando 
			<input id="PAG_TAM" name="PAG_TAM" type="number" 
				min="1" max="<?php echo $total_registros;?>" 
				value="<?php echo $pag_tam?>" autofocus="autofocus" /> 
			entradas de <?php echo $total_registros?>
			<input type="submit" value="Cambiar"><br>
		</form>
	</nav>

 
<?php




foreach ($filas as $fila) { ?>

	<article class="catalogo">
		<form action="controladorCatalogo.php" method="post">
			<div class="filaCatalogo">
			<div class="Datoscatalogo">
				<input type="hidden" name="IDCATALOGO" value="<?php echo $fila['IDCATALOGO'] ?>">
				<input type="hidden" name="NOMBRE" value="<?php echo $fila['NOMBRE'] ?>">
				<input type="hidden" name="DESCRIPCION" value="<?php echo $fila['DESCRIPCION'] ?>">
				<input type="hidden" name="PRECIO" value="<?php echo $fila['PRECIO'] ?>">
				<input type="hidden" name="IVA" value="<?php echo $fila['IVA'] ?>">
				<input type="hidden" name="STOCK" value="<?php echo $fila['STOCK'] ?>">
				<input type="hidden" name="STOCKMINIMO" value="<?php echo $fila['STOCKMINIMO'] ?>">
				<input type="hidden" name="TIPOPRODUCTO" value="<?php echo $fila['TIPOPRODUCTO'] ?>">
				<input type="hidden" name="TIPOCATALOGO" value="<?php echo $fila['TIPOCATALOGO'] ?>"> <br>


			</div>

			<div id="Datoscatalogo">
				<strong><?php  echo $fila["NOMBRE"]." "; ?></strong>
					<?php  echo "(".$fila["TIPOPRODUCTO"].") "; ?><br>
					<?php  echo "-Descripción: ".$fila["DESCRIPCION"]."; "; ?><br>
					
					<?php if(isset($catMod) && $catMod["IDCATALOGO"]==$fila["IDCATALOGO"] ){
					//MOSTRANDO EL INPUT
			?>
					<input type="text" name="precioMod" value="<?php echo $fila["PRECIO"] ?>" required maxlength="50"><br>

			<?php }else{
				//MOSTRANDO PRECIO
					if($fila["PRECIO"] <1){ 
						echo "Precio: 0".$fila["PRECIO"].";<br>  ";}
						else{
							echo "Precio: ".$fila["PRECIO"].";<br>  ";
						} 

					}?>
 
					<?php  echo "IVA: 0".$fila['IVA'].";<br>  "; ?>
					<?php  echo "Stock: ".$fila["STOCK"].";<br>  "; ?>
					<?php  echo "Stock Mínimo: ".$fila["STOCKMINIMO"].";<br>  "; ?>

			</div>

	

			<div id="botonesCatalogo">

				<?php if(isset($catMod) && $catMod["IDCATALOGO"]==$fila["IDCATALOGO"]){ //Si estamos modificando esta fila mostramos solo el boton de confirmar cambios
	?>
				<button id="confirmar" name="confirmar" type="submit">Confirmar cambios</button>
				<?php } else{ //En caso contrario mostramos el resto de botones
					if (isset($_SESSION["loginEmp"])) {
						
					

					?>
				
				<button id="borrarCat" name="borrarCat" type="submit" ><img src="images/Papelera.png" alt="Eliminar" title="Eliminar" width="50px" height="50px"></button>
				<button id="actPrecio" name="actPrecio" type="submit" ><img src="images/editar.png" alt="Editar" title="Editar" width="50px" height="50px"></button>

				<?php } } ?>
				
	
			</div>
		</form>
	</article>





<?php
}

?>
	</main>


<?php include_once("footer.php"); } ?>

</body>
</html>

