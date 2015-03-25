<?php

function conectar(){
$pass="password";
$usuario="User";
$bd="libros";
$ip="localhost";
if(!($cn = (mysql_connect("$ip","$usuario","$pass")))){
echo mysql_error();
}
  
if(!(mysql_select_db("$bd",$cn))){
echo mysql_error();
} 
return $cn;
} 
?>

