<?php
    session_start();

    if(!isset($_SESSION["loginEmp"])){
    	$_SESSION["inicia"]="Debes iniciar sesión como empleado para acceder a esa funcionalidad.";
	header("location: Pagina inicio.php");
}
else{

    // Miramos si en session esta la variable formulario, y si no esta iniciamos el formulario a los valores por defecto
    if (!isset($_SESSION['formularioCat'])) {
        $formularioCat['Nombre'] = "";
		$formularioCat['Descripcion'] = "";        
		$formularioCat['Precio'] = "";
        $formularioCat['IVA'] = "";
        $formularioCat['Stock'] = "";
        $formularioCat['StockMinimo'] = "";
        $formularioCat['TipoProducto']="";
        $formularioCat['TipoCatalogo']="";

        $_SESSION['formularioCat'] = $formularioCat;
    }
    // Si ya existían valores, los cogemos para inicializar el formulario
    else
        $formularioCat = $_SESSION['formularioCat'];
            
    // Recogemos los errores en caso de que los haya 
    if (isset($_SESSION["erroresCat"]))
        $erroresCat = $_SESSION["erroresCat"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Copycampus: Alta catálogo</title>
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
//$(document).ready(function(){
//    $("#Servicio").click(function(){
  //      $("#IVA,#Stock,#StockMinimo").hide(1000);
   // });

   // $("#Producto").click(function(){
    //    $("#IVA,#Stock,#StockMinimo").show(1000);
   // });
//});
</script>
<script> 
$(document).ready(function(){
    $("#Servicio").click(function(){
        $("#DatosdeProducto").slideUp("slow");
        });
    $("#Producto").click(function(){
        $("#DatosdeProducto").slideDown("slow");
        });
    });

</script> 

</head>

<body>
	<?php include_once("header.php"); ?>
	   <?php 
    
    // Si hay errores los mostramos 
    if(isset($erroresCat)){
        echo "<div id= \"div_errores\" class= \"error\">";
        echo  "<h4> Errores en el formulario </h4> <br>" ;
        foreach ($erroresCat as $error) {
            echo $error ."<br>";
            
        }
        echo "</div>";
    }
    ?>
    
	<form  id="form1" method="post" action="accion_alta_catalogo.php" novalidate>
	 <h1><strong>REGISTRO DE NUEVOS CATÁLOGOS</strong></h1>
		<p>
			<i>Los campos obligatorios están marcados con </i><em>*</em>
		</p>

        
				<input type="radio"  id="Producto" name="TipoCatalogo" value="Producto" checked> Producto
				<input type="radio"  id="Servicio" name="TipoCatalogo" value="Servicio" > Servicio
		<fieldset id="">
			<legend>Datos catálogo</legend>
			<label for="Nombre">Nombre:<em>*</em> </label><input type="text" id="Nombre" name="Nombre" required="" size=40 ><br>
			<label for="Descripcion">Descripción:<em>*</em></label> <input type="text" id="Descripcion" name="Descripcion" size=150 ><br>
			<label for="Precio">Precio:<em>*</em></label> <input type="Float" id="Precio" name="Precio" required min="0" ><br>
			<label for="IVA" id="IVA">IVA:<em>*</em></label> <input type="Float" id="IVA" name="IVA"  placeholder="[0,0 - 1,0]" required min="0" ><br>
			<div class=DatosdeProducto id="DatosdeProducto">
			<label for="Stock" id="Stock">Stock:<em>*</em></label> <input type="number" id="Stock" name="Stock" min="0" ><br>
			<label for="StockMinimo" id="StockMinimo">Stock Minimo:<em>*</em></label> <input type="number" id="StockMinimo" name="StockMinimo" min="0"><br>
			</div>
			<label>Tipo Producto: </label> 
				<label><input type="radio"  id="Papeleria" name="TipoProducto" value="Papeleria" checked> Papelería</label>
				<label><input type="radio"  name="TipoProducto" value="Electronica" >Electrónica</label>
				<label><input type="radio"  name="TipoProducto" value="Otros" >Otros</label><br>

			
				
			

		</fieldset>

<br>
		
		<input type="submit" value="Enviar">
         
		
	</form>

    <form id="form1"action="Pagina inicio.php"> 
            <button type="submit" class="botonExcluido" name="cancelarModCliente">Cancelar</button>
    </form>

    

	<?php include_once("footer.php");  } ?>
</body>

</html>