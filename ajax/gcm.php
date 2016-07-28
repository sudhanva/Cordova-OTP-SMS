<?php
require 'db.php';

function sendPushNotification($registration_ids, $message) {

    $url = 'https://android.googleapis.com/gcm/send';
    $fields = array(
        'registration_ids' => $registration_ids,
        'data' => $message,
    );

    define('GOOGLE_API_KEY', 'AIzaSyArAFEDMTGvkTRbsEsOpQ8koSSSA0G4ddY');

    $headers = array(
        'Authorization:key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );
    echo json_encode($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);
    if($result === false)
        die('Curl failed ' . curl_error());

    curl_close($ch);
    return $result;

}

$pushStatus = '';

if(!empty($_GET['push'])) {

    $query = "SELECT gcmId FROM registration";
    if($query_run = mysql_query($query)) {

        $gcmRegIds = array();
        while($query_row = mysql_fetch_assoc($query_run)) {

            array_push($gcmRegIds, $query_row['gcmId']);

        }

    }
    $pushMessage = $_POST['message'];
    if(isset($gcmRegIds) && isset($pushMessage)) {

        $message = array('message' => $pushMessage);
        $pushStatus = sendPushNotification($gcmRegIds, $message);

    }   
}

if(!empty($_GET['shareRegId'])) {

    $gcmRegId = $_POST['gcmId'];
    $query = "INSERT INTO registration VALUES ('', '$gcmRegId')";
    if($query_run = mysql_query($query)) {
        echo 'OK';
        exit;
    }   
}
?>

<html>
    <head>
        <title>Google Cloud Messaging (GCM) Server in PHP</title>
    </head>
    <body>
    <h1>Google Cloud Messaging (GCM) Server in PHP</h1>
    <form method = 'POST' action = 'gcm.php/?push=1'>
        <div>
            <textarea rows = 2 name = "message" cols = 23 placeholder = 'Messages to Transmit via GCM'></textarea>
        </div>
        <div>
            <input type = 'submit' value = 'Send Push Notification via GCM'>
        </div>
        <p><h3><?php echo $pushStatus ?></h3></p>
    </form>
    </body>
</html>