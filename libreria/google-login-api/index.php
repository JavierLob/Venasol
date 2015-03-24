<?php

########## Google Settings.. Client ID, Client Secret from https://cloud.google.com/console #############
$google_client_id 		= '145882205996-rmrh1fho17bmsavq0kmues8fcan45trr.apps.googleusercontent.com';
$google_client_secret 	= 'G08M-QLEJD05IfmUAx6J6Jib';
$google_redirect_url 	= 'http://localhost:8080/venasol/admin/admin/vista/intranet.php'; //path to your script
$google_developer_key 	= '145882205996-rmrh1fho17bmsavq0kmues8fcan45trr@developer.gserviceaccount.com';

########## MySql details (Replace with yours) #############
$db_username = "postgres"; //Database Username
$db_password = "123456"; //Database Password
$hostname = "localhost:5432"; //Mysql Hostname
$db_name = 'bd_venasol'; //Database Name
###################################################################

//include google api files
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';

//start session
session_start();

$gClient = new Google_Client();
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
	$pgsql = pg_connect("user=".$db_username." "."password=".$db_password." "."dbname=".$db_name);

	
	/*if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}*/
	
	//compare user id in our database
	$result=pg_query($pgsql,"SELECT COUNT(google_id) as usercount FROM tgoogle_users WHERE google_id=$user_id") OR die ('Ejecucion Invalida');
	$user_exist=pg_fetch_array($result);

	if($user_exist)
	{
		echo 'Bienvenido de regreso '.$user_name.'!';
	}else{ 
		//user is new
		echo 'Hola '.$user_name.', Gracias por registrarte!';
		$result=pg_query($pgsql,"INSERT INTO tgoogle_users (google_id, google_name, google_email, google_link, google_picture_link) 
		VALUES ($user_id, '$user_name','$email','$profile_url','$profile_image_url')") OR die ('Ejecucion Invalida');
		
		//$mysqli->query("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) 
		//VALUES ($user_id, '$user_name','$email','$profile_url','$profile_image_url')");
	}

	
	//echo '<br /><a href="'.$profile_url.'" target="_blank"><img src="'.$profile_image_url.'?sz=100" /></a>';
	//echo '<br /><a class="logout" href="?reset=1">Logout</a>';
	
	//list all user details
	//echo '<pre>'; 
	print_r($user);
	//echo '</pre>';	
}
 
//echo '</body></html>';
?>

