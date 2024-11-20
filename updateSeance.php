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
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['idSéance']) ? $_POST['idSéance'] : NULL;
        // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
        $Groupe = isset($_POST['Groupe']) ? $_POST['Groupe'] : '';
        $Module = isset($_POST['Module']) ? $_POST['Module'] : '';
        $Type_de_séance = isset($_POST['Type_de_séance']) ? $_POST['Type_de_séance'] : '';
        $Date = isset($_POST['Date']) ? $_POST['Date'] : '';
        $Durée = isset($_POST['Durée']) ? $_POST['Durée'] : '';
        $intituleCours = isset($_POST['intituleCours']) ? $_POST['intituleCours'] : '';
        $Heure_Démmarage = isset($_POST['Heure_Démmarage']) ? $_POST['Heure_Démmarage'] : '';
        $Heure_Fin = isset($_POST['Heure_Fin']) ? $_POST['Heure_Fin'] : '';
        $Liste_Abscence = isset($_POST['Liste_Abscence']) ? $_POST['Liste_Abscence'] : '';
        $Remarque = isset($_POST['Remarque']) ? $_POST['Remarque'] : '';
        $Salle = isset($_POST['Salle']) ? $_POST['Salle'] : '';

        $stmt = $pdo->prepare('UPDATE seance SET  Groupe = ?, Module = ? , Type_de_séance= ?,Date=?, Durée = ? ,intituleCours = ?,Heure_Démmarage=?,Heure_Fin=?,Liste_Abscence=?,Remarque=?,Salle=? WHERE idSéance = ?');
        $stmt->execute([$Groupe, $Module, $Type_de_séance, $Date, $Durée, $intituleCours, $Heure_Démmarage, $Heure_Fin, $Liste_Abscence, $Remarque, $Salle, $_GET['id']]);
        $msg = 'Updated Successfully!';
        header('Location: listeSeance.php');
    }
    // Get the vacataire from the seances table
    $stmt = $pdo->prepare('SELECT * FROM seance WHERE idSéance = ?');
    $stmt->execute([$_GET['id']]);
    $seance = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$seance) {
        exit('seance doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}

?>
<?= template_headerUser('Create') ?>

<div class="content update">
    <h2>Modifier seance </h2>
    <form action="updateSeance.php?id=<?= $seance['idSéance'] ?>" method="post">
        <label for="Groupe">Groupe</label>
        <input type="text" name="Groupe" value="<?= $seance['Groupe'] ?>" id="Groupe">
        <label for="Module">Module</label>
        <input type="text" name="Module" value="<?= $seance['Module'] ?>" id="Module">
        <label for="intituleCours">intitulé de Cours</label>
        <input type="text" name="intituleCours" value="<?= $seance['intituleCours'] ?>" id="intituleCours">
        <label for="Type_de_séance">Type_de_séance</label>
        <input type="text" name="Type_de_séance" value="<?= $seance['Type_de_séance'] ?>" id="Type_de_séance">
        <label for="Date">Date</label>
        <input type="Date" name="Date" value="<?= $seance['Date'] ?>" id="Date">
        <label for="Durée">Durée</label>
        <input type="text" name="Durée" value="<?= $seance['Durée'] ?>" id="Durée">
        <label for="Salle">Salle</label>
        <input type="text" name="Salle" value="<?= $seance['Salle'] ?>" id="Salle">
        <label for="Heure_Démmarage">Heure Démmarage</label>
        <input type="time" name="Heure_Démmarage" value="<?= $seance['Heure_Démmarage'] ?>" id="Heure_Démmarage">
        <label for="Heure_Fin">Heure Fin</label>
        <input type="time" name="Heure_Fin" value="<?= $seance['Heure_Fin'] ?>" id="Heure_Fin">
        <label for="Liste_Abscence">Liste des abscences</label>
        <input type="text" name="Liste_Abscence" value="<?= $seance['Liste_Abscence'] ?>" id="Liste_Abscence">
        <label for="Remarque">Remarque</label>
        <input type="text" name="Remarque" value="<?= $seance['Remarque'] ?>" id="Remarque">
        <input type="submit" value="Modifier" onClick="calculerTaux()">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>

</div>

<?= template_footerUser('footer') ?>
<?php } ?>