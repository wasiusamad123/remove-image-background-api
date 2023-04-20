<?php
// process-image.php

if (isset($_POST['submit'])) {
    $rand = rand(111111111, 999999999);
    $file_name = $_FILES['file']['name'];
    $file_tmp_name = $_FILES['file']['tmp_name'];

    // Move uploaded file to the upload directory
    move_uploaded_file($file_tmp_name, 'upload/' . $rand . $file_name);

    $file_url = 'http://localhost/Remove%20Image%20Background/upload/' . $rand . $file_name;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.remove.bg/v1.0/removebg');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $post = array(
        'image_url' => $file_url,
        'size' => 'auto'
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $headers = array();
    // Read API key from a configuration file or environment variable
    $headers[] = 'X-Api-Key: ' . getenv('X-Api-Key: y8mHvDEbBwShVSdGMSvrT4Tg');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);
    $fp = fopen('remove/' . $rand . '.png', "wb");
    fwrite($fp, $result);
    fclose($fp);
    echo "<img src='remove/$rand.png'>";
}
