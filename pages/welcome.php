<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styling.css">
		<?php

			include 'connManagr.php';
			include 'Validator.php';

			$validator=new Validator();
			
			//$dbObj->closeConn();

		?>

	</head>
	<body id="welcome">
		<h1 align='center'>Welcome to Family Tree<br></h1>
		<div id="createTemplate" class="template">
			<h3>Create a Person with id,name,DOB</h3><br>
			<form name="create" method="post" action="">
				<table>
					<tr>
						<td>person-Id:</td><td><input type="text" name="id" id="p_id"></td>
					</tr>
					<tr>
						<td>person-Name:</td><td><input type="text" name="name" id="p_name"></td>
					</tr>
					<tr>
						<td>person-DateOfBirth:</td><td><input type="text" name="dob" id="p_pass"></td>
					</tr>
					<tr><td><input type="submit" id="create" name="create-submit" value="CreatePerson"></input></tr>
				</table>
			</form>
			<?php
			$dbObj = new Db();
			$dbObj->openMySQLiConn("localhost","root","","familytree");

				if(!empty($_POST['create-submit'])){
				// insert record into databasse
					$p_id=(int)$_POST['id'];
					$p_name=$_POST['name'];
					$p_dob=$_POST['dob'];
				if($validator->validateDate($p_dob) && $validator->validateId($p_id) && $validator->validateName($p_name))
					$dbObj->insertIntoDb($_POST['id'],$_POST['name'],$_POST['dob'],"person");
				else
					echo "Please give inputs in proper format!";
			}

			?>
		</div>



		<br><br><br>
		<div id="deleteTemplate" class="template">
			<h3>Delete a Person by person-Id</h3><br>
			<form name="delete" method="post" action="">
				<table>
					<tr>
						<td>person-Id:</td><td><input type="text" name="id" id="p_id"></td>
						<tr><td><input type="submit" id="delete" name="delete-submit" value="DeletePerson"></input></td></tr>
					</tr>
				</table>
			</form>
			<?php
			$dbObj = new Db();
			$dbObj->openMySQLiConn("localhost","root","","familytree");
			if(!empty($_POST['delete-submit'])){
				// if id exists delete recor
				if($validator->validateId($_POST['id']))
					$dbObj->deleteDb($_POST['id'],"person");
				else
				//else show error message
					echo "Please enter a valid id.";
			}	
			//$dbObj->closeConn();	

			?>
		</div>
			<br><br><br>
		<div id="updateTemplate" class="template">
			<h3>Update a Person by person-Id</h3><br>
			<form name="update" method="post" action="">
				<table>
					<tr>
						<td>person-Id:</td><td><input type="text" name="id" id="p_id"></td>
					</tr>
					<tr>
						<td>person-Name:</td><td><input type="text" name="name" id="p_name"></td>
					</tr>
					<tr>
						<td>person-DateOfBirth:</td><td><input type="text" name="dob" id="p_pass"></td>
					</tr>
					<tr><td><input type="submit" id="update" name="update-submit" value="UpdatePerson"></input></td></tr>
					
				</table>
			</form>
				<?php
				$dbObj = new Db();
				$dbObj->openMySQLiConn("localhost","root","","familytree");
				if(!empty($_POST['update-submit'])){
				// if id exists update name / dob
					$p_id=(int)$_POST['id'];
					$p_name=$_POST['name'];
					$p_dob=$_POST['dob'];
				if($validator->validateDate($p_dob) && $validator->validateId($p_id) && $validator->validateName($p_name))
					$dbObj->updateDb($_POST['id'],$_POST['name'],$_POST['dob'],"person");
				else
					echo "Please give inputs in proper format!";
			}
				?>
		</div>
		<div id="searchTemplate" class="template">

			<h3>Searching a person by part or full Name</h3><br>
			<form name="search" method="post" action="">
				person-Name:<input type="text" name="name" id="p_name"><br><br>
				<input type="submit" name="search-submit" value="Search Person">
			</form>
			<?php
				$dbObj = new Db();
				$dbObj->openMySQLiConn("localhost","root","","familytree");
				if(!empty($_POST['search-submit'])){
					if($validator->validateName($_POST['name']) && $_POST['name']!="" )
						$dbObj->searchDbAccName($_POST['name'],"person");
					else
						echo "Enter name in proper format!";
				}
			?>
			
		</div>
		<div id="relationTemplate" class="template">
			<br>
			<h3>Creating RelationShips</h3><br>
			<form name="search" method="post" action="">
				parent-Id:<input type="text" name="parent" id="p_id">
				child-Id:<input type="text" name="child" id="c_id"><br><br>
				<input type="submit" name="relation-submit" value="Create Relation">
			</form>
			<?php
				$dbObj = new Db();
				$dbObj->openMySQLiConn("localhost","root","","familytree");
				if(!empty($_POST['relation-submit'])){
					if($validator->validateId($_POST['parent']) && $validator->validateId($_POST['child']) )
						$dbObj->createRelation($_POST['parent'],$_POST['child']);
					else
						echo "Please give input in proper format";
				}

			?>

		</div>

	</body>

</html>