<?php
session_start();
if(!isset($_SESSION['username'])){
    header("location:login.php");
}else{
?>

<?php
include 'functions.php';
// Your PHP code here.

?>

<?=template_header('Home')?>

<div class="content">
	<h2>Home</h2>
	<p>Welcome to the home page!</p>
</div>

<?=template_footer('Home')?>


<?php } ?>

