<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Copycampus: Conócenos</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
<?php include_once("header.php"); ?>

<div id="contacto">
<h3>Datos de contacto</h3>
<ol>
	<li><strong>Dirección: </strong>Avda. Ronda de los Viñedos s/n · Jerez de la Frontera</li>
	<li><strong> Coordenadas GPS: </strong>36.6836445, -6.120659700000033</li>
	<li><strong>Teléfono: </strong>956 32 20 44</li>
	<li><strong>Email: </strong>copycampuslavid@gmail.com</li>
</ol>

</div>

<nav id="mapa">
<h2>Situación de la copistería:</h2>
<div id="googleMap" style="width:800px;height:400px;"></div>

<script type="text/javascript">
function myMap() {
var mapProp= {
    center:new google.maps.LatLng(36.6838517, -6.1207195),
    zoom:19,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADTUwmYTUoJzWGlZVLjgsVzcfnyxYJYwE&callback=myMap"></script>
</nav>

<?php include_once("footer.php"); ?>
</body>

</html>