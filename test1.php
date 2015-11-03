<?php
$source = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eleifend vestibulum nunc sit amet mattis. Nulla at volutpat nulla. Pellentesque sodales vel ligula quis consequat. Suspendisse dapibus dolor nec viverra venenatis. Pellentesque blandit vehicula eleifend. Duis eget fermentum velit. Vivamus varius ut dui vel malesuada. Ut adipiscing est non magna posuere ullamcorper. Proin pretium nibh nec elementum tincidunt. Vestibulum leo urna, porttitor et aliquet id, ornare at nibh. Maecenas placerat justo nunc, varius condimentum diam fringilla sed. Donec auctor tellus vitae justo venenatis, sit amet vulputate felis accumsan. Aenean aliquet bibendum magna, ac adipiscing orci venenatis vitae.';

//echo "Source: $source";
$fp=fopen($_SERVER['DOCUMENT_ROOT'].'/openssl/private.key', "r");
$priv_key=fread($fp,81922);
fclose($fp);
$passphrase = 'hello';
// $passphrase is required if your key is encoded (suggested)
$res = openssl_get_privatekey($priv_key,$passphrase);
/*
* NOTE:  Here you use the returned resource value
*/
$return = openssl_private_encrypt($source,$crypttext,$res);
if($return == 1)
{
	echo "String crypted: $crypttext";
}
else 
{
	echo "vezal ace";
}
$fp=fopen ($_SERVER['DOCUMENT_ROOT'].'/openssl/public.key',"r");
$pub_key=fread($fp,81922);
fclose($fp);
openssl_get_publickey($pub_key);
/*
* NOTE:  Here you use the $pub_key value (converted, I guess)
*/
openssl_public_decrypt($crypttext,$newsource,$pub_key);
echo "String decrypt : $newsource";
?>