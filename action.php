<?php 

include "db.php";

class dataOperation extends Database
{
	public function insertData($table, $fields)
	{
		$sql = "";
		$sql .= "INSERT INTO ".$table;
		$sql .= " (". implode(", ", array_keys($fields)).") VALUES";
		$sql .= "('".implode("', '", array_values($fields))."');";
		$query = mysqli_query($this->con,$sql);
		if ($query)
			return true;
	}

	public function loginCheck()
	{
		$email = $_POST["email"];
		$password = $_POST["password"];
		$sql = "SELECT ind FROM users WHERE email = '$email' and password = '$password'";
      	$query = mysqli_query($this->con,$sql);
	    $count = mysqli_num_rows($query);
	    if($count == 1) {
			header("location:main.php");
	    }
	    else{
	    	header("location:index.php");
	    }
	}

	public function fetch_record($table)
	{
		$sql = "SELECT * FROM ".$table.";";
		$arr = array();
		$query = mysqli_query($this->con,$sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function select_record($table,$where)
	{
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key."='".$value."'";
		}
		$sql .= "SELECT * FROM ".$table." WHERE ".$condition.";";
		$query = mysqli_query($this->con,$sql);
		$row = mysqli_fetch_array($query);
		return $row;
	}

	public function update_record($table, $where, $my_array)
	{
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key."='".$value."'";
		}
		foreach ($my_array as $key => $value) {
			$sql .= $key."='".$value."', ";
		}
		$sql = substr($sql, 0, -2);
		$sql = "UPDATE ".$table." SET ".$sql." WHERE ".$condition.";";
		echo "$sql";
		if (mysqli_query($this->con,$sql)) {
			return true;
		}
	}

	public function delete_record($table,$where)
	{
		$sql="";
		$condition="";
		foreach ($where as $key => $value) {
			$condition .= $key."='".$value."'";
		}
		$sql = "DELETE FROM ".$table." WHERE ".$condition.";";
		if (mysqli_query($this->con,$sql)) {
			return true;
		}
	}

	public function forgetPassword()
	{
		$email = mysqli_real_escape_string($this->con,$_POST['recoveryEmail']);
		$sql = "SELECT ind,note from users where email = '$email' LIMIT 1";
		$query = mysqli_query($this->con,$sql);
		if (mysqli_num_rows($query) == 1) {
			$row = mysqli_fetch_array($query);
			$uid = $row["ind"];
			$note = $row["note"];
			if ($note != "0") {
				echo "<center>Pleas check your email address we have already sent you a link</center>";
				exit();
			}
			else
			{
				$randomNote = time().rand(50000,100000);
				$randomNote = str_shuffle($randomNote);
				$updateNote = "UPDATE users set note = '$randomNote' WHERE ind = '$uid' and email = '$email'";
				if (mysqli_query($this->con,$updateNote)) {
					$to = $email;
					$sub = "Reset Password Link";
					$msg = "Please click on the given link below to reset your password<br>";
					$msg .= "http://localhost/loginSystemOOPphp/reset.php?note=".$randomNote."&id=".$uid."&email=".$email;
					$header = "From : Akbar and inc.";
					if (/*mail($to,$sub,$msg,$header)*/TRUE) {
						echo "<center>Please confirm your email to reset your password";
						echo "<br>Temporary Email display here<br>";
						echo "$msg</center>";
						exit();
					}
				}
			}
		}
		else{
			echo "<center>Your email does not exist</center>";
		}
	}

	public function resetPassword()
	{
		/*if (isset($_REQUEST['note']) AND isset($_REQUEST['id']) AND isset($_REQUEST['email'])) {
			$note = preg_replace("#[^0-9]#", "", $_REQUEST['note']);
			$id = preg_replace("#[^0-9]#", "", $_REQUEST['id']);
			$emaill = mysqli_real_escape_string($this->con, $_REQUEST['email']);
			echo "$note";
			echo "$id";
			echo "$email";
			//$sql = "SELECT id FROM users WHERE note = '$note' AND email = '$email' AND ind = '$id' LIMIT 1";
			//$query = mysqli_query($this->con,$sql);		
		}*/

		$password = $_POST["password"];
		$Cpassword = $_POST["Cpassword"];
		$id = $_POST["id"];
		$note = $_POST["note"];

		if (strlen($password) < 5) {
			echo "Password length is short";
			exit();
		}
		else{
			if ($password == $Cpassword) {
				$option = ["COST"=>12];
				$hashPassword = password_hash($password,PASSWORD_DEFAULT,$option);
				$hashPassword = $password;
				$sql = "UPDATE users set password = '$hashPassword' WHERE ind = '$id' AND note = '$note'";
				$query = mysqli_query($this->con,$sql) or die(mysqli_error($this->con));
				if ($query) {
					echo "<center>Your password is reset Now you can login</center>";
				}
				$sql = "UPDATE users set note = '0' WHERE ind = '$id' AND note = '$note'";
				$query = mysqli_query($this->con,$sql);
			}
		}
		header("location:main.php");
	}
}

$obj = new dataOperation;

if (isset($_POST["register"]))
{
	$my_array = array(
		'name' => $_POST["name"], 
		'email' => $_POST["email"],
		'password' => $_POST["password"]);
	if ($obj->insertData("users", $my_array)) {
		echo '<script>alert("Registered Successfully")</script>';
		header("location:register.php");
	}
}

if (isset($_POST["edit"]))
{
	$id = $_POST["id"];
	$where = array('ind' => $id);
	$my_array = array(
		'name' => $_POST["name"], 
		'email' => $_POST["email"],
		'password' => $_POST["password"]);
	if ($obj->update_record("users", $where, $my_array)) {
		header("location:main.php?msg=Record_Updated_Successfully");
	}
}

if (isset($_GET["delete"])) {
	$id = $_GET["id"] ?? null;
	$where = array('ind' => $id);
	if ($obj->delete_record("users", $where)) {
		header("location:main.php?msg=Record_Deleted_Successfully");
	}
}

if (isset($_POST['forgetPassword'])) {
	$obj->forgetPassword();
}

if (isset($_POST['reset'])) {
	$obj->resetPassword();
}

if (isset($_POST["login"]))
{
	if ($obj->loginCheck()) {
		echo '<script>alert("Login Successfully")</script>';
		//header("location:main.php");
	}
}

 ?>