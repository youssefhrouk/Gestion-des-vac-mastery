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
    $nom = $_SESSION['user'];
    // Prepare the SQL statement and get records from our seance table, LIMIT will determine the page
    $stmt = $pdo->prepare('SELECT Groupe,Module,Type_de_séance,NomVacataire,SUM(Durée) as somme FROM seance where NomVacataire=? group by Groupe,Type_de_séance');
    $stmt->execute([$nom]);
    // Fetch the records so we can display them in our template.
    $seance = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
    $num_seance = $pdo->query('SELECT COUNT(*) FROM seance ')->fetchColumn();

    $stmt1 = $pdo->prepare('SELECT * FROM horaires where Enseignant=? group by Groupe');
    $stmt1->execute([$nom]);
    $horaire = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <?= template_headerUser('Read') ?>

    <div class="content read">
        <h2>Taux d'avancement par groupe</h2>
        <br>
        <table id="table">
            <thead>
                <tr>
                    <td></td>
                    <td>Groupe</td>
                    <td>Module</td>
                    <td>Type de Cours</td>
                    <td>Masse Horaire</td>
                    <td>%P </td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($horaire as $horaire) :
                    foreach ($seance as $seance) {
                        if ($seance['NomVacataire'] == $nom && $horaire['nbrHeure'] != 0) {
                            $p = ($seance['somme'] / $horaire['nbrHeure']) * 100;
                ?>
                            <tr>
                                <td></td>
                                <td><?= $seance['Groupe'] ?></td>
                                <td><?= $seance['Module'] ?></td>
                                <td><?= $seance['Type_de_séance'] ?></td>
                                <td><?= $seance['somme'] ?>h</td>
                                <td><?= $p ?>%</td>
                            </tr>
                <?php
                        }
                    }
                endforeach;
                ?>
            </tbody>
        </table>
        <?php
        $nom = $_SESSION['user'];
        // Prepare the SQL statement and get records from our seance table, LIMIT will determine the page
        $stmt = $pdo->prepare('SELECT Groupe,Module,Type_de_séance,NomVacataire,SUM(Durée) as somme FROM seance where NomVacataire=? group by Groupe,Type_de_séance');
        $stmt->execute([$nom]);
        // Fetch the records so we can display them in our template.
        $seance = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
        $num_seance = $pdo->query('SELECT COUNT(*) FROM seance ')->fetchColumn();

        $stmt1 = $pdo->prepare('SELECT * FROM horaires where Enseignant=? group by Groupe');
        $stmt1->execute([$nom]);
        $horaire = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h2>Horaire restant</h2>
        <br>
        <table>
            <thead>
                <tr>
                    <td></td>
                    <td>Groupe</td>
                    <td>Module</td>
                    <td>Type de Cours</td>
                    <td>Nombre d'heures</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($horaire as $horaire) :
                    foreach ($seance as $seance) {
                        if ($seance['NomVacataire'] == $horaire['Enseignant']) {
                            $r = $horaire['nbrHeure'] - $seance['somme'];
                ?>
                            <tr>
                                <td></td>
                                <td><?= $seance['Groupe'] ?></td>
                                <td><?= $seance['Module'] ?></td>
                                <td><?= $seance['Type_de_séance'] ?></td>
                                <td><?= $r ?>h</td>
                            </tr>
                <?php
                        }
                    }
                endforeach;
                ?>
            </tbody>
        </table>


        <div class="pagination">
            <?php if ($page > 1) : ?>
                <a href="tauxAvance.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
            <?php endif; ?>
            <?php if ($page * $records_per_page < $num_seance) : ?>
                <a href="tauxAvance.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
        <input type="button" value="Exporter" onclick="exporttoexcel()">
    </div>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>



    <?= template_footerUser('Read') ?>
<?php } ?>
<script>
	function exporttoexcel() {
	var table = document.getElementById("table");
	var html = table.outerHTML;
	window.open('data:application/vnd.ms-excel,' + escape(html));
	}
</script>
