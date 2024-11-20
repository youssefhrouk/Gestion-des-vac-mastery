<?php
session_start();
include 'functions.php';
$pdo = pdo_connect_mysql();

// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['idCours']) && !empty($_POST['idCours']) && $_POST['idCours'] != 'auto' ? $_POST['idCours'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $mt = isset($_POST['Module']) ? $_POST['Module'] : '';
    $sm = isset($_POST['Semestre']) ? $_POST['Semestre'] : '';
    $ens= isset($_POST['Enseignant']) ? $_POST['Enseignant'] : '';
  

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO cours VALUES (?,?, ?,?)');
    $stmt->execute([$id,$mt, $sm,$ens]);
    // Output message
    header("location:listeCours.php");
}
?>

<?= template_header('Create') ?>

<div class="content update">
    <h2>Ajouter un cours</h2>
    <form action="ajoutCours.php" method="post">
        <label for="Module">Module</label>
        <input type="text" name="Module" id="Module">
        <label for="Semestre">Semestre</label>
        <input type="text" name="Semestre" id="Semestre">
        <label for="Enseignant">Enseignant</label>
        <input type="text" name="Enseignant" id="Enseignant">

        <input type="submit" value="Créer">
    </form>

</div>

<?= template_footer('footer') ?>