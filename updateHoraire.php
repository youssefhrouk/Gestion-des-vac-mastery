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
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['idHoraire']) ? $_POST['idHoraire'] : NULL;
        $Groupe = isset($_POST['Groupe']) ? $_POST['Groupe'] : '';
        $intitule = isset($_POST['intitule']) ? $_POST['intitule'] : '';
        $typeCours = isset($_POST['typeCours']) ? $_POST['typeCours'] : '';
        $nbrHeure = isset($_POST['nbrHeure']) ? $_POST['nbrHeure'] : '';
        $Enseignant = isset($_POST['Enseignant']) ? $_POST['Enseignant'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE horaires SET Groupe=?, intitule = ?, typeCours = ? , nbrHeure = ?, Enseignant = ? WHERE idHoraire = ?');
        $stmt->execute([$Groupe, $intitule, $typeCours, $nbrHeure, $Enseignant, $_GET['id']]);
        $msg = 'Updated Successfully!';
        header('Location: horaire.php');
    }
    // Get the vacataire from the horaires table
    $stmt = $pdo->prepare('SELECT * FROM horaires WHERE idHoraire = ?');
    $stmt->execute([$_GET['id']]);
    $horaire = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$horaire) {
        exit('horaire doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?= template_header('Read') ?>

<div class="content update">
    <h2>Modifier Horaire</h2>
    <form action="updateHoraire.php?id=<?= $horaire['idHoraire'] ?>" method="post">
        <label for="Groupe">Groupe</label>
        <input type="text" name="Groupe" value="<?= $horaire['Groupe'] ?>" id="Groupe">
        <label for="intitule">intitule</label>
        <input type="text" name="intitule" value="<?= $horaire['intitule'] ?>" id="intitule">
        <label for="typeCours">typeCours</label>
        <input type="text" name="typeCours" value="<?= $horaire['typeCours'] ?>" id="typeCours">
        <label for="user">nbrHeure</label>
        <input type="text" name="nbrHeure" value="<?= $horaire['nbrHeure'] ?>" id="nbrHeure">
        <label for="Enseignant">Enseignant</label>
        <input type="text" name="Enseignant" value="<?= $horaire['Enseignant'] ?>" id="Enseignant">

        <input type="submit" value="Modifier">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer('update') ?>
<?php } ?>