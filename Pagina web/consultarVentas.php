<?php

session_start();

if(!isset($_SESSION["loginEmp"])){
	$_SESSION["inicia"]="Debes iniciar sesión como empleado para acceder a esa funcionalidad.";
	header("location: Pagina inicio.php");
}
else{

require_once("gestionBD.php");
require_once("paginacion_consulta.php");
require_once("gestionarVentas.php");
require_once("gestionarEmpleados.php");
require_once("gestionarClientes.php");
require_once("gestionarDetalleVenta.php");
require_once("gestionarCatalogo.php");
function getFechaFormateada($fecha){
		$fechaNacimiento = date('d/n/Y', strtotime($fecha));
		return $fechaNacimiento;
	}

if (isset($_REQUEST["fecha1"]) && isset($_REQUEST["fecha2"])) {
	$_SESSION["fecha1"]=$_REQUEST["fecha1"];
	$_SESSION["fecha2"]=$_REQUEST["fecha2"];
}
if (isset($_REQUEST["cancelaFiltro"])) {
	unset($_SESSION["fecha1"]);
	unset($_SESSION["fecha2"]);
}

if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"]; 
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]:(isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);
	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]:(isset($paginacion)? (int)$paginacion["PAG_TAM"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;
	unset($_SESSION["paginacion"]);

	$conexion= crearConexionBD();
	if (isset($_SESSION["fecha1"]) && isset($_SESSION["fecha2"])) {
		
		$fecha1=getFechaFormateada($_SESSION["fecha1"]);
		$fecha2=getFechaFormateada($_SESSION["fecha2"]);
		
		$query = "SELECT IDVENTAS, FECHAVENTA, TOTAL, IDEMPLEADO, IDCLIENTE FROM VENTAS WHERE (FECHAVENTA>='".$fecha1."' AND FECHAVENTA<'".$fecha2."'  ) ORDER BY IDVENTAS DESC";
		
	}
	else
	$query = "SELECT IDVENTAS, FECHAVENTA, TOTAL, IDEMPLEADO, IDCLIENTE FROM VENTAS ORDER BY IDVENTAS DESC";

	$total_registros = total_consulta($conexion,$query);
	$total_paginas = (int)($total_registros/$pag_tam);
	if($total_registros % $pag_tam>0) $total_paginas++;
	if($pagina_seleccionada >$total_paginas) $pagina_seleccionada=$total_paginas;

	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	
	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ventas de Copycampus</title>
</head>
<body>
<?php include_once("header.php"); 

?>
<?php 

	if (isset($_SESSION["clienteNoValido"])) {
		$clienteNoValido=$_SESSION["clienteNoValido"];
		unset($_SESSION["clienteNoValido"]);
		echo $clienteNoValido;
	}
	if (isset($_SESSION["detalles"])){
		
		
		$IdVenDet=$_SESSION["detalles"];
		$formularioDet=$IdVenDet; // AÑADIDO POSTERIORMENTE PARA CAMBIAR EL COLOR DE LA TABLA SIN NECESIDAD DE TOCAR MAS CODIGO
		$detalles=consultarDetalleVenta($conexion,$IdVenDet);

		unset($_SESSION["detalles"]);
	}
	if (isset($_SESSION["formularioDet"])) {
		$formularioDet=$_SESSION["formularioDet"];
		unset($_SESSION["formularioDet"]);
	}
	if(isset($_SESSION["erroresDet"])){
		$erroresDet=$_SESSION["erroresDet"];
		unset($_SESSION["erroresDet"]);
	}
	
?>
<main>
	<nav>
		<div id="enlaces">
			<?php 
				for($pagina = 1; $pagina <=$total_paginas; $pagina++)
					if( $pagina == $pagina_seleccionada){ ?>
					<span class="current"><?php echo $pagina; ?></span>
				<?php } else { ?>
						<a href="consultarVentas.php?PAG_NUM=<?php echo $pagina; ?>$PAG_TAM<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
				<?php } ?>	

		</div>
		

		<form id="formulario" method="get" action="consultarVentas.php">
			<input id="PAG_NUM" type="hidden" name="PAG_NUM" value="<?php echo $pagina_seleccionada ?>"/>
			Mostrando
			<input id="PAG_TAM" type="number" name="PAG_TAM" min="1" max="<?php echo $total_registros ?>" value="<?php echo $pag_tam ?>" autofocus="autofocus"/>
			entradas de <?php echo $total_registros ?>
			<input type="submit" name="Cambiar">

			</form>
			<div id="filtro">

		<form action="consultarVentas.php" method="post" id="filtroFechas" >
		
		<input type="date" name="fecha1" required="" title="fecha minima">
		<input type="date" name="fecha2" required="" title="fecha máxima (no entra)">
			
		<button type="submit" class="botonExcluido"> Filtrar</button>
		
		</form>
		<form action="consultarVentas.php" method="post" id="cancelaFiltro">
		<button type="submit" class="botonExcluido" name="cancelaFiltro">Cancelar</button>
			
		</form>
			

		</div>
		<div id="InsertarVentas">
		<form action="accionInsertarVentas.php">

			<input type="text" name="nickCliente" placeholder="Inserte, si procede, el usuario del cliente" maxlength="50" size="40">
			<button id="insertarVenta" class="botonExcluido" name="insertarVenta" type="submit">Nueva Venta</button>
		</form>
		</div><br>
	</nav>



	<?php
	if (isset($erroresDet)) {
		echo "<div id='erroresDetalles'>";
		foreach ($erroresDet as $error) {
			echo $error."<br>";
		}
		echo "</div>";
	}

	foreach ($filas as $fila) { 
		$hoy= ventaHoy($conexion,$fila["IDVENTAS"]);
		?>
	<br>
	<div class="col-10">
		<article id="venta" class="col-3">
			<form method="post" action="controladorVentas.php">
				<div class="filaVenta" >
						<div class="datos_venta">
							<input type="hidden" name="IDVENTAS" value="<?php echo  $fila['IDVENTAS'];  ?>" >
							<input type="hidden" name="IDEMPLEADO" value="<?php echo $fila['IDEMPLEADO'] ?>">
							<input type="hidden" name="IDCLIENTE" value="<?php echo $fila['IDCLIENTE'] ?>">
							<input type="hidden" name="FECHAVENTA" value="<?php echo $fila['FECHAVENTA'] ?>">
							<input type="hidden" name="TOTAL" value="<?php echo $fila['TOTAL'] ?>">
						</div>
						<div id="tablaRedondeada" <?php if (isset($formularioDet) && $formularioDet==$fila['IDVENTAS'] ) {
							
						?> style="background-color: #a52a2a; font-weight: bolder;" <?php } ?>>
						<div id="datos_venta">
							<?php   $empl=consultarEmpleadoPorId($conexion,$fila["IDEMPLEADO"]);
							if(isset($fila['IDCLIENTE']) && $fila['IDCLIENTE']!="")
									
								$cli=consultarClientePorId($conexion,$fila["IDCLIENTE"]);
								
								else{
									$cli["NOMBRE"]="";
									$cli["APELLIDOS"]="DESCONOCIDO";
								}

								
							?>
							
							
							<?php echo "VENTA "."de ";?>
							<?php 
								if($fila["TOTAL"]<1 ){

							echo " 0".$fila['TOTAL']." € "; }
							else
								echo " ".$fila['TOTAL']." € "; 


							?>
							<?php echo " ".$fila['FECHAVENTA']."<br> ";?>
							<?php echo "Vendido por: ".$empl["NOMBRE"]." ".$empl["APELLIDOS"] ."<br>";?>
							<?php echo "Vendido a: ".$cli["NOMBRE"]. " ". $cli["APELLIDOS"]."<br>";?>
							
							
							
							</div>
						

						<div id="botonesVenta">
						<?php if ($hoy=="true") { ?>
							<button id="borrarVenta" name="borrarVenta" type="submit">Borrar</button>
							<button id="addDetalles" name="addDetalles" type="submit">Añadir Detalles</button>
							<?php } ?>
							<button id="verDetalles" name="verDetalles" type="submit">Ver Detalles</button>
							
							</div>
						</div>
					</div>
					
				</form>
			</article>

			


				<?php 
				if(isset($IdVenDet) && $fila['IDVENTAS']==$IdVenDet){
					echo "<div id='DetallesVenta' class='col-5'>";
					
				foreach ($detalles as $detalle){
					echo "<div id='DatosDetallesVenta' class='col-8'> ";
					$catalogo=getCatalogoPorId($conexion,$detalle["IDCATALOGO"]);
					if($detalle["PRECIOVENTA"]<1)
					echo $catalogo["NOMBRE"]. ": ".$detalle["CANTIDAD"] ."x0".$detalle["PRECIOVENTA"]. "€ ";
					else
						echo $catalogo["NOMBRE"]. ": ".$detalle["CANTIDAD"] ."x".$detalle["PRECIOVENTA"]. "€ ";
					echo "</div>";
					?>
					<div id="accionDetalleVenta" >
						<form action="controladorVentas.php" method="post" >
							<input type="hidden" name="idDetalleVenta" value="<?php echo $detalle['IDDETALLEVENTA']?>">
							<input type="hidden" name="idVenta" value="<?php echo $detalle['IDVENTAS']?>">
							<?php if ($hoy=="true") { ?>
							
							<button class="botonEliminarDetalle"name="EliminarDetalle" id="EliminarDetalle" >Eliminar </button>
							
							<?php } ?>
						</form>
						</div>
						<br>

					
					


			<?php
			
				}
				echo "</div>";		



			}
			else if(isset($formularioDet) &&  $fila['IDVENTAS']==$formularioDet){
				$catalogos=consultar_catalogo($conexion);
				?>
				
				<form action="accionInsertarDetVenta.php" method="post" class="col-5" id="insertDetVenta">
				<div id="tablaRedondeadaForm">
					<input type="hidden" name="IDVENTAS" value="<?php echo  $fila['IDVENTAS'] ?>">
					<select name="IDCATALOGO">
						<option value="none">Selecciona un producto</option>
						<?php
						foreach ($catalogos as $catalogo) {
							echo "<option value=".$catalogo["IDCATALOGO"].">".$catalogo["NOMBRE"]."</option>" ;
						}
						?>
					</select>
					<br><input size="100"  type="number" name="CANTIDAD" placeholder="Cantidad Deseada" min="1" /><br>
					<button type="submit" name="confirmarDet">Confirmar</button>
					<button type="submit" name="cancelar">Cancelar</button>
					</div>
				</form>


				<?php

			}
					
			?>
				

			
		</div>
	<?php	}
	 ?>

	</main>
	<?php include_once("footer.php"); ?>

	</body>
	</html>

	<?php
	cerrarConexionBD($conexion);
	}
	?>