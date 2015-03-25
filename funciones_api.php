<?PHP
//funciones para el control de la api
//archivos nesesarios
include_once('funciones.php');
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';


// inicia el funcionamiento la API de drive, recive como parametro la url del sitio
function iniciarAPI($url){
	
	$client = new Google_Client();
	// Get your credentials from the APIs Console
	$client->setClientId('******************');
	$client->setClientSecret('******************');
	//La comento porque trabajo en local
	//$client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
	$client->setRedirectUri($url);
	//Permisos que solicita la aplicación
	$client->setScopes(array(
	  'https://www.googleapis.com/auth/drive',
	  'https://www.googleapis.com/auth/userinfo.email',
	  'https://www.googleapis.com/auth/userinfo.profile',

	'https://www.googleapis.com/auth/drive.readonly',
	'https://www.googleapis.com/auth/drive.file',
	'https://www.googleapis.com/auth/drive.metadata.readonly',
	'https://www.googleapis.com/auth/drive.appdata',
	'https://www.googleapis.com/auth/drive.apps.readonly'));
	$client->setUseObjects(true);
	if (isset($_GET['code'])) {
	    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
		//$client->setAccessToken($_SESSION['accessToken']);
	    header('location:'.$url);exit;
	} elseif (!isset($_SESSION['accessToken'])) {
	    $token=$client->authenticate();
		$client->setAccessToken($token);
	}
	return $client;


}
//Esta funcion me permite solamente listar aquellos archivos que se consideren libros
function compruebaTipo($file){
if($file->getMimeType()=="application/pdf"){return 1;}
if($file->getMimeType()=="application/vnd.google-apps.document"){return 1;}
if($file->getMimeType()=="application/vnd.google-apps.document"){return 1;}


return 0;

}
//por defecto google devuelve las url concaracteres de mas
function arreglaURL($string){

	$cadena=substr($string,0,-8);
	return $cadena;
}
function subeArchivo($client){
	$files= array();
	$dir = dir('files');
	while ($file = $dir->read()) {
	    if ($file != '.' && $file != '..') {
		$files[] = $file;
	    }
	}
	$dir->close();

	//sube un archivo
	if (!empty($_POST)) {
	    $client->setAccessToken($_SESSION['accessToken']);
	    $service = new Google_DriveService($client);
	    $finfo = finfo_open(FILEINFO_MIME_TYPE);
	    $file = new Google_DriveFile();
	    foreach ($files as $file_name) {
		$file_path = 'files/'.$file_name;
		$mime_type = finfo_file($finfo, $file_path);
		$file->setTitle($file_name);
		$file->setDescription('This is a '.$mime_type.' document');
		$file->setMimeType($mime_type);
		$service->files->insert(
		    $file,
		    array(
		        'data' => file_get_contents($file_path),
		        'mimeType' => $mime_type
		    )
		);
	    }
	    finfo_close($finfo);
	}



}

?>
