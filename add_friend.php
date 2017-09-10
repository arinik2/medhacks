<?php
 
require_once 'include/DB_Functons.php';
$db = new DB_Functions();
$proc = $db->getFeatures("Dental Implants");
$feature = $proc->fetch_assoc();
$symptoms = $db->getDiagnozes("demo")+$db->funcStatuses("demo");
$symptoms["k"] = "Tumor";
$allergies = $db->getAllergies("demo");
$meds = $db->getMedications("demo");
$surgeries = $db->Surgeries("demo");
$surgeries["k"] = "Knee surgery";
var_dump($allergies);
$dict = array();
$flag = 0;
while ($feature != false){
	$f = $feature["feature"];
	if (strpos($f,"Allergic")!== false){
		if ($flag == 0){
			$dict["Allergies"] = join(', ',$allergies); $flag = 1;
	}}
	foreach ($symptoms as $s) {
		if (strpos($f,$s) !== false){$dict[$s] = $f;}
	}
	if (strpos($f,"medications")!== false){$dict["medications"]=join(', ', $meds);}
	if (strpos($f,"OPeration")!== false){$dict["surgeries"]=join(', ', $surgeries);}

	$feature = $proc->fetch_assoc();
}
var_dump($dict);
?>