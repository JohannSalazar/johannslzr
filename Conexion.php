
<?php 
	
	$host = 'localhost';
	$user = 'root';
	$password = '';
	$db = 'myshop';

	$conexion = @mysqli_connect($host,$user,$password,$db);

	if(!$conexion){
		echo "Error en la conexión";
	}
    else{
		echo "conexión exitosa";
	}

?>