<?php
session_start();
include_once('funciones.php');
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$client = new Google_Client();
// Get your credentials from the APIs Console
$client->setClientId('486485021619.apps.googleusercontent.com');
$client->setClientSecret('_Vog54Zff_Gh6flNn1ZlrsUs');
//La comento porque trabajo en local
//$client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
$client->setRedirectUri('http://localhost/quickstart.php');
$client->setScopes(array(
  'https://www.googleapis.com/auth/drive',
  'https://www.googleapis.com/auth/userinfo.email',
  'https://www.googleapis.com/auth/userinfo.profile',

'https://www.googleapis.com/auth/drive.readonly',
'https://www.googleapis.com/auth/drive.file',
'https://www.googleapis.com/auth/drive.metadata.readonly',
'https://www.googleapis.com/auth/drive.appdata',
'https://www.googleapis.com/auth/drive.apps.readonly'));
//autentificacion
$client->setUseObjects(true);
if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
	//$client->setAccessToken($_SESSION['accessToken']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $token=$client->authenticate();
	$client->setAccessToken($token);
}
$client->setAccessToken($_SESSION['accessToken']);
$service = new Google_DriveService($client);
// initialize the drive service with the client.



// $result = array();
  //$files = $service->files->listFiles();
 // $result = array_merge($result, $files->getItems());
 //print_r($result[0]->getItems());



$vector=retrieveAllFiles($service);
//print_r($vector[0]->getTitle());
print $vector[0]->getDownloadUrl();// este comando obtiene el enlace de descarga

foreach ($vector as $file) {

    print "Title: " . $file->getTitle() ."<br/>";
    print "Description: " . $file->getDescription()."<br/>";
    print "MIME type: " . $file->getMimeType()."<br/>"; 
	print "<a href='" . $file->getDownloadUrl() ."'>Descargar</a><br>";


}
//-----------------
/*
$service = new Google_DriveService($client);
$app->get('/svc', function() use ($app, $client, $service) {
  checkUserAuthentication($app);
  checkRequiredQueryParams($app, array('file_id'));
  $fileId = $app->request()->get('file_id');
  try {
    // Retrieve metadata for the file specified by $fileId.
    $file = $service->files->get($fileId);

    // Get the contents of the file.
    $request = new Google_HttpRequest($file->downloadUrl);
    $response = $client->getIo()->authenticatedRequest($request);
    $file->content = $response->getResponseBody();

    renderJson($app, $file);
  } catch (Exception $ex) {
    renderEx($app, $ex);
  }
});
*/



//lista archivos del server
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
    header('location:'.$url);exit;
}
include 'index.phtml';
