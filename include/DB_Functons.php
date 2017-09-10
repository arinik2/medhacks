<?php
 

class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct(){
         
    }
 
	public function getAllergies($user_id){
		$json = file_get_contents('https://api.humanapi.co/v1/human/medical/allergies?access_token='.$user_id);
		$obj = json_decode($json);
		$allergies = array();
		$allergens = array();
		foreach ($obj as $value) {
			//array_push($allergies,$value->name);
			foreach ($value->codes as $value2){
				if(in_array($value2->name, $allergens) == false){
					array_push($allergens,$value2->name);
				}		
			}
		}
		return $allergens;
	}
	
	public function getMedicationsDueToDate($user_id){
		$json = file_get_contents('https://api.humanapi.co/v1/human/medical/medications?access_token='.$user_id);
		$obj = json_decode($json);
		$medications = array();
		$ndcCode = array();
		foreach ($obj as $value) {
			if ($value->commonBrandName == NULL){continue;}
			if (intval(substr($value->endDate,0,4)) > intval(date("Y"))){array_push($medications,$value->commonBrandName);}
			if (intval(substr($value->endDate,0,4)) == intval(date("Y"))){	
				if (intval(substr($value->endDate,5,2)) > intval(date("m"))){array_push($medications,$value->commonBrandName);}
				if (intval(substr($value->endDate,5,2)) == intval(date("m"))){
					if (intval(substr($value->endDate,8,2)) >= intval(date("d"))+7){
						array_push($medications,$value->commonBrandName);}}
				}
			}
			//array_push($ndcCode,$value->ndcCode);
		return $medications;
	}
	
	public function getMedications($user_id){
		$json = file_get_contents('https://api.humanapi.co/v1/human/medical/medications?access_token='.$user_id);
		$obj = json_decode($json);
		$medications = array();
		$ndcCode = array();
		$count = 0;
		foreach ($obj as $value) {	
			if ($value->commonBrandName == NULL){continue;}		
			if ($count > 9){break;}
			array_push($medications,$value->commonBrandName);
			$count += 1;
			}
			//array_push($ndcCode,$value->ndcCode);
		return $medications;
	}
	
	public function getDiagnozes($user_id){
		$json = file_get_contents('https://api.humanapi.co/v1/human/medical/encounters?access_token='.$user_id);
		$obj = json_decode($json);
		$encounters = array();
		foreach ($obj as $value) {
			foreach ($value->diagnoses as $value2){			
				array_push($encounters,$value2->name);}
		}
		return $encounters;
	}
	function funcStatuses($user_id){
	$json = file_get_contents("https://api.humanapi.co/v1/human/medical/functional_statuses?access_token=".$user_id);
	$obj = json_decode($json);
	$statuses = array();
	foreach ($obj as $value) {
		array_push($statuses,$value->name);
		}
	return $statuses;
	}
	public function setConscent($hid,$office){
		$stmt = $this->conn->prepare("INSERT INTO myauth(personID,pracID,authorized) VALUES(?,?,true)");
		$stmt->bind_param("ss", $hid,$office);
        $result = $stmt->execute();
		$stmt->close();	
	}
	public function checkConscent($clinic,$name,$dob){
		$uid = $this->getUid($name,$dob);
		$stmt = $this->conn->prepare("SELECT * FROM myauth WHERE personID = ? and pracID = ?");
        $stmt->bind_param("ss", $uid,$clinic);
        $stmt->execute();
        $notes = $stmt->get_result();
        $stmt->close();
		$n = $notes->fetch_assoc();
		return $n['authorized'];
	}
	
	public function getFeatures($procedure){
		$stmt = $this->conn->prepare("SELECT * FROM features WHERE procedures = ?");
        $stmt->bind_param("s", $procedure);
        $stmt->execute();
        $notes = $stmt->get_result();
        $stmt->close();
		return $notes;
	}
	public function getUid($name,$dob){
		$stmt = $this->conn->prepare("SELECT * FROM person WHERE firstName = ? and dob = ?");
        $stmt->bind_param("ss", $name,$dob);
        $stmt->execute();
        $notes = $stmt->get_result();
        $stmt->close();
		$n = $notes->fetch_assoc();
		return $n['hid'];
	}
	public function Surgeries($user_id){
		$json = file_get_contents("https://api.humanapi.co/v1/human/medical/procedures?access_token=".$user_id);
		$obj = json_decode($json);
		$surgeries = array();
		foreach ($obj as $value) {
			if (strpos($value->name, 'surgery') != false || strpos($value->name, 'Surgery') != false){
					array_push($surgeries,$value->name);
				}
			}
			
		$json = file_get_contents("https://api.humanapi.co/v1/human/medical/plans_of_care?access_token=".$user_id);
		$obj = json_decode($json);
		foreach ($obj as $value) {
			if (strpos($value->text, 'surgery') != false || strpos($value->text, 'Surgery') != false){
					array_push($surgeries,$value->text);
				}
			}	
				
		return $surgeries;
	}
	

}
 ?>