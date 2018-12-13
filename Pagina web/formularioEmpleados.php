<?php
    session_start();

    if ($_SESSION["loginEmp"]!='admin') {
        header("location: Pagina inicio.php");
    }
    else{

    // Miramos si en session esta la variable formulario, y si no esta iniciamos el formulario a los valores por defecto
    if (!isset($_SESSION['formularioEmp'])) {
        $formularioEmp['DNI'] = "";
        $formularioEmp['Nombre'] = "";
        $formularioEmp['Apellidos'] = "";
        $formularioEmp['Email'] = "";
        $formularioEmp['Edad'] = "";
        $formularioEmp['Telefono'] = "";
         $formularioEmp['Direccion'] = "";
        $formularioEmp['FechaInicio'] = "";
        $formularioEmp['FechaFin'] = "";
        $formularioEmp['Nickname'] = "";
        $formularioEmp['Password'] = "";
        $formularioEmp['ConfirmarPassword'] = "";
    
        $_SESSION['formularioEmp'] = $formularioEmp;
    }
    // Si ya existían valores, los cogemos para inicializar el formulario
    else
        $formularioEmp = $_SESSION['formularioEmp'];
            
    // Recogemos los errores en caso de que los haya 
    if (isset($_SESSION["erroresEmp"]))
        $erroresEmp = $_SESSION["erroresEmp"];


?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Copycampus: Alta empleados</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
    <?php include_once("header.php"); ?>


    <?php 
    
    // Si hay errores los mostramos 
    if(isset($erroresEmp)){
        echo "<div id= \"div_errores\" class= \"error\">";
        echo  "<h4> Errores en el formulario </h4> <br>" ;
        foreach ($erroresEmp as $error) {
            echo $error ."<br>";
            
        }
        echo "</div>";

    }
    
    /////////////////////// FIN DE EJERCICIO 2
    ?>

      <form method="get" action="accion_alta_empleado.php" id="formularioEmp">
      <h1><strong>REGISTRO DE NUEVOS EMPLEADOS</strong></h1>
    <p>
       <i>Los campos obligatorios están marcados con </i><em>*</em>
    </p>
    	<fieldset id="personales"> 
    	<legend>
    	Datos personales
    	</legend>
    	<label class="col-1" for="Nombre"> Nombre: <em>*</em> </label>
    	<input id="Nombre" type="text" name="Nombre" size="40" value="<?php echo $formularioEmp["Nombre"]  ?>" required maxlength="50"><br>
    	
    	<label class="col-1"  for="Apellidos"> Apellidos: <em>*</em>  </label>
    	<input id="Apellidos" type="text" name="Apellidos" size="40" value="<?php echo $formularioEmp["Apellidos"]  ?>" required="" maxlength="50"><br>
    	
    	
         
        <label class="col-1"  for="Email">Email:<em>*</em></label>
        <input id="Email" type="text" name="Email" placeholder="usuario@dominio.extends" value="<?php echo $formularioEmp["Email"]  ?>" required="" maxlength="50" size="40"><br>
        
        <label class="col-1"  for="Direccion">Dirección:</label>
        <input id="Direccion" type="text" value="<?php echo $formularioEmp["Direccion"]  ?>" name="Direccion" maxlength="100" size="40"  /><br>

        <label  class="col-1" for="DNI"> DNI <em>*</em> </label>
        <input id="DNI" type="text" name="DNI" pattern="^[0-9]{8}[A-Z]"  placeholder="12345678X" title="Ocho dígitos seguidos de una letra mayúscula"  required maxlength="9">
        <br>

        <label class="col-1"  for="Edad">Edad:<em>*</em></label>
        <input id="Edad" type="number" name="Edad" min="16"  value="<?php echo $formularioEmp["Edad"]  ?>"/><br>  

        <label  class="col-1" for="Telefono">Teléfono:<em>*</em></label>
        <input id="Telefono" type="text" name="Telefono" pattern="^[0-9]{7,20}" maxlength="9" value="<?php echo $formularioEmp["Telefono"]  ?>"/><br>

       <label  class="col-1" for="FechaInicio"> Fecha de Inicio:<em>*</em></label>
        <input type="date" name="FechaInicio" id="FechaInicio"  value="<?php echo $formularioEmp["FechaInicio"]  ?>" required><br>

        <label class="col-1" for="FechaFin"> Fecha de Fin:</label>
        <input type="date" name="FechaFin" id="FechaFin" size="20"><br> 
        

    	</fieldset>
    	<fieldset id="datosusuario"> <legend>Datos usuario</legend>    
    	
    	<label class="col-1"  for="Nickname"> Usuario: </label>
    	<input  id="Nickname" type="text" name="Nickname" required maxlength="50"  value="<?php echo $formularioEmp["Nickname"]  ?>"/><br>
        
        <label class="col-1"  for="Password"> Password:<em>*</em> </label>
    	<input id="Password" type="password" name="Password" maxlength="50" required /><br>
    	
    	<label class="col-1"  for="ConfirmarPassword"> Confirmar Password: </label>
    	<input name="ConfirmarPassword" id="ConfirmarPassword" type="password" required><br>

    	
    	
        
    	</fieldset>
    <button type="submit" name="Enviar">Enviar</button>

    <?php include_once("footer.php"); ?>
</body>
</html>
<?php
}
?>