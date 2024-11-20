<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
} else {
?>
    <?php
    include 'functions.php';
    $pdo = pdo_connect_mysql();
    $msg = '';
    // Check if POST data is not empty
    if (!empty($_POST)) {
        // Post data not empty insert a new record
        // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
        $id = isset($_POST['idHoraire']) && !empty($_POST['idHoraire']) && $_POST['idHoraire'] != 'auto' ? $_POST['idHoraire'] : NULL;
        // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
        $groupe=isset($_POST['Groupe']) ? $_POST['Groupe'] : '';
        $intitule = isset($_POST['intitulé']) ? $_POST['intitulé'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $nbrheure = isset($_POST['nbrHeures']) ? $_POST['nbrHeures'] : '';
        $Enseignant = isset($_POST['Enseignant']) ? $_POST['Enseignant'] : '';
        $valide="n";
        // Insert new record into the contacts table
        $stmt = $pdo->prepare('INSERT INTO horaires VALUES (?, ?, ?, ?, ?,?,?)');
        $stmt->execute([$id,$groupe, $intitule, $type, $nbrheure, $Enseignant,$valide]);
        // Output message
        $msg = 'Created Successfully!';
        header("location:horaire.php");
    }
    ?>

    <?= template_header('Creer') ?>

    <div class="content update">
        <h2>Ajoute un Horaire</h2>
        <form action="ajoutHoraire.php" method="post">

            <label for="Groupe">Groupe</label>
            <input type="text" name="Groupe" placeholder="Groupe" id="Groupe">
            
            <label for="intitulé">intitulé cours</label>
            <input type="text" name="intitulé" placeholder=" intitulé cours" id="intitule">

            <label for="type">type</label>
            <input type="text" name="type" placeholder="type cours" id="type">

            <label for="nbr">nombre Heures</label>
            <input type="text" name="nbrHeures" placeholder="nombre d'heures" id="nbr">

            <label for="Enseignant">Enseignant</label>
            <input type="text" name="Enseignant" placeholder="Enseignant" id="Enseignant">

            <input type="submit" value="Créer">
        </form>
        <?php if ($msg) : ?>
            <p><?= $msg ?></p>
        <?php endif; ?>
    </div>

    <?= template_footer('footer') ?>

<?php } ?>