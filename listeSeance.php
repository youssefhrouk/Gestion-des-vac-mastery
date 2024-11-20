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
    $records_per_page = 10;

    // Prepare the SQL statement and get records from our seance table, LIMIT will determine the page
    $stmt = $pdo->prepare('SELECT * FROM seance ORDER BY idSéance  LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $seance = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
    $num_seance = $pdo->query('SELECT COUNT(*) FROM seance')->fetchColumn();
    ?>

    <?= template_headerUser('Read') ?>

        <div class="content read">
            <h2>Liste des séances réalisées</h2>
            <a href="ajoutSeance.php" class="create-contact">Nouvelle séance</a>

            <div class="col-md-8">
                <form method="POST" action="listeSeance.php">
                    <div class="form-inline">
                        <input type="text" class="form-control" name="keyword" placeholder="Cherche ici..." required="required" />
                        <button class="btn btn-success" name="search">Chercher</button>
                    </div>
                </form>
                <br /><br />
            </div>
            <table idSéance="datatableidSéance"  id="table">
                <thead>
                    <tr>
                        <td></td>
                        <td>Groupe</td>
                        <td>Module</td>
                        <td>intitule de Cours</td>
                        <td>Type de séance</td>
                        <td>Date</td>
                        <td>Durée</td>
                        <td>Salle</td>
                        <td>Heure Démmarage</td>
                        <td>Heure Fin</td>
                        <td>Liste Abscence</td>
                        <td>Remarque</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>


                    <?php
                    foreach ($seance as $seance) :
                        if ($seance['NomVacataire'] == $_SESSION['user']) {                            ?>
                            <tr>
                                <td></td>
                                <td><?= $seance['Groupe'] ?></td>
                                <td><?= $seance['Module'] ?></td>
                                <td><?= $seance['intituleCours'] ?></td>
                                <td><?= $seance['Type_de_séance'] ?></td>
                                <td><?= $seance['Date'] ?></td>
                                <td><?= $seance['Durée'] ?></td>
                                <td><?= $seance['Salle'] ?></td>
                                <td><?= $seance['Heure_Démmarage'] ?></td>
                                <td><?= $seance['Heure_Fin'] ?></td>
                                <td><?= $seance['Liste_Abscence'] ?></td>
                                <td><?= $seance['Remarque'] ?></td>

                                <td class="actions">
                                    <a href="updateSeance.php?id=<?= $seance['idSéance'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                                    <a href="deleteSeance.php?id=<?= $seance['idSéance'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                                </td>
                            </tr>
                    <?php }
                    endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php if ($page > 1) : ?>
                    <a href="voirlistseance.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
                <?php endif; ?>
                <?php if ($page * $records_per_page < $num_seance) : ?>
                    <a href="voirlistseance.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
                <?php endif; ?>
            </div>
            <input type="button" value="Exporter" onclick="exporttoexcel()">
            </div>
      
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#datatableidSéance').DataTable();
            });
        </script>

    <?= template_footerUser('Read') ?>
<?php } ?>
<script>
	function exporttoexcel() {
	var table = document.getElementById("table");
	var html = table.outerHTML;
	window.open('data:application/vnd.ms-excel,' + escape(html));
	}
</script>
