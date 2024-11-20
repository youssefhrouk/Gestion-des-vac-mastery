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

    // Prepare the SQL statement and get records from our horaires table, LIMIT will determine the page
    $stmt = $pdo->prepare('SELECT * FROM horaires ORDER BY IDHoraire LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $horaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
    $num_horaires = $pdo->query('SELECT COUNT(*) FROM horaires')->fetchColumn();
    ?>

    <?= template_header('horaire') ?>

    <div class="content read">
        <h2>Horaires de cours</h2>
        <a href="ajoutHoraire.php" class="create-contact">Ajoute horaire</a>
        <table id="datatableid">
            <thead>
                <tr>
                    <td></td>
                    <td>Groupe</td>
                    <td>Module</td>
                    <td>Type de cours</td>
                    <td>Nombre d'heures</td>
                    <td>Enseignant</td>
                    <td>valider</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires as $horaire) : ?>
                    <tr>
                        <td></td>
                        <td><?= $horaire['Groupe'] ?></td>
                        <td><?= $horaire['intitule'] ?></td>
                        <td><?= $horaire['typeCours'] ?></td>
                        <td><?= $horaire['nbrHeure'] ?></td>
                        <td><?= $horaire['Enseignant'] ?></td>
                        <td><?= $horaire['valide'] ?></td>
                        <td class="actions">
                            <a href="updateHoraire.php?id=<?= $horaire['idHoraire'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                            <a href="deleteHoraire.php?id=<?= $horaire['idHoraire'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1) : ?>
                <a href="horaire.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
            <?php endif; ?>
            <?php if ($page * $records_per_page < $num_horaires) : ?>
                <a href="horaire.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#datatableid').DataTable();
        });
    </script>
    <?= template_footer('horaire') ?>
<?php } ?>