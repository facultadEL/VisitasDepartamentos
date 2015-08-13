<?php

//echo md5(crypt('Ezeoleaf',CRYPT_BLOWFISH));

$varBase = 'de59c8898de79f4820135f32af7c01db';

if(md5(crypt('Ezeoleaf',CRYPT_BLOWFISH)) == $varBase)
{
	echo 'Entre';
}
else
{
	echo 'Lpm';
}

?>