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
    <div class="content read">
        <h2>liste des vacataires</h2>
        <a href="create.php" class="create-contact">Ajouter un vacataire</a>
     
        <table id="datatableid" class="table table-bordered ">
            <thead>
                <tr>
                    <td></td>
                    <td>Nom</td>
                    <td>Prénom</td>
                    <td>username</td>
                    <td>Email</td>
                    <td>telephone</td>
                    <td>Created</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>


                <?php foreach ($users as $vacataire) :
                    if($vacataire['usertype']!='admin'){
                    ?>
                    
                    <tr>
                        <td></td>
                        <td><?= $vacataire['Nom'] ?></td>
                        <td><?= $vacataire['Prenom'] ?></td>
                        <td><?= $vacataire['username'] ?></td>
                        <td><?= $vacataire['Email'] ?></td>
                        <td><?= $vacataire['Telephone'] ?></td>
                        <td><?= $vacataire['Created'] ?></td>
                        <td class="actions">
                            <a href="update.php?id=<?= $vacataire['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                            <a href="delete.php?id=<?= $vacataire['id'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                        </td>
                    </tr>
                <?php } endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1) : ?>
                <a href="read.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
            <?php endif; ?>
            <?php if ($page * $records_per_page < $num_users) : ?>
                <a href="read.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatableid').DataTable();
        });
    </script>

    <?= template_footer('Read') ?>
<?php } ?>