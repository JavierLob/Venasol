<?php

########## Google Settings.. Client ID, Client Secret from https://cloud.google.com/console #############
$google_client_id 		= '145882205996-igvkgql18ejjflh8vmh8uuv16mkbemff.apps.googleusercontent.com';
$google_client_secret 	= 'JCv6Foxxa_QlSjTPmaJsQXTa';
$google_redirect_url 	= 'http://localhost:8080/venasol/vista/'; //path to your script
$google_developer_key 	= '145882205996-igvkgql18ejjflh8vmh8uuv16mkbemff.apps.googleusercontent.com';

//include google api files
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';
require_once '../clases/clase_usuario.php';

//start session
session_start();

$gClient = new Google_Client();
$lobjUsuario = new clsUsuario();
$gClient->setApplicationName('Acceso a VENASOL C.A.');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);

$google_oauthV2 = new Google_Oauth2Service($gClient);

//If user wish to log out, we just unset Session variable
if (isset($_REQUEST['reset'])) 
{
  unset($_SESSION['token']);
  $gClient->revokeToken();
  header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
}

//If code is empty, redirect user to google authentication page for code.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.
if (isset($_GET['code'])) 
{ 
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	return;
}


if (isset($_SESSION['token'])) 
{ 
	$gClient->setAccessToken($_SESSION['token']);
}


if ($gClient->getAccessToken()) 
{
	  //For logged in user, get details from google using access token
	  $user 				= $google_oauthV2->userinfo->get();
	  $user_id 				= $user['id'];
	  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
	  $profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
	  $personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
	  $_SESSION['token'] 	= $gClient->getAccessToken();
}
else 
{
	//For Guest user, get google login url
	$authUrl = $gClient->createAuthUrl();
}

//HTML page start
/*echo '<!DOCTYPE HTML><html>';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo '<title>Login with Google</title>';
echo '</head>';
echo '<body>';
echo '<h1>Login with Google</h1>';
*/
if(isset($authUrl)) //user is not logged in, show login button
{
	//echo '<a class="login" href="'.$authUrl.'"><img src="images/google-login-button.png" /></a>';
} 
else // user logged in 
{
   /* connect to database using mysqli */
	$lobjUsuario->set_IdUsuarioGoogle($user_id);		
	$lobjUsuario->set_Usuario($user_name);		
	$lobjUsuario->set_Correo($email);		
	$lobjUsuario->set_Profile($profile_url);		
	$lobjUsuario->set_ProfileImage($profile_image_url);		
   	$user_exist=$lobjUsuario->consultar_usuario_google();
	
	/*if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}*/
	
	//compare user id in our database

	if($user_exist)
	{
		echo 'Bienvenido de regreso '.$user_name.'!';
	}else{ 
		//user is new
   		$result=$lobjUsuario->registrar_usuario_google();
	}

	
	
	//header("location: ../vista/?modulo=inicio");
}
 
//echo '</body></html>';
?>

