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
        $id = isset($_POST['idCours']) ? $_POST['idCours'] : NULL;
        $mt = isset($_POST['Module']) ? $_POST['Module'] : '';
        $sem = isset($_POST['Semestre']) ? $_POST['Semestre'] : '';
        $ens = isset($_POST['Enseignant']) ? $_POST['Enseignant'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE cours SET  Module = ?, Semestre = ? ,Enseignant=? WHERE idCours = ?');
        $stmt->execute([ $mt,  $sem, $ens, $_GET['id']]);
        header("location:listeCours.php");
        //$msg = 'Updated Successfully!';
    }
    // Get the cours from the cours table
    $stmt = $pdo->prepare('SELECT * FROM cours WHERE idCours = ?');
    $stmt->execute([$_GET['id']]);
    $cours = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$cours) {
        exit('cours doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Modifier cours </h2>
    <form action="editCours.php?id=<?=$cours['idCours']?>" method="post">
        
        <label for="idCours">idCours</label>
        <input type="text" name="idCours"  value="<?=$cours['idCours']?>" id="idCours">
        <label for="email">Module</label>
        <input type="text" name="Module" placeholder="intitule module" value="<?=$cours['Module']?>" id="email">
        <label for="Semestre">Semestre</label>
        <input type="text" name="Semestre" placeholder="Semestre" value="<?=$cours['Semestre']?>" id="Semestre">
        <label for="Enseignant">Enseignant</label>
        <input type="text" name="Enseignant" placeholder="Enseignant" value="<?=$cours['Enseignant']?>" id="Enseignant">
       
        <input type="submit" value="Modifier">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer('update')?>

<?php } ?>
