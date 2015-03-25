<?PHP
//funciones para google drive
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

//funcion de google obtine todos los archivos del raiz
function retrieveAllFiles($service) {
  $result = array();
  $pageToken = NULL;

  do {
    try {
      $parameters = array();
      if ($pageToken) {
        $parameters['pageToken'] = $pageToken;
      }
      $files = $service->files->listFiles($parameters);

      $result = array_merge($result, $files->getItems());
      $pageToken = $files->getNextPageToken();
    } catch (Exception $e) {
      print "An error occurred: " . $e->getMessage();
      $pageToken = NULL;
    }
  } while ($pageToken);
  return $result;
}


/**
 * Download a file's content.
 *
 * @param apiDriveService $service Drive API service instance.
 * @param File $file Drive File instance.
 * @return String The file's content if successful, null otherwise.
 */
function downloadFile($service, $file) {
  $downloadUrl = $file->getDownloadUrl();
  if ($downloadUrl) {
    $request = new apiHttpRequest($downloadUrl, 'GET', null, null);
    $httpRequest = $service->getIo()->authenticatedRequest($request);
    if ($httpRequest->getResponseHttpCode() == 200) {
      return $httpRequest->getResponseBody();
    } else {
      // An error occurred.
      return null;
    }
  } else {
    // The file doesn't have any content stored on Drive.
    return null;
  }
}

/**
 * Permanently delete a file, skipping the trash.
 *
 * @param Google_DriveService $service Drive API service instance.
 * @param String $fileId ID of the file to delete.
 */
function deleteFile($service, $fileId) {
  try {
    $service->files->delete($fileId);
  } catch (Exception $e) {
    print "An error occurred: " . $e->getMessage();
  }
}
?>
