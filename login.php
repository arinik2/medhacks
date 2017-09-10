<?php
require_once 'include/DB_Functons.php';
$db = new DB_Functions();
 
 
if (isset($_POST['name']) && isset($_POST['date-of-birth']) && isset($_POST['choose-procedure'])) {
 
    // receiving the post params

    $name = $_POST['name'];
	$procedure = $_POST['choose-procedure'];
    $dob = $_POST['date-of-birth'];
	$clinic = "General Dentistry";
	$auth = $db->checkConscent($clinic,$name,$dob);
	if ($auth == true){
		header('Location: register.php?name='.$name."&date-of-birth=".$dob."&choose-procedure=".$procedure."&office=".$clinic);exit();}
	else {
		echo '<!DOCTYPE html>
<html lang="en">

<head>
  <title>Patient Consent Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width-device-width, initial-scale=1">

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="main.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="container">

    <div class="row">
      <h1>Terms and Conditions</h1><br>

      <hr class="colorgraph">

      <p>Checking the box below will constitute acceptance of this agreement.<br> This service gives SwiftPrep access to your medical records. They are stored securely off-site by the Human API service. Parts of those records relevant their scope of care
       will be shared with this office (General Dentistry).</p><br>

      

        <div id="check-awesome" class="form-group">
          <input type="checkbox" id="agree_box" required>
          <label for="agree_box">
            <span></span>
            <span class="check"></span>
            <span class="box"></span>
            I agree to the above terms and conditions.
          </label><br><br><br>

        </div>

        <div class="col-xs-12 col-md-6 pull-right"><a href="register.php?name='.$name.'&date-of-birth='.$dob.'&choose-procedure='.$procedure.'&office='.$clinic.'"><input type="submit" value="Next" class="btn btn-primary btn-block btn-lg"></a></div>

      
    </div>
  </div>
</body>

</html>';

}}
 else{echo "nope";
 }

?>