<?php
session_start();
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM cours WHERE intitulé = ?');
    $stmt->execute([$_GET['id']]);
    $cours = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$cours) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM cours WHERE intitulé = ?');
            $stmt->execute([$_GET['id']]);
            header('Location: listeCours.php');
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
	<h2>Delete Cours #<?=$cours['intitulé']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete contact #<?=$cour['intitulé']?>?</p>
    <div class="yesno">
        <a href="supprimerCours.php?id=<?=$cours['intitulé']?>&confirm=yes">Yes</a>
        <a href="supprimerCours.php?id=<?=$cours['intitulé']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer('footer')?>