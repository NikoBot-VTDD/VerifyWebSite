<?php
ini_set("session.use_trans_sid",1);
ini_set("session.use_only_cookies",0);
ini_set("session.use_cookies",1);

session_start();
require_once 'vendor/autoload.php';

// 0) 
$client = new Google_Client;
$client->setClientId("Google OAuth2.0 Client ID");//Need edit
$client->setClientSecret("Google OAuth2.0 Client KEY");//Need edit
$client->setAccessType('offline');
$client->setApprovalPrompt('force');

$hostname = "https://YOUR.DOMAIN/auth.php";//Need edit

// 2) 
if (isset($_GET['code']))
{
    $client->setRedirectUri($hostname);
    $result = $client->authenticate($_GET['code']);

    if (isset($result['error']))
    {
        die($result['error_description']);
    }

	if ($client->getAccessToken())
	{
        $token = $client->getAccessToken();
		//print($token[access_token]);
		//print("\n")
		//print($token[refresh_token]);
		$_SESSION['refToken'] = $token[refresh_token];
		//print("\n")
		//print($_SESSION['discordId']);
    }

    $_SESSION['google']['access_token'] = $result;
    header("Location:reg.php");
}
// 1) 
else
{
    $client->revokeToken();
    //session_destroy();

    $client->addScope(['https://www.googleapis.com/auth/youtube.force-ssl']);
    $client->setRedirectUri($hostname);
    $url = $client->createAuthUrl();
    header("Location:{$url}");
}
?>
