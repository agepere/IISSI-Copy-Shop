<?php
session_start();

if (isset($_SESSION["inicia"])) {
  $inicia=$_SESSION["inicia"];
  unset($_SESSION["inicia"]);
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Copycampus</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

</head>
<body>
<?php include_once("header.php"); ?>




<h1 id="Bienvenido">¡Bienvenid@ a copycampus! </h1>
<?php
if (isset($inicia)) {
  
 echo "<div id='inicia' class='col-10'>". $inicia."</div>";
}

?>

<?php
if (isset($_SESSION["errorLoginCliente"])) {
  echo "<div id='ErrorCliente' class='col-10'>";
  echo "<p> Fallo al iniciar sesión. El usuario o la contraseña son incorrectos. </p>";
  echo "</div>";
  $_SESSION["errorLoginCliente"]=null;
}
?>



<div class="col-10">


                  

<?php

if (!isset($_SESSION["loginEmp"])&& !isset($_SESSION["loginCliente"])) {
  
?>
<!-- LOGIN CLIENTES -->
<div id="IniciaSesionCliente" class="col-10" >

<button id="BotonIniciaSesion" value="Iniciar Sesion"  onclick="apareceFormIniciarSesionCliente(); this.style.visibility='hidden'">Iniciar Sesion</button>
<a href="formularioClientes.php"><button>Registrate</button></a>
</div>
<div class="col-10">
<div id="logCliente" style='display: none'>

<p>¿Eres un cliente? Inicia sesión introduciendo tus datos en: </p>
<form action="loginCliente.php" method="post">
<label for="Nickname">Usuario:</label><input type="text" name="Nickname" id="Nickname" required="">
<label for="Password">Contraseña:</label><input type="Password" name="Password" id="Password" required="">
<input class="botonIniciaSesiconCliente" type="submit" name="submit" value="Inicia Sesión" >

</form>
</div>
</div>

<!--DEPURANDO-->

<?php
}
else{
  if(isset($_SESSION["loginEmp"])){
 
//EMPLEADO LOGEADO
  ?>

<div id="EmpleadoLogeado" class="col-10">

<h2 id="mensajeBienvenidaEmpleado"></h2>
<form action="loginEmp.php">

<a href="consultarEmpleados.php">Listado de empleados</a> 
<a href="consultarCompras.php">Detalles de compras</a>
<a href="consultarVentas.php">Detalles de ventas</a>
<a href="formularioCatalogo.php">Formulario catalogo</a><br> <br>
<input class="botonLogout" type="submit" name="salirEmp" value="Log Out" /><br><br>

</form>

</div>



 <?php 
    }
    //CLIENTE LOGEADO
  if(isset($_SESSION["loginCliente"])){ 
?>

 <div  class="col-10"> 
 <div id="ClienteLogeado">
 
<h2 id="mensajeBienvenidaCliente" ></h2> 
<a id="ModTuPerfil" href="formularioModificaCliente.php" ><button>Modifica tu perfil</button></a>
<form id="logeaCliente" action="loginCliente.php" >
<input class="botonLogout" type="submit" name="salirCliente" value="Log Out" />
</form>
</div>
</div>







<?php

  }


  }
?>
</div>




<br>
<div class="col-10">
<div class="col-5">
<iframe id="videoYT"  width="500px" height="300px" src="https://www.youtube.com/embed/6KSvZuKGy84" frameborder="0" allowfullscreen></iframe>
</div>


<nav  class="col-5">
<div id="streetView">
 <h2>Vista de calle:</h2>
  <div id="street-view" style="width:500px; height:300px;">
  </div>
  </div>
  </nav>
  
</div>
    <script>
var panorama;
function initialize() {
  panorama = new google.maps.StreetViewPanorama(
      document.getElementById('street-view'),
      {
        position: {lat: 36.6838517, lng: -6.1207195},
        pov: {heading: 256, pitch:0},
        zoom: 2.5
      });
}

    </script>
    <script async defer
         src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6NFsXHKo6QGhCDoET9e7Ap1m9g16pgtk&callback=initialize">
    </script>

     <script type="text/javascript">
  var msj; 
  var fecha = new Date();

  if      (fecha.getHours() < 7)  { msj = "Buenas noches, <?php echo $_SESSION["loginCliente"]?>.";}
  else if (fecha.getHours() < 12) { msj = "Buenos días, <?php echo $_SESSION["loginCliente"]?>.";}
  else if (fecha.getHours() < 21) { msj = "Buenas tardes, <?php echo $_SESSION["loginCliente"]?>.";}
  else                                          { msj = "Buenas noches, <?php echo $_SESSION["loginCliente"]?>.";}

 document.getElementById("mensajeBienvenidaCliente").innerHTML    = msj;
</script>
    <script type="text/javascript">
  var msj2;
  var fecha = new Date();

  if      (fecha.getHours() < 7)  { msj2 = "Buenas noches, <?php echo $_SESSION["loginEmp"]?>.";}
  else if (fecha.getHours() < 12) { msj2 = "Buenos días, <?php echo $_SESSION["loginEmp"]?>.";}
  else if (fecha.getHours() < 21) { msj2 = "Buenas tardes, <?php echo $_SESSION["loginEmp"]?>.";}
  else                                          { msj2 = "Buenas noches, <?php echo $_SESSION["loginEmp"]?>.";}

 document.getElementById("mensajeBienvenidaEmpleado").innerHTML    = msj2;
</script>

<script type="text/javascript">
function apareceFormIniciarSesionCliente() {
  document.getElementById('logCliente').style.display = 'block';
  document.getElementById('IniciaSesionCliente').style.display = 'none';
  
}
</script>






<?php include_once("footer.php"); ?>

</body>
</html>