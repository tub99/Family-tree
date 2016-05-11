<?php
// $servername = "localhost";
// $username = "root";
// $password = "";

	class Db{
		var $connection;
		var $mConn;


		function openMySQLiConn($servername, $username, $password,$dbname){
			// Create connection
			$this->mConn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($this->mConn->connect_error) {
			    die("Connection failed: " . $this->mConn->connect_error);
			} 
		}
		function insertIntoDb($id,$name,$dob,$tableName){
			$time = strtotime($dob);
			$newformat = date('Y-m-d',$time);
			 $sql = "INSERT INTO ".$tableName." (id,name,birth_date) VALUES ('".$id."', '".$name."', '".$newformat."')";
			if ($this->mConn->query($sql) === TRUE) {
			    echo "New record created successfully";
			} else {
			    echo "Error: " . $sql . "<br>" . $this->mConn->error;
			}

		}
		function createRelation($pId,$cId){
			$sql="INSERT into parent(parent_id,child_id) VALUES('".$pId."','".$cId."')";
			if ($this->mConn->query($sql) === TRUE) {
			    echo "New record created successfully";
			} else {
			    echo "Error: " . $sql . "<br>" . $this->mConn->error;
			}
		}
		function getRelation($table){
			$relArray=[];
			$sql="SELECT * from ".$table;
			$result = $this->mConn->query($sql);
			if ($result->num_rows > 0) {
			    // output data of each row
			 while($row = $result->fetch_assoc()) {
			       // echo "Child: " . $row["child_id"]. " -Parent: " . $row["parent_id"]."<br>";
				    $obj = new stdClass;
				    $obj->c_id=$row["child_id"];
					$obj->p_id=$row["parent_id"];
					array_push($relArray,$obj);
				}
			} else {
			    echo "0 results";
			}
			return $relArray;

		}
		function searchDbAccName($name,$tableName){

			//$sql="SELECT name,birth_date from".$tableName;
			$sql="SELECT * from ".$tableName." WHERE name='".$name."' or name like '%".$name."%'" ;
			$result = $this->mConn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        echo "id: " . $row["id"]. " - Name: " . $row["name"]. "-DOB :" . $row["birth_date"]. "<br>";
			    }
			} else {
			    echo "0 results";
			}
		
		}
		function getAllFromDb($tableName){
			$pArr=[];
			$sql="SELECT * from ".$tableName;
			$result = $this->mConn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			       // echo "id: " . $row["id"]. " - Name: " . $row["name"]. "-DOB :" . $row["birth_date"]. "<br>";
				    $obj = new stdClass;
				    $obj->id=$row["id"];
					$obj->name = $row["name"];
					$obj->dob=$row["birth_date"];
					array_push($pArr,$obj);
				}
			} else {
			    echo "0 results";
			}
			return $pArr;
		}
		function searchDbAccId($id,$tableName){

			//$sql="SELECT name,birth_date from".$tableName;
			//$sql="SELECT * from ".$tableName." WHERE id='".$id."'";
			$sql="SELECT * from ".$tableName." WHERE id='".$id."'";
			$result = $this->mConn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        echo "id: " . $row["id"]. " - Name: " . $row["name"]. "-DOB :" . $row["birth_date"]. "<br>";
			    }
			} else {
			    echo "No person details exists for this ID";
			}
		
		}

		function updateDb($id,$name,$dob,$tableName){
			$time = strtotime($dob);
			$newformat = date('Y-m-d',$time);
			$sql="UPDATE ".$tableName." SET name='".$name."', birth_date='".$dob."' WHERE id='".$id."'";
			//echo $sql;
			if ($this->mConn->query($sql) === TRUE) {
			echo "Record updated successfully";
			} else {
			    echo "Error updating record: Following id doesnot exist";
			}
		}
		function deleteDb($id,$tableName){

				// sql to delete a record
			    $sql = "DELETE FROM ".$tableName." WHERE id='".$id."'";
			    //echo $sql;
			   if ($this->mConn->query($sql) === TRUE) {
    			echo "Record deleted successfully";
				} else {
    			echo "Error deleting record: " . $this->mConn->error;
				}
		}
		function closeConn(){
			$this->mConn->close();
		}
	}

	// $db= new Db();
	// $db->openMySQLiConn("localhost","root","","familytree");
	// $db->searchDbAccName("s","person");
?>
