<?php
include 'Conexion.php';

    $Password=$_POST['CONTRASENA'];
    $Correo=$_POST['CORREO'];
    $Direccion=$_POST['DIRECCION'];
    $Fecha_Nacimiento=$_POST['FECHA_NACIMIENTO'];
    $Nombres=$_POST['NOMBRES'];
    $PrimerAP=$_POST['PRIMER_APELLIDO'];
    $SegundoAp=$_POST['SEGUNDO_APELLIDO'];
    $Telefono=$_POST['TELEFONO'];
    $id_usu=$_POST['ID_CLIENTE'];
    $TipoUsu=$_POST['ID_USUARIO'];

 // SE EJECUTA LA PRIMER INSERCIÓN A LA TABLA NO. 1
 $insertar=("INSERT INTO cliente (
ID_CLIENTE,NOMBRES,
 PRIMER_APELLIDO,SEGUNDO_APELLIDO,
 TELEFONO,CORREO,CONTRASEÑA,
 DIRECCION,FECHA_NACIMIENTO,ID_USUARIO	
 ) 
 VALUES ('".$id_usu."','".$Nombres."','".$PrimerAP."','".$SegundoAp."',
 '".$Telefono."','".$Correo."','".$password."'
 ,'".$Direccion."'
 '".$Fecha_Nacimiento."','".$TipoUsu."')"); 
 ("INSERT INTO usuario 
 (ID_USUARIO,ID_TIPO_USU) VALUES ('".$id_usu."','".$TipoUsu."')");
$result=mysqli_query($conexion,$insertar);
 if ($resul2t=true)// SI LA QUERY ANTERIOR SE EJECUTA CON EXITO, SE EJECUTA LA INSERCIÓN A LA TABLA 2
 {
//EJECUTAR CONSULTA
echo "<center><strong><h4>¡INSERCIÓN EXITOSA!<BR><a href='Menu.php'>CLICK PARA VERIFICAR</a></strong></h4></center>";
 }
 else// MENSAJE DE CONFIRMACIÓN DE INSERCIÓN
 {
    echo("location:Menu.php"); 
 }
 mysqli_close($conexion);
 ?>

