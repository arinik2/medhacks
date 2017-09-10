<?php
require_once 'include/DB_Functons.php';
function show_list($dict1){
	if(count($dict1) == 0)
        echo "Nothing relevant to report".PHP_EOL;
    else{
		echo "<table>";
		foreach($dict1 as $key => $value){
				echo "<tr><td>".$key."</td><td>".$value."</td></tr>".PHP_EOL;
		}
		echo "</table>";}
}
$db = new DB_Functions();
$proc = $db->getFeatures($_GET["choose-procedure"]);
$feature = $proc->fetch_assoc();
$uid = $db->getUid($_GET["name"],$_GET["date-of-birth"]);
$db->setConscent($uid,$_GET["office"]);
$symptoms = $db->getDiagnozes($uid)+$db->funcStatuses($uid);
$symptoms["k"] = "Tumor";
$allergies = $db->getAllergies($uid);
$meds = $db->getMedications($uid);
$surgeries = $db->Surgeries($uid);
$surgeries["k"] = "Knee surgery";
$dict = array();
$flag = 0;
while ($feature != false){
	$f = $feature["feature"];
	if (strpos($f,"Allergic")!== false){
		if ($flag == 0){
			$dict["Allergies"] = join(', ',$allergies); $flag = 1;
	}}
	foreach ($symptoms as $s) {
		
		if (strpos($f,$s) !== false or strpos($s,$f) !== false){$dict[$s] = $f;}
	}
	if (strpos($f,"medications")!== false){$dict["Medications"]=join(', ', $meds);}
	if (strpos($f,"OPeration")!== false){$dict["Surgeries"]=join(', ', $surgeries);}
	$feature = $proc->fetch_assoc();
}


?>
<!DOCTYPE HTML>
<html lang='en'>

<head>
  <title>Relevant Info for Medical History</title>
  <meta http-equiv='Content-Type' charset='utf-8'>
  <meta name='viewport' content='width-device-width, initial-scale=1'>

  <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

  <link rel='stylesheet' type='text/css' href='main.css'>
</head>

<body>
  <div class='container'>

    <h1>Relevant Information</h1>

    <hr class='colorgraph'>

    <p>
      <b>Patient:</b> <?php echo $_GET["name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <b>Date:</b> <?php echo $_GET["date-of-birth"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <b>Procedure:</b> <?php echo $_GET["choose-procedure"]; ?>
    </p>

    <h3><b>Procedure Reminders:</b></h3>

<?php show_list($dict); ?>

    <div width='35%' class='pull-left pull-bottom'><a href='index.html' class='btn btn-primary btn-block btn-lg'>Go Back</a</div>

</body>

</html>
