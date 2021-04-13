<?php 
ini_set("session.use_trans_sid",1);
ini_set("session.use_only_cookies",0);
ini_set("session.use_cookies",1);

session_start();
require_once 'vendor/autoload.php';

// 0) 設定 client 端的 id, secret
$client = new Google_Client;
$client->setClientId("Your google api client id");
$client->setClientSecret("Your google api client secret");
$client->setAccessType('offline');
$client->setApprovalPrompt('force');

$hostname = "https://yourhostname/auth.php";

// 2) 使用者認證後，可取得 access_token
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
// 1) 前往 Google 登入網址，請求用戶授權
else 
{
    $client->revokeToken();
    //session_destroy();
 
    // 添加授權範圍，參考 https://developers.google.com/identity/protocols/googlescopes
    $client->addScope(['https://www.googleapis.com/auth/youtube.force-ssl']);
    $client->setRedirectUri($hostname);
    $url = $client->createAuthUrl();
    header("Location:{$url}");
}
?>