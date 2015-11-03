<?php
// Data to be sent
$plaintext = 'mahabub7@gmail.com.';
 
// 'Plain text: ' . $plaintext;

// Compress the data to be sent
$plaintext = gzcompress($plaintext);
 
// Get the public Key of the recipient
$publicKey = openssl_pkey_get_public('file://'.$_SERVER['DOCUMENT_ROOT'].'/openssl/public.pem');
$a_key = openssl_pkey_get_details($publicKey);
 
// Encrypt the data in small chunks and then combine and send it.
$chunkSize = ceil($a_key['bits'] / 8) - 11;
$output = '';
 
while ($plaintext)
{
    $chunk = substr($plaintext, 0, $chunkSize);
    $plaintext = substr($plaintext, $chunkSize);
    $encrypted = '';
    if (!openssl_public_encrypt($chunk, $encrypted, $publicKey))
    {
        die('Failed to encrypt data');
    }
    $output .= $encrypted;
}
openssl_free_key($publicKey);
 
 
 
// This is the final encrypted data to be sent to the recipient
//echo "<br>";
echo $encrypted = $output;

//Insert into database
mysql_connect('localhost', 'root', '');
mysql_select_db('openssl');
$query = "INSERT INTO `openssl`.`check` (`id`, `data`) VALUES (NULL, '$encrypted');";
if(mysql_query($query))
echo "Insert data successfully";

$query = "SELECT MAX(id) as id FROM `check` ";
$fetchDataGet = mysql_query($query);
$dataId = mysql_fetch_assoc($fetchDataGet);
//print_r
$maxId = $dataId['id'];


$query = "SELECT * FROM `check` WHERE `id` = $maxId ";
$fetchData = mysql_query($query);
$data = mysql_fetch_assoc($fetchData);
$crypttext = $data['data'];
//database finish

function decrypt($encrypted)
{
	// Get the private Key
	if (!$privateKey = openssl_pkey_get_private('file://'.$_SERVER['DOCUMENT_ROOT'].'/openssl/private.pem'))
	{
		die('Private Key failed');
	}
	$a_key = openssl_pkey_get_details($privateKey);
	 
	// Decrypt the data in the small chunks
	$chunkSize = ceil($a_key['bits'] / 8);
	$output = '';
	 
	while ($encrypted)
	{
		$chunk = substr($encrypted, 0, $chunkSize);
		$encrypted = substr($encrypted, $chunkSize);
		$decrypted = '';
		if (!openssl_private_decrypt($chunk, $decrypted, $privateKey))
		{
			die('Failed to decrypt data');
		}
		$output .= $decrypted;
	}
	openssl_free_key($privateKey);
	 
	// Uncompress the unencrypted data.
	return $output = gzuncompress($output);
	 
	//echo '<br /><br /> Unencrypted Data: ' . $output;
}

echo decrypt($crypttext);
?>