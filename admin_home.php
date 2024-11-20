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
    //$nom=$_SESSION['user'];
    // Prepare the SQL statement and get records from our users table, LIMIT will determine the page
    $stmt = $pdo->prepare('SELECT * FROM users where username=? ORDER BY id');
    $stmt->execute([$_SESSION['user']]);
    // Fetch the records so we can display them in our template.
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the total number of contacts, this is so we can determine whether there should be a next and previous button
    $num_users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    ?>

    <?= template_header('Read') ?>
    <div class="content update">
        <h2> Informations </h2>
        <form action="modifierAdmin.php">
            <?php foreach($users as $user):?>
            <label> Nom :</label>
            <input value="<?=$user['Nom'] ?>">
            <label> Prenom :</label>
            <input value="<?=$user['Prenom'] ?>">
            <label> Email :</label>
            <input value="<?=$user['Email'] ?>">
            <label> Telephone :</label>
            <input value="<?=$user['Telephone'] ?>">
            <label> Departement :</label>
            <input value="<?php echo $_SESSION['dep']; ?>">

            <?php endforeach ?>
            <hr class="bg-primary">
                	    <ul class="list-unstyled d-flex justify-content-center mt-4">
                            <input type="submit" style="background-color:#A9A9A9;color:white;border-radius: 10px;" value="modifier mes informations">
	               		</ul>  
        </form>
    </div>
    <?= template_footer('Read') ?>
<?php
}
?>