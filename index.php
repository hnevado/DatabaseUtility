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

$sql_select="SELECT * FROM users";
$sql_insert="INSERT users(name,email,password) VALUES('Testing','testing4@gmail.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')";
$sql_update="UPDATE users SET name='Test' WHERE id >= 10";
$sql_delete="DELETE FROM users WHERE id >= 10";

//Fin Querys para testing

//Llamando a los métodos de la clase DataBaseUtility
$result = $gestorBD->lanzarQuery(sql:$sql_select,numRows:true);
print_r($result);

$result = $gestorBD->lanzarQuery(sql:$sql_insert,numRows:false,tipo:"insertar");
var_dump($result);

$result = $gestorBD->lanzarQuery(sql:$sql_update,numRows:true,tipo:"actualizar");
var_dump($result);

$result = $gestorBD->lanzarQuery(sql:$sql_delete,numRows:true,tipo:"actualizar");
var_dump($result);
?>