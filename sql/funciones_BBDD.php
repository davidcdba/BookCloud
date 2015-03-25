<?PHP
include_once('conexion.php');

//añade el enlace del libro a la bbdd
function insertarLibro($titulo,$enlace,$tipo,$idOriginal)
{
	  
	
	  
	    $q = "INSERT INTO libros (titulo, tipo,enlace,idOriginal) values ('".$titulo."', '".$tipo."','".$enlace."','".$idOriginal."')";
	
	  
	$cn=conectar();
	if(!(mysql_query($q, $cn))){
	  
	    echo ("Problema con la consulta SQL,en la funcion: archivo funciones_insertar->funcion(insertar_usuario");
	    echo "<br/>";
	    echo    mysql_error();
	    echo "<br/>Sentencia ejecutada: $q";
	    return false;
	}else{
	  
	    
	    return true;
	    }
	  
	  
} 
//elimina el enlace del libro a la bbdd
function eliminarLibro($titulo,$enlace,$tipo)
{
	$q = "delete from libros where titulo='$titulo'";
	$cn=conectar();
	if(!(mysql_query($q, $cn))){
	  
	    echo ("Problema con la consulta SQL,en la funcion: archivo funciones_insertar->funcion(insertar_usuario");
	    echo "<br/>";
	    echo    mysql_error();
	    echo "<br/>Sentencia ejecutada: $q";
	    return false;
	}else{
	  
	    
	    return true;
	    }
	  
	  
} 
//comprueba si el enlace del usuario esta ya presente en la BBDD
function compruebaSubido($enlace){
 $cn = conectar();
$id=0;
    $q="SELECT idLibro FROM libros where titulo='$enlace'";
    //echo $q; 
	if(mysql_query($q, $cn) ){ 
   	$r = mysql_query($q, $cn);  
   	 $row = mysql_fetch_row($r);
   	 $id=$row[0];
	}
    return $id;  


}
//lista todos los enlaces hasta el momento
function lista_libros(){
$q = "SELECT * FROM libros order by titulo";
    $cn=conectar();
   $r = mysql_query($q, $cn) ;    

   
     while($row = mysql_fetch_array($r)){
	$fila[] =$row;
	}
	if($fila){
   	return $fila;
	}else{
	return false;
	} 

}
//lista todos los enlaces hasta el momento con un filtro
function lista_libros_busqueda($busqueda){
$q = "SELECT * FROM libros where titulo like '%$busqueda%' order by titulo";

    $cn=conectar();
   $r = mysql_query($q, $cn) ;    

	
	while($row = mysql_fetch_array($r)){
		$fila[] =$row;
	}
	
	if(isset($fila) && $fila){
		return $fila;
	}else{
		return false;
	} 
	
}
?>
