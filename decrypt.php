<?php

//query from database 
mysql_connect('localhost', 'root', '');
mysql_select_db('openssl');
$query = "SELECT * FROM `check` WHERE `id` = 2 ";
$fetchData = mysql_query($query);
$data = mysql_fetch_assoc($fetchData);
//print_r($data);
//echo $_SERVER['DOCUMENT_ROOT'];
$privateKey = openssl_pkey_get_private('file://'.$_SERVER['DOCUMENT_ROOT'].'/openssl/private.pem', 'hello');
//print_r($privateKey);
//exit;
// Get the private Key
if (!$privateKey)
{
    die('Private Key failed');
}

$a_key = openssl_pkey_get_details($privateKey);
 
// Decrypt the data in the small chunks
$chunkSize = ceil($a_key['bits'] / 8);
$output = '';
 $encrypted = $data ['data'];
 //exit;
/*while ($encrypted)
{*/
    $chunk = substr($encrypted, 0, $chunkSize);
    $encrypted = substr($encrypted, $chunkSize);
    $decrypted = '';
    if (!openssl_private_decrypt($chunk, $decrypted, $privateKey))
    {
        die('Failed to decrypt data');
    }
    $output .= $decrypted;
/*}*/
openssl_free_key($privateKey);
 

 
// Uncompress the unencrypted data.
$output = gzuncompress($output);
 
echo '<br /><br /> Unencrypted Data: ' . $output;
?>