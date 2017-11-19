<?php

/*$html=file_get_contents('https://www.similarweb.com/website/bankera.com');
echo $html;*/
$ch = curl_init("https://www.similarweb.com/website/bankera.com");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);
echo $data;
?>