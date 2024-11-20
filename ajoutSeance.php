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
    $idSéance = isset($_POST['idSéance']) && !empty($_POST['idSéance']) && $_POST['idSéance'] != 'auto' ? $_POST['idSéance'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Groupe = isset($_POST['Groupe']) ? $_POST['Groupe'] : '';
    $Module = isset($_POST['Module']) ? $_POST['Module'] : '';
    $Type_de_séance = isset($_POST['Type_de_séance']) ? $_POST['Type_de_séance'] : '';
    $Date = isset($_POST['Date']) ? $_POST['Date'] :'';
    $Durée = isset($_POST['Durée']) ? $_POST['Durée'] : '';
    $intituleCours = isset($_POST['intituleCours']) ? $_POST['intituleCours'] : '';
    $Heure_Démmarage = isset($_POST['Heure_Démmarage']) ? $_POST['Heure_Démmarage'] : '';
    $Heure_Fin = isset($_POST['Heure_Fin']) ? $_POST['Heure_Fin'] : '';
    $Liste_Abscence = isset($_POST['Liste_Abscence']) ? $_POST['Liste_Abscence'] : '';
    $Remarque = isset($_POST['Remarque']) ? $_POST['Remarque'] : '';
    $Salle = isset($_POST['Salle']) ? $_POST['Salle'] : '';
    $username=$_SESSION['user'];

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO seance VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?,?)');
    $stmt->execute([$idSéance, $Groupe,$Module,$Type_de_séance, $Date, $Durée,$Salle,$intituleCours, $Heure_Démmarage, $Heure_Fin, $Liste_Abscence, $Remarque,$username ]);
    
    // Output message
    $msg = 'insert Successfully!';
    header("location:listeSeance.php");
}
?>									
<?=template_headerUser('Create')?>


<div class="content update">
	<h2>Ajoute une séance</h2>
   
    <form action="" method="post" name="seance">
        <label for="Groupe">Groupe</label>
        <input type="text" name="Groupe" placeholder="Groupe" id="Groupe" required>
        <label for="Module">Module</label>
        <input type="text" name="Module" placeholder="Module" id="Module" required>
        <label for="intituleCours">intitulé de Cours</label>
        <input type="text" name="intituleCours" placeholder="intitule de Cours" id="intituleCours" required>
        <label for="Type_de_séance">Type_de_séance</label>
        <input type="text" name="Type_de_séance" placeholder="Type_de_séance" id="Type_de_séance" required>
        <label for="Date">Date</label>
        <input type="Date" name="Date" value="<?=date('Y-m-d\TH:i')?>"  id="Date" required>
        <label for="Durée">Durée</label>
        <input type="text" name="Durée" placeholder="Durée" id="Durée" required>
        <label for="Salle">Salle</label>
        <input type="text" name="Salle" placeholder="Salle" id="Salle" required>
        <label for="Heure_Démmarage">Heure Démmarage</label>
        <input type="time" name="Heure_Démmarage"placeholder="Heure_Démmarage" id="Heure_Démmarage" required>
        <label for="Heure_Fin">Heure Fin</label>
        <input type="time" name="Heure_Fin" placeholder="Heure_Démmarage" id="Heure_Fin" required>
        <label for="Liste_Abscence">Liste des abscences</label>
        <input type="text" name="Liste_Abscence" placeholder="Liste_Abscence" id="Liste_Abscence" required>
        <label for="Remarque">Remarque</label>
        <input type="text" name="Remarque" placeholder="Remarque" id="Remarque" required>
        <input type="submit" value="Créer" onClick="calculerTaux()">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
    
</div>

<?=template_footerUser('footer')?>

<?php } ?>