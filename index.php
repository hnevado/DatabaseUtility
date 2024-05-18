<?php
require 'DataBaseUtility.php';

//Datos conexión
$host = 'localhost';
$db = 'laravel10_livewire';
$dbUser = 'root';
$password = '';


//Inicializo conexión
$gestorBD = new DatabaseUtility($host,$db,$dbUser,$password);

//Querys para testing

$sql_select="SELECT * FROM usfers";

//Fin Querys para testing

//Llamando a los métodos de la clase DataBaseUtility
$result = $gestorBD->lanzarQuery(sql:$sql_select,numRows:false);
var_dump($result);


?>