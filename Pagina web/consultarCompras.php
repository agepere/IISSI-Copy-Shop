<?php

session_start();
if(!isset($_SESSION["loginEmp"])){
	$_SESSION["inicia"]="Debes iniciar sesión como empleado para acceder a esa funcionalidad.";
	header("location: Pagina inicio.php");
}
else{

	require_once("gestionBD.php");
	require_once("paginacion_consulta.php");
	require_once("gestionarCompras.php");
	require_once("gestionarDetalleCompra.php");
	require_once("gestionarCatalogo.php");

if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"]; 
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]:
												(isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);
	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]:
										(isset($paginacion)? (int)$paginacion["PAG_TAM"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;

	unset($_SESSION["paginacion"]);

	$conexion =  crearConexionBD();

	$query ='SELECT IDCOMPRAS, FECHACOMPRA, TOTAL,IDPROVEEDOR	
			FROM COMPRAS ORDER BY FECHACOMPRA DESC';
 
	$total_registros = total_consulta($conexion,$query);
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	
	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	
	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);

	if(isset($_SESSION["detallito"])){ 
	$compraMod=$_SESSION["detallito"];
	unset($_SESSION["detallito"]);
	}

	cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Compras de Copycampus</title>
</head>
<body>
<?php include_once("header.php"); ?>
<?php
if (isset($_SESSION["details"])){
		
		$IdDetCompra=$_SESSION["details"];
		$formularioDet=$IdDetCompra; // AÑADIDO POSTERIORMENTE PARA CAMBIAR EL COLOR DE LA TABLA SIN NECESIDAD DE TOCAR MAS CODIGO
		$details=consultarDetalleCompra($conexion,$IdDetCompra);
		unset($_SESSION["details"]);
	}

	if (isset($_SESSION["formularioDet"])) {
		$formularioDet=$_SESSION["formularioDet"];
		unset($_SESSION["formularioDet"]);
	}

		if(isset($_SESSION["erroresDet"])){
		$erroresDet=$_SESSION["erroresDet"];
		unset($_SESSION["erroresDet"]);
	} ?>
<main>
	 <nav>
		<div id="enlaces">
			<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ ) 
					if ( $pagina == $pagina_seleccionada) { 	?>
						<span class="current"><?php echo $pagina; ?></span>
			<?php }	else { ?>			
						<a href="consultarCompras.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
			<?php } ?>			
		</div>
		
		<form id="formulario" method="get" action="consultarCompras.php">
			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada; º?>"/>
			Mostrando 
			<input id="PAG_TAM" name="PAG_TAM" type="number" 
				min="1" max="<?php echo $total_registros;?>" 
				value="<?php echo $pag_tam?>" autofocus="autofocus" /> 
			entradas de <?php echo $total_registros?>
			<input type="submit" value="Cambiar">

		</form>
		<div id="InsertarCompras">
		<form action="accionInsertarCompras.php">
		<button id="insertarCom" name="insertarCom" type="submit" >Insertar</button>
		</form>
		</div><br>
	</nav>


	<?php
	if (isset($erroresDet)) {
		echo "<div id=erroresDetalles><h3>ERRORES:</h3>";
		foreach ($erroresDet as $error) {
			echo $error."<br></div>";
		}
	}
          
		foreach ($filas as $fila) { 	?>
		
	<div class="col-10">
		<article id="compra">
			<form method="post" action="controlador_compra.php">
				<div class="filaCompra">
					<div class="datos_compra">
						<input  name="IDCOMPRAS"
						type="hidden" value="<?php echo $fila['IDCOMPRAS'] ?>">
						<input  name="IDPROVEEDOR" 
						type="hidden" value="<?php echo $fila['IDPROVEEDOR'] ?>">
						<input  name="FECHACOMPRA" 
						type="hidden" value="<?php echo $fila['FECHACOMPRA'] ?>">
						<input  name="TOTAL" 
						type="hidden" value="<?php echo $fila['TOTAL'] ?>">
					</div>
					<div id="tablaRedondeada" <?php if (isset($formularioDet) && $formularioDet==$fila['IDCOMPRAS'] ) {
					?> style="background-color: #a52a2a; font-weight: bolder;" <?php } ?>>
					<div id="datos_compra">
					<?php echo "Nº COMPRA: ".$fila["IDCOMPRAS"]; ?><br>
                   <?php  echo "FECHACOMPRA: ".$fila["FECHACOMPRA"]; ?><br>
					<?php  echo "TOTAL: ".$fila['TOTAL']." €"; ?>
					</div>

	               <div id="botonesCompra">
	              
				<button id="borrarCom" name="borrarCom" type="submit" >Eliminar</button>
				<button id="detCom" name="detCom" type="submit">Detalles de la compra</button>
			
				<button id="detComAdd" name="detComAdd" type="submit">Añadir Detalles</button>
              </div>
              </div>
              </div>
			</form>
		</article>

				<?php 
				if(isset($IdDetCompra) && $fila['IDCOMPRAS']==$IdDetCompra){
					echo "<div id='DetallesCompra' class='col-5'>";
					
				foreach ($details as $detail){
					echo "<div id='DatosDetCom' class='col-9'>";
					$catalogo=getCatalogoId($conexion,$detail["IDCATALOGO"]);
					if($detail["PRECIOCOMPRA"]<1)
					echo $catalogo["NOMBRE"]. ": ".$detail["CANTIDAD"] ."x0".$detail["PRECIOCOMPRA"]. "€ <br>";
					else
					echo $catalogo["NOMBRE"]. ": ".$detail["CANTIDAD"] ."x".$detail["PRECIOCOMPRA"]. "€ <br>";
					echo "</div>";
					?>
					<div id="accionDetalleCompra" >
						<form action="controlador_compra.php" method="post">
							<input type="hidden" name="idDetalleCompra" value="<?php echo $detail['IDDETALLECOMPRA']?>">
							<input type="hidden" name="idCompra" value="<?php echo $detail['IDCOMPRAS']?>">
							<button name="Eliminar">Borrar </button>
						</form>

					</div>

		<?php	}



			}
			else if(isset($formularioDet) &&  $fila['IDCOMPRAS']==$formularioDet){
				$catalogos=consultar_catalogo($conexion);
				?>

				<form action="accionInsertarDetalleCompra.php" method="post" id="insertDetCompra" class="col-5">
				<div id="tablaRedondeadaForm">
					<input type="hidden" name="IDCOMPRAS" value="<?php echo  $fila['IDCOMPRAS'] ?>">
					<select name="IDCATALOGO">
						<option value="none">Selecciona un producto</option>
						<?php
						foreach ($catalogos as $catalogo) {
							echo "<option value=".$catalogo["IDCATALOGO"].">".$catalogo["NOMBRE"]."</option>" ;
						} ?>
					</select>
					<br><input size="100"  type="number" name="CANTIDAD" placeholder="Cantidad Deseada" ><br>
					<button type="submit" name="confirmarDet">Confirmar</button>
					<button type="submit" name="cancelar">Cancelar</button>
					</div>
				</form>


				<?php }	?>
		</div>
	<?php } ?>
	
</main>
<?php include_once("footer.php"); } ?>
</body>
</html>