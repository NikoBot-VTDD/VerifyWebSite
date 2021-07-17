<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$servername = "SQLServerIP";//Need edit
$username = "USERID";//Need edit
$password = "PASSWD";//Need edit
$dbname = "DBNAME";//Need edit

if(session('discordId')&&session('refToken')){

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($result = $conn->query("SHOW TABLES LIKE 'VTDD_REGUSER'")) {
		if($result->num_rows != 1) {//Table not exist, create table
			echo 'CREATE table';
			//$sqlQ = "CREATE TABLE REGUSER (DiscordID VARCHAR(20) NOT NULL, RefToken VARCHAR(150) NOT NULL, PRIMARY KEY (DiscordID))";
			$sqlQ = "CREATE TABLE VTDD_REGUSER (DiscordID VARCHAR(20) NOT NULL, RefToken VARCHAR(150) NOT NULL,Verify BOOLEAN,TS TIMESTAMP, PRIMARY KEY (DiscordID))";
                        if($conn->query($sqlQ) !== TRUE){
				exit();
			}
		}
	}

	$discordId = $_SESSION['discordId'];
	$refToken = $_SESSION['refToken'];
	$stmt = $conn->prepare("SELECT DiscordID FROM VTDD_REGUSER WHERE DiscordID=?");
	$stmt->bind_param("s", $discordId);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if($result->num_rows > 0){//Already have record, update it.
		$stmt_update = $conn->prepare("UPDATE VTDD_REGUSER SET RefToken=? WHERE DiscordID=?");
		$stmt_update->bind_param("ss", $refToken, $discordId);
		$stmt_update->execute();
		$stmt_update->close();
	}
	else{//Insert record
		$stmt_insert = $conn->prepare("INSERT INTO VTDD_REGUSER (DiscordID, RefToken)VALUES (?, ?)");
		$stmt_insert->bind_param("ss", $discordId, $refToken);
		$stmt_insert->execute();
		$stmt_insert->close();
	}
	echo '<h4>Discord id:, ' . $discordId . '. Update google Oauth2 success.</h4>';
	echo 'If you want to remove this authenticate, please go to Google Account Permission and delete the application NikoBot-VTDD.';
	echo '<br /><a href="https://myaccount.google.com/permissions">Google Account Permission</a>';
}
else{
	echo 'Error.';
}
session_destroy();

function session($key, $default=NULL) {
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}
?>
