<?php
try{

	# Hér þarf að koma tegund og nafn á gagnagrunni
	$source = 'mysql:host=tsuts.tskoli.is;dbname=0807932279_Lokaverkefni';  
	# Notendanafn (kennitala)
	$user = '0807932279';
	# lykilorð (mypassword)
	$password = 'mypassword';

	# notum pdo class til fyrir tengingu
	$connection = new PDO($source, $user, $password);

	# stillum af hvernig hann meðhöndlar villur
	# Það sem er í sviganum eru fastar, :: segir til um að þetta séu fastar sem eru hluti af PDO klasanum 
	# línan þýðir: ,,We want to set the PDO attribute that control the error mode (Attr_ERRMODE) to the mode (ERRMODE_EXCEPTION)that throws exceptions 
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	# Við getum notað exec fyrir INSERT; UPDATE og DELETE
	# notum utf-8 og gerum það með exec() sem sendir sql skipun til gagnagrunns.
	$connection->exec('SET NAMES "utf8"');
}
catch (PDOException $e){
	
	# Skemmtilegri skilaboð til notanda sjá kóða t.d. bls. 99
	echo "tenging tókst ekki". "<br>" . $e->getMessage();
	
}
?>