<?php

session_start();
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
        $user = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['Telephone']) ? $_POST['Telephone'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE users SET  Nom = ?, Prenom = ? , username = ?, Email = ?, password = ?, Telephone = ?, Created = ? WHERE id = ?');
        $stmt->execute([$nom, $prenom, $user, $email, $password, $phone,  $created, $_GET['id']]);
        $msg = 'Updated Successfully!';
        header('Location: read.php');
    }
    // Get the vacataire from the users table
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $vacataire = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$vacataire) {
        exit('Vacataire doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?= template_header('Read') ?>

<div class="content update">
    <h2>Modifier les informations</h2>
    <form action="update.php?id=<?= $vacataire['id'] ?>" method="post">

        <label for="nom">Nom</label>
        <input type="text" name="nom" placeholder="josef" value="<?= $vacataire['Nom'] ?>" id="nom">
        <label for="prenom">Prenom</label>
        <input type="text" name="prenom" placeholder="luis" value="<?= $vacataire['Prenom'] ?>" id="prenom">
        <label for="user">username</label>
        <input type="text" name="username" placeholder="johndoe" value="<?= $vacataire['username'] ?>" id="user">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="johndoe@example.com" value="<?= $vacataire['Email'] ?>" id="email">
        <label for="mdp">Mot de passe</label>
        <input type="password" name="password" placeholder="votre password" value="<?= $vacataire['password'] ?>" id="mdp">
        <label for="phone">Phone</label>
        <input type="text" name="Telephone" placeholder="2025550143" value="<?= $vacataire['Telephone'] ?>" id="phone">
        <label for="created">Created</label>
        <input type="datetime-local" name="created" value="<?= date('Y-m-d\TH:i', strtotime($vacataire['Created'])) ?>" id="created">
        <input type="submit" value="Modifier">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer('update') ?>