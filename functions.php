<?php

function pdo_connect_mysql()
{
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = '';
	$DATABASE_NAME = 'gesvacataire';
	try {
		return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
	} catch (PDOException $exception) {
		// If there is an error with the connection
		exit('Failed to connect to database!');
	}
}

function template_header($title)
{ 
	$s=$_SESSION['user'];
	echo <<<EOT
	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="stylenav.css" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
		<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
						
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		

	</head>
	<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-black">
    <div class="container-fluid">
		<a class="navbar-brand" href="#">
		<img src="Capture.PNG" alt="Avatar Logo" style="width:240px;" class="rounded-pill">
		</a>
		<a href="admin_home.php"><i class="fa-solid fa-user"></i> $s</a>
		<a href="horaire.php"><i class="fa-solid fa-calendar-check"> </i>Horaire</a>
		<a href="avancement.php"><i class="fa-solid fa-file-invoice"></i>Avancement</a>
		<a href="listeCours.php"><i class="fa-solid fa-chalkboard-user"></i>Cours</a>
		<a href="read.php"><i class="fa-solid fa-user"></i>Liste des vacataires</a>
		<a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Déconnexion</a>

		<a class="navbar-brand" href="#">
			<img src="logofssm.png" alt="Avatar Logo" style="width:290px;" class="rounded-pill">
		</a>
    </div>
  </nav>
	
EOT;
}
function template_footer($footer)
{
	echo <<<EOT
<html
<head>
<meta charset="utf-8">
		<title>$footer</title>
		<link href="stylenav.css" rel="stylesheet" type="text/css">
	
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<style>
 
        footer{
            background: rgb(5, 5, 5);
			position: relative;
			top:100%;
        }
        a:link{
            color: #fff;
            text-decoration: none;
        }
        a:visited{
            color: #fff;
            text-decoration: none;
        }
        a:hover{
            color: #fff;
            text-decoration: none;
        }
        a:active{
            color: #fff;
            text-decoration: none;
        }
    </style>
	</head>
<body>
<footer>
<div class="footer-bottom">
<p>copyright &copy;2022 FSSM. designée par <span>Youssef hrouk & EL Masaoudy Saida</span></p>
</div>
</footer>
</body>
</html>
EOT;
}
function template_headerUser($title)
{
	$s=$_SESSION['user'];
	echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
	    <link href="stylenav.css" rel="stylesheet" type="text/css">
	
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
		<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

				
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	</head>
	<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-black">
    <div class="container-fluid">
		<a class="navbar-brand" href="#">
		<img src="Capture.PNG" alt="Avatar Logo" style="width:240px;" class="rounded-pill">
		</a>
		<a href="user_home.php"><i class="fa-solid fa-user"></i>$s</a>
		<a href="HoraireV.php"><i class="fa-solid fa-calendar-check"> </i>Horaires</a>
		<a href="listeSeance.php"><i class="fa-solid fa-file-invoice"></i>Cahier de textes</a>
		<a href="tauxAvance.php"><i class="fa-solid fa-file-invoice"></i>Taux d'avancement</a>
		<a href="cours.php"><i class="fa-solid fa-chalkboard-user"></i>Cours</a>
		<a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Déconnexion</a>

		<a class="navbar-brand" href="#">
			<img src="logofssm.png" alt="Avatar Logo" style="width:290px;" class="rounded-pill">
		</a>
    </div>
  </nav>
   
EOT;
}
function template_footerUser($footer)
{
	echo <<<EOT
<html
<head>
<meta charset="utf-8">
		<title>$footer</title>
		<link href="stylenav.css" rel="stylesheet" type="text/css">
	
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<style>
 
        footer{
            background: rgb(5, 5, 5);
			position: relative;
			top:100%;
        }
        a:link{
            color: #fff;
            text-decoration: none;
        }
        a:visited{
            color: #fff;
            text-decoration: none;
        }
        a:hover{
            color: #fff;
            text-decoration: none;
        }
        a:active{
            color: #fff;
            text-decoration: none;
        }
    </style>
	</head>
<body>
<footer>
<div class="footer-bottom">
<p>copyright &copy;2022 FSSM. designée par <span>Youssef hrouk & EL Masaoudy Saida</span></p>
</div>
</footer>
</body>
</html>
EOT;
}