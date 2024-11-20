<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
} else {
?>

    <?php
	include 'functions.php';
    // Connect to MySQL database
    $pdo = pdo_connect_mysql();
    // on obtient la page par method get  (URL param: page), s'il n'existe pas par défaut  1
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Nombre de chaque ligne pour l'afficher dans chaque ligne
    $records_per_page = 5;

    // Prepare the SQL statement and get records from our users table, LIMIT will determine the page
    $stmt = $pdo->prepare('SELECT * FROM users ORDER BY id  LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
    $num_users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    ?>

    <?= template_header('Read') ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
	<link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" type="text/css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <title>Document</title>
    </head>
	
	   <?php 
	if (isset($_POST['search'])){
		?>
	<body>
	<div class="content read">
		<h2>liste users</h2>
	</div>
	<table id="datatableid" class="table table-bordered ">
		<thead>
		<tr>
                        <td>id</td>
                        <td>Nom</td>
                        <td>Prénom</td>
                        <td>username</td>
                        <td>Email</td>
                        <td>password</td>
                        <td>telephone</td>
                        <td>Created</td>
                        <td>Action</td>
                    </tr>
		</thead>
		<tbody>
			<?php
			$keyword = $_POST['keyword'];
			$query = $pdo->prepare("SELECT * FROM `users` WHERE `Nom` LIKE '%$keyword%' or `Prenom` LIKE '%$keyword%' or `username` LIKE '%$keyword%'");
			$query->execute();
			while ($row = $query->fetch()) {
			?>
				<tr>
				<td><?php echo $row['id'] ?></td>

					
				    <td><?php echo $row['Nom'] ?></td>
					<td><?php echo $row['Prenom'] ?></td>
					<td><?php echo $row['username'] ?></td>
					<td><?php echo $row['Email'] ?></td>
					<td><?php echo $row['password'] ?></td>
					<td><?php echo $row['Telephone'] ?></td>
					<td><?php echo $row['Created'] ?></td>
				</tr>


			<?php
			}
			?>
		</tbody>
	</table>
	<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script>
$(document).ready(function () {
    $('#datatableid').DataTable();
});

</script>
<?php
} else {
?>
	<table class="table table-bordered">
		<thead class="alert-info">
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>username</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$query = $pdo->prepare("SELECT * FROM `users`");
			$query->execute();
			while ($row = $query->fetch()) {
			?>
				<tr>
					<td><?php echo $row['Nom'] ?></td>
					<td><?php echo $row['Prenom'] ?></td>
					<td><?php echo $row['username'] ?></td>
				</tr>


			<?php
			}
			?>
		</tbody>
	</table>


<?php
}
?>
</body>
</html>
<?php
}
?>