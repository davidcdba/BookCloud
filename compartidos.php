 <?PHP
session_start();
include_once('sql/funciones_BBDD.php');
include_once('funciones_plantilla.php');
printHead("compartidos.php");
print "<h3>Libros compartidos Gratuitamente</h3>";
//cargamo los libros de la BBDD
$libros=lista_libros();
print "<table><tr><td width='70%'><table style='margin:0px'><tr><th>Nombre</th><th>Acciones</th></tr>";
//metodo de seguridad por si la bbdd no devolviera libros
if($libros){
	foreach ($libros as $libro) {
	 print "<tr>";
		print "<td>" . $libro['titulo'] ."</td>";
		
			print "<td><a href='" . $libro['enlace']."'><img alt='Descargar' title='Descargar' src='imagenes/icono.png' width='20' /></a>";
			print "</td>"; 
			print "</tr>";
	}
}else{
	print "<td colspan=2>No hay libros disponibles</td>";

}
print "</table></td><td width='30%'>";
print "</table></td><td width='30%'>";
?>
       <img src=imagenes/nube.png alt=imagenNube />     
 <td></tr></table>  
 <?PHP
printfoot();
?>
