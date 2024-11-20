<?php
if(isset($_SESSION['user'])) {
 
  header("Location:.php"); // redirects them to homepage
  exit; // for good measure
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <style>
    <?php session_start(); ?>@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@500&display=swap');
  </style>
  <style>
    body,
    html {
      height: 100%;
      /* font-family: Arial, Helvetica, sans-serif; */
      font-family: 'Kanit', sans-serif;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    .bg-img {
      /* background-image: url("https://ecampus-fssm.uca.ma/pluginfile.php/1/theme_moove/sliderimage1/1644966511/FSSM_image.jpg"); */
      min-height: 550px;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
      /* height: 100vh; */
      background-color: #c0c0c0;
    }


    .container {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      margin: 20px;
      max-width: 350px;
      height: 400px;
      padding: 16px;
      background-image: url("bg-cool.png");
      border-radius: 5%;
    }

    input[type=text],
    input[type=password] {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      border: none;
      background: #f1f1f1;
    }

    input[type=text]:focus,
    input[type=password]:focus {
      background-color: #ddd;
      outline: none;
    }


    .btn {
      background-color: #B05C00;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      width: 100%;
      opacity: 0.9;
    }

    .btn:hover {


      opacity: 1;
    }

    .footer {
      /* position: fixed; */
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: #BEA6A0;
      color: white;
      text-align: center;
    }

    #h1 {
      text-align: center;
    }

    .rounded-pill {
      /* float: right; */
      margin-right: 0px;
      /* margin-left: auto ; */
    }


    body {
      background: #fcfcfc;
    }

    footer {
      position: absolute;
      bottom: 5;
      left: 5;
      right: 5;
      background: #111;
      height: auto;
      width: 100vw;
      font-family: "Open Sans";
      padding-top: 40px;
      color: #fff;
    }

    .footer-content {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
    }

    .footer-content h3 {
      font-size: 1.8rem;
      font-weight: 400;
      text-transform: capitalize;
      line-height: 3rem;
    }

    .footer-content p {
      max-width: 500px;
      margin: 10px auto;
      line-height: 28px;
      font-size: 14px;
    }

    .social-links {
      list-style: none;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 1rem 0 3rem 0;
    }

    .social-links li {
      margin: 0 10px;
    }

    .social-links a {
      text-decoration: none;
      color: #fff;
    }

    .social-links a i {
      font-size: 1.1rem;
      transition: color .4s ease;

    }

    .social-links a:hover i {
      color: aqua;
    }

    .footer-bottom {
      background: #000;
      width: 100vw;
      padding: 20px 0;
      text-align: center;
    }

    .footer-bottom p {
      font-size: 14px;
      word-spacing: 2px;
      text-transform: capitalize;
    }

    .footer-bottom span {
      text-transform: uppercase;
      opacity: .4;
      font-weight: 200;
    }



    .navbar {
      width: 100%;
      height: 17vh;
      display: flex;
      align-items: center;

    }

    .navbar div {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-image: url("bg-cool.png");
    }

    .err {
      color: red;
      font-size: 20px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-black">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="Capture.PNG" alt="Avatar Logo" style="width:240px;" class="rounded-pill">
      </a>
      <a class="navbar-brand" href="#">
        <img src="logofssm.png" alt="Avatar Logo" style="width:290px;" class="rounded-pill">
      </a>
    </div>
  </nav>

  <div class="bg-img ">
    <form action="login.php" method="POST" >
      <div class="container">
        <h1 id="h1">Login</h1>

        <label for="username"><b>Utilisateur</b></label>
        <input type="text" placeholder="Entrez votre username" name="username" />

        <label for="password"><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrez votre Mot de passe" name="password" />
        <div class="err text-danger text-center my-3"></div>
        <button type="submit" class="btn" name="login">Connexion</button>
      </div>
    </form>
  </div>
  <!-- <div class="footer">
<p style="color: black; padding: 10px 0;" align="center";background-color="blue">
	&copy; 2022 Copyright:FSSM <a href="mailto:yhrouk@gmail.com">Créer par:youssef </a>
</p>
</div> -->


  <footer>
    <div class="footer-content">
      <h3>Contactez-nous</h3>
      <p>
        faculté des sciences Semlalia route moulay abdellah, Marrakech<br />
        458000 / Marrakech<br />
        N° Tél : 06 13 07 03 88 <br />
        yhrouk@gmail.com<br />
      </p>
      <ul class="social-links">
        <li><a href="https://www.facebook.com/YoussefHr2001/"><i class="fab fa-facebook-f"></i></a></li>
        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
        <li><a href="https://www.instagram.com/youssef.hrouk/"><i class="fab fa-instagram"></i></a></li>
        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
        <li><a href="https://www.linkedin.com/in/"><i class="fab fa-linkedin-in"></i></a></li>
      </ul>
    </div>
    <div class="footer-bottom">
      <p>copyright &copy;2022 FSSM. designée par <span>Youssef hrouk & EL Masaoudy Saida</span></p>
    </div>


    <?php

    include("functions.php");


    $con = pdo_connect_mysql();


    $sql = "select * from users";
    $user = $con->query($sql);


    if (isset($_POST['login'])) {
      foreach ($user as $row) {

        if (empty($_POST["username"]) || empty($_POST["password"])) {

          echo "<script>document.querySelector('.err').textContent='vous devez remplir tout les champs'</script>";
        } elseif ($_POST["username"] == $row['username'] && $_POST['password'] == $row['password'] && $row['usertype'] == 'admin') {
          $_SESSION['user'] = $row['username'];
          $_SESSION['Prenom'] = $row['Prenom'];
          $_SESSION['Nom'] = $row['Nom'];
          $_SESSION['Email'] = $row['Email'];
          $_SESSION['usertype'] = $row['usertype'];
          $_SESSION['photo'] = $row['photo'];
          $_SESSION['tel'] = $row['Telephone'];
          $_SESSION['dep'] = 'Departement Informatique';
          echo "<script> window.location.href='admin_home.php'</script>";
        } elseif ($_POST['username'] == $row['username'] && $_POST['password'] == $row['password'] && $row['usertype'] == 'user') {
          $_SESSION['user'] = $row['username'];
          $_SESSION['Prenom'] = $row['Prenom'];
          $_SESSION['Nom'] = $row['Nom'];
          $_SESSION['usertype'] = $row['usertype'];
          $_SESSION['Email'] = $row['Email'];
          $_SESSION['photo'] = $row['photo'];
          $_SESSION['tel'] = $row['Telephone'];
          $_SESSION['psw'] = $row['password'];
          $_SESSION['dep'] = 'Departement Informatique';
          echo "<script> window.location.href='user_home.php'</script>";
        } else {
          echo "<script>document.querySelector('.err').textContent='Mot de passe ou username incorrect!!'</script>";
        }
      }
    }
    ?>
  </footer>

</body>

</html>