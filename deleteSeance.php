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
    $stmt = $pdo->prepare('SELECT * FROM seance WHERE idSéance = ?');
    $stmt->execute([$_GET['id']]);
    $seance = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$seance) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM seance WHERE idSéance = ?');
            $stmt->execute([$_GET['id']]);
            header('Location: listeSeance.php');
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: listeSeance.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Supprimer une seance</h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Êtes-vous sûr de supprimer cet élément?</p>
    <div class="yesno">
        <a href="deleteSeance.php?id=<?=$seance['idSéance']?>&confirm=yes">Oui</a>
        <a href="deleteSeance.php?id=<?=$seance['idSéance']?>&confirm=no">Non</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer('footer')?>
<?php } ?>