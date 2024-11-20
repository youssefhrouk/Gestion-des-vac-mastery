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

    // Prepare the SQL statement and get records from our vacataires table, LIMIT will determine the page
    $stmt = $pdo->prepare('SELECT * FROM cours ORDER BY idCours LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
    $num_cours = $pdo->query('SELECT COUNT(*) FROM cours')->fetchColumn();
    ?>

    <?= template_headerUser('Read') ?>

    <div class="content read">
        <h2>Liste des cours</h2>
        <br>
        <table>
            <thead>
                <tr>
                    <td></td>
                    <td>Module</td>
                    <td>Semestre</td>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($cours as $cour) :
                    if ($cour['Enseignant'] == $_SESSION['user']) { ?>
                        <tr>
                            <td></td>
                            <td><?= $cour['Module'] ?></td>
                            <td><?= $cour['Semestre'] ?></td>
                        </tr>
                <?php }
                endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1) : ?>
                <a href="cours.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
            <?php endif; ?>
            <?php if ($page * $records_per_page < $num_cours) : ?>
                <a href="cours.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
    </div>

    <?= template_footerUser('Read') ?>
<?php } ?>