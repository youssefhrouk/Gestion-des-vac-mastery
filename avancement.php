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
	$stmt1 = $pdo->prepare('SELECT nbrHeure FROM horaires group by Enseignant,Groupe');
	$stmt1->execute();
	$horaire = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	$num_seances = $pdo->query('SELECT COUNT(*) FROM seance')->fetchColumn();
	$add = $pdo->prepare('SELECT Groupe,Module,Type_de_séance,NomVacataire,SUM(Durée) as somme FROM seance group by NomVacataire,Groupe,Type_de_séance');
	$add->execute();
	// Fetch the records so we can display them in our template.
	$taux = $add->fetchAll(PDO::FETCH_ASSOC);
	?>
<?php




	// Connect to MySQL database
	
	// on obtient la page par method get  (URL param: page), s'il n'existe pas par défaut  1
	$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
	// Nombre de chaque ligne pour l'afficher dans chaque ligne
	$records_per_page = 5;

	// Prepare the SQL statement and get records from our seance table, LIMIT will determine the page
	$stmt = $pdo->prepare('SELECT * FROM seance ORDER BY idSéance LIMIT :current_page, :record_per_page');
	$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
	$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
	$stmt->execute();
	// Fetch the records so we can display them in our template.
	$seance = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
	$num_seances = $pdo->query('SELECT COUNT(*) FROM seance')->fetchColumn();
	?>

	<?= template_header('seance') ?>

	<div class="content read">
		
	<h2>Séances réalisées de chaque vacataire</h2>
		<br>
		<!--<a href="ajoutseance.php" class="create-contact">Ajouter une seance</a>-->
		<table id="table">
			<thead>
				<tr>
					<td></td>
					<td>Nom Vacataire</td>
					<td>Groupe</td>
					<td>Module</td>
					<td>intitule de Cours</td>
					<td>Type de séance</td>
					<td>Date</td>
					<td>Durée</td>
					<td>Heure Démmarage</td>
					<td>Heure Fin</td>
					<td>Liste Abscence</td>
					<td>Remarque</td>
					

				</tr>
			</thead>
			<tbody>


				<?php foreach ($seance as $seance) : ?>
					<tr>
						<td></td>
						<td><?= $seance['NomVacataire'] ?></td>
						<td><?= $seance['Groupe'] ?></td>
						<td><?= $seance['Module'] ?></td>
						<td><?= $seance['intituleCours'] ?></td>
						<td><?= $seance['Type_de_séance'] ?></td>
						<td><?= $seance['Date'] ?></td>
						<td><?= $seance['Durée'] ?></td>
						<td><?= $seance['Heure_Démmarage'] ?></td>
						<td><?= $seance['Heure_Fin'] ?></td>
						<td><?= $seance['Liste_Abscence'] ?></td>
						<td><?= $seance['Remarque'] ?></td>
						

					<?php endforeach; ?>
			</tbody>
		</table>
		<br>
		<input type="button" value="Exporter" onclick="exporttoexcel()">
		<h2>Taux d'avancement de chaque vacataire</h2>
		<br>
		<!--<a href="ajoutseance.php" class="create-contact">Ajouter une seance</a>-->
		<table>
			<thead>
				<tr>
					<td></td>
					<td>Nom Vacataire</td>
					<td>Groupe</td>
					<td>Module</td>
					<td>Type de séance</td>
					<td>Masse Horaire</td>
					

				</tr>
			</thead>
			<tbody>
				<?php
				
					foreach ($taux as $taux) {
						
				?>
							<tr>
								<td></td>
								<td><?= $taux['NomVacataire'] ?></td>
								<td><?= $taux['Groupe'] ?></td>
								<td><?= $taux['Module'] ?></td>
								<td><?= $taux['Type_de_séance'] ?></td>
								<td><?= $taux['somme'] ?>h</td>
								
					<?php }
					
				
					?>
			</tbody>
		</table>

		<div class="pagination">
			<?php if ($page > 1) : ?>
				<a href="avancement.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
			<?php endif; ?>
			<?php if ($page * $records_per_page < $num_seances) : ?>
				<a href="avancement.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
			<?php endif; ?>
		</div>
	</div>
	<?= template_footer('seance') ?>
<?php } ?>
<script>
	function exporttoexcel() {
	var table = document.getElementById("table");
	var html = table.outerHTML;
	window.open('data:application/vnd.ms-excel,' + escape(html));
	}
</script>
