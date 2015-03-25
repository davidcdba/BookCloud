 <?PHP
session_start();
include_once('funciones_api.php');
include_once('funciones_plantilla.php');
include_once('sql/funciones_BBDD.php');

$client=iniciarAPI('http://localhost/libros/mislibros.php');
//autentificacion

	//inicializacion de variables de API
	$client->setAccessToken($_SESSION['accessToken']);
	$service = new Google_DriveService($client);



//borra el archivo cuando se pide para borrar
if(isset($_GET['borrar'])){
	 $fileId=$_GET['borrar'];
	
	deleteFile($service, $fileId);

}

//Añade el enlace al la bbdd
if(isset($_POST['Compartir'])){
	$titulo=$_POST['titulo'];
	$tipo=$_POST['tipo'];
	$enlace=$_POST['enlace'];
	$idOriginal=$_POST['idOriginal'];
	insertarLibro($titulo,$enlace,$tipo,$idOriginal);
}
//dejar de compartir
if(isset($_POST['NoCompartir'])){
	$titulo=$_POST['titulo'];
	$tipo=$_POST['tipo'];
	$enlace=$_POST['enlace'];
	eliminarLibro($titulo,$enlace,$tipo);
}

//sube los nuevos archivos a la cuenta
if(isset($_POST['subir'])){
	//subiendolo a un temporal
	$tamano = $_FILES["archivo"]['size'];
	$tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
	//$prefijo = substr(md5(uniqid(rand())),0,6);

	if ($archivo != "") {
	// guardamos el archivo a la carpeta files
		$destino =  "files/".$archivo;
		if (copy($_FILES['archivo']['tmp_name'],$destino)) {
		    $status = "Archivo subido: <b>".$archivo."</b>";
			//lo sube a drive
			subeArchivo($client);
			unlink($destino);
		} else {
		    $status = "Error al subir el archivo";
		}
		} else {
			$status = "Error al subir archivo";
		}
	}




//------------------------------------------------------------------------------------------
//Parte grafica y visible
printHead("mislibros.php");


//empesamos a listar los archivos

//recuperamos el listado
$vector=retrieveAllFiles($service);

print "<table><tr><td width='70%'><table style='margin:0px'><tr><th>Nombre</th><th>Acciones</th></tr>";

foreach ($vector as $file) {
	
	if(compruebaTipo($file)==1){
		//combierte la url a un formato legible
		$enlace=arreglaURL($file->getDownloadUrl());
		print "<form action='mislibros.php' method='POST'><tr>";
		print "<td>" . $file->getTitle() ."</td>";
		 
		print "<td><a href='" . $enlace."'><img alt='Descargar' title='Descargar' src='imagenes/icono.png' width='20' /></a>";
		print "<a href='mislibros.php?borrar=". $file->getId() ."'><img alt='eliminar' title='Eliminar' src='imagenes/pocket-killbox_icon.png' width='20' /></a>";

		//campos ocultos para poder compartir
		print "<input type='hidden' name='idOriginal' value='".$file->getId() ."'/>";
		print "<input type='hidden' name='titulo' value='".$file->getTitle() ."'/>";
		print "<input type='hidden' name='enlace' value='".$enlace ."'/>";
		print "<input type='hidden' name='tipo' value='".$file->getMimeType() ."'/>";

		//colorea el boton dependiendo de si ya esta compartido o no

		if(compruebaSubido($file->getTitle()) >=1){
			print"<input class='inputNoCompartido' type='submit' name=NoCompartir value='Dejar de Compartir' />";

		}else{
		
			print"<input class='inputCompartido' type='submit' name=Compartir value=Compartir />";
		}

		print "</td>";
		print "</tr></form>";
	}

}
print "</table></td><td width='30%'>";
?>
<h3>Subir libro</h3>
<form method="POST" action="mislibros.php" enctype="multipart/form-data">
	<input type="file" name='archivo' /><br>
	<input type="submit" name=subir value=subir />
</form>
 <td></tr></table>       
 <?PHP
//cierre del codigo HTML5
printfoot();
?>
