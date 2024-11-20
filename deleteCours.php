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
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM cours WHERE idCours = ?');
    $stmt->execute([$_GET['id']]);
    $cours = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$cours) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM cours WHERE idCours = ?');
            $stmt->execute([$_GET['id']]);
            header('Location:listeCours.php');
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: listeCours.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Supprimer cours </h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Êtes-vous sûr de supprimer cet élément?</p>
    <div class="yesno">
        <a href="deleteCours.php?id=<?=$cours['idCours']?>&confirm=yes">Oui</a>
        <a href="deleteCours.php?id=<?=$cours['idCours']?>&confirm=no">Non</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer('footer')?>
<?php } ?>