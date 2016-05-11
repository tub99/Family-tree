<html>
<head>
	<link rel="stylesheet" type="text/css" href="pages/styling.css">
</head>
<body id="indexBody">
	<h1 align="center">Family Tree Application</h1>
<a href="http://localhost/familyTree/pages/details.php" id="detailLink">CLICK HERE TO VIEW DETAILS OF PERSONS</a>
<?php 
 $counter = 0;
 $flag=false;

 ?>
 <div id="index">
 	<h3>Admin Login</h3>
	<form action="" method="post" id="loginForm">
		UserName: <input type="text" name="username" id="adminUserName"><br>
		Password:<input type="password" name="password" id="adminPassword"><br><br>
		<div id="login" align="center">
			<input type="submit" value="Login" name="login" id="loginBt"></input>
		</div>
	</form>

	<?php

	 session_start();


	// when user hits login button
	if(!empty($_POST['login'])){
		//checking whether $_SESSION['num_login_fail'] is set or not
			if(isset($_SESSION['num_login_fail'])){

			  if($_SESSION['num_login_fail'] == 3){
			     if(time() - $_SESSION['last_login_time'] < 60 ){
			         // alert to user wait for 10 minutes afer
			      	echo "Try re-logging after 60 secs";
			          return; 
			      }
			      else{
			        //after 1 minute
			         $_SESSION['num_login_fail'] = 0;
			      }
			   }      
			}
			else
				$_SESSION['num_login_fail'] = 0;

			//check status for login
			$success = doLogin();// check login function


			if($success=="true")
				{
				   $_SESSION['num_login_fail'] = 0;
				   //your code here
				   header('Location: http://localhost/familyTree/pages/welcome.php');
				}
				else
				{
					 $_SESSION['num_login_fail']++;
					 $_SESSION['last_login_time'] = time();
				}
	}
			
	// This function validates admin login
		function doLogin(){
			$salt = '$2a$07$usesomadasdsadsadsadasdasdasdsadesillystringfors';
			$digestPass = crypt('password123', $salt);
			$digestUser=crypt('admin',$salt);
			$name= $_POST["username"];
			$pass = $_POST["password"];
			// checking userName and password
			if((crypt($name, $digestUser) == $digestUser) && (crypt($pass, $digestPass) == $digestPass))
			{
				echo "Success";
				
				return "true";
			 }
			else{
				
				echo "Wrong userName or Password.";
				return "false";
			}

		}

		
	?>
</div>
</body>
</html>