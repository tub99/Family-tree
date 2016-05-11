<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styling.css">
	</head>
	<body id="detailBody">
		<?php

			//include 'connManagr.php';
			include 'Validator.php';
			include 'DataManager.php';
			$validator=new Validator();
			$dataManager=new DataManager();
			$dataManager->parseRelationData();
		?>
		<div id="details" align="center">
			<h3> Check person Details<h3>
			<div id="disp_pDetails">
				<form action="" method="get">
					User-Id:<input type="text" name="id" id="p_id"><br><br>
					<input type="submit" name="personDetails-submit" value="Display Person Details">
				</form>
				<?php
				if(!empty($_GET['personDetails-submit'])){
					if($validator->validateId($_GET['id'])){
						$data=$dataManager->getChildWithParentLink($_GET['id']);
						print_r(json_encode($data));

					}
					else 
						echo "Please give an id of number type!";
				}

				?>
			</div>
			<br><br>
			<div id="disp_gPDetails">
				<h3> Check out the Grand Parents for a a given Id<h3>
				<form action="" method="get">
					User-Id:<input type="text" name="id" id="p_id"><br><br>
					<input type="submit" name="grandParent-submit" value="Display Grand-Parents">
				</form>
				<?php

					if(!empty($_GET['grandParent-submit'])){
						$cId=$_GET['id'];
						if($validator->validateId($cId)){
							$dataManager->getParent($cId);
							$dataManager->printGrands();
						}
						else 
							echo "Please give an id of number type!";


					}

				?>
			</div>
			<div id="disp_onlyParent">
				<h3> Click on the button below to see People with one Parent<h3>
				<form action="" method="post">
					<input type="submit" name="onlyParent-submit" value="Display one Parent children">
				</form>
				<?php

					if (isset($_POST['onlyParent-submit'])){
							$dataManager->getChildWithOneParent();
							

						}
				?>
			</div>
		</div>
		
	</body>
</html>