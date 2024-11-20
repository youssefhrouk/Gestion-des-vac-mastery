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
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Prenom = isset($_POST['Prenom']) ? $_POST['Prenom'] : '';
    $Nom = isset($_POST['Nom']) ? $_POST['Nom'] : '';
    $user = isset($_POST['username']) ? $_POST['username'] : '';
    $Email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $phone = isset($_POST['Telephone']) ? $_POST['Telephone'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $Created = isset($_POST['Created']) ? $_POST['Created'] : date('Y-m-d H:i:s');
    $user_type='user';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id,$Nom, $Prenom,$user, $Email, $password, $phone, $Created,$user_type ]);
    // Output message
    $msg = 'Created Successfully!';
    header("location:read.php");
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Ajoute un vacataire</h2>
    <form action="" method="post">
        <label for="Prenom">Prenom</label>
        <input type="text" name="Prenom" placeholder="Prenom" id="Prenom" required>
        <label for="Nom">Nom</label>
        <input type="text" name="Nom" placeholder="Nom" id="Nom" required>
        <label for="user">username</label>
        <input type="text" name="username" placeholder="username" id="user" required>
        <label for="Email">Email</label>
        <input type="email" name="Email" placeholder="email@gmail.com" id="Email" required>
        <label for="phone">Telephone</label>
        <input type="text" name="Telephone" placeholder="......" id="phone" required>
        <label for="Created">Created</label>
        <input type="datetime-local" name="Created" value="<?=date('Y-m-d\TH:i')?>" id="Created" required>
        <label for="pass">Mot de passe</label>
        <input type="text" name="password" placeholder="votre mot de passe" id="password" required>
        <input type="submit" value="Créer">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
    
</div>

<?=template_footer('footer')?>

<?php } ?>