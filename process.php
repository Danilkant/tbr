<?php 

foreach ($_POST as $key => $value) {

//Trimmar úr auð bil	
$temp = is_array($value) ? $value : trim($value);

//Ef reitnir eru tómir, bæta við í $missing array
if (empty($temp) && in_array($key, $required)) {
	$missing[] = $key;
//Ef svo er tæmir reitinn.
	${$key} = '';
}

//Athugað ef gögn séu að koma frá öðrum input textareitum.
elseif (in_array($key, $expected)) {
	${$key} = $temp;
}

}

?>