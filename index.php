<?php 

$mostra_risultato = false;

$prodotto = (isset($_POST["prodotto"]) && !empty($_POST["prodotto"])) ? htmlspecialchars($_POST["prodotto"]) : "NOT_VALID";

$prezzo = (isset($_POST["prezzo"]) && is_numeric($_POST["prezzo"]) && !empty($_POST["prezzo"])) ? trim(floatval($_POST["prezzo"])) : "NOT_VALID";

$sconto = (isset($_POST["sconto"]) && is_numeric($_POST["sconto"]) && !empty($_POST["sconto"])) ? trim(intval($_POST["sconto"])) : "NOT_VALID";

$errore = false;

if($prodotto == "NOT_VALID" || strlen($prodotto) > 30){
   $errore = true; 
   // ricorda poi devi mettere if in html <?php
}

if($prezzo == "" || strlen($prodotto) > 30){


?>




<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Calcolatore di sconto</title>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <h1>Calcolatore di sconto</h1>
    <form method="post" action="index.php">

        <label for="prodotto">Prodotto</label>
        <input type="text" id="prodotto" name="prodotto" maxlength="30" required>

        <label for="prezzo">Prezzo (€)</label>
        <input type="text" id="prezzo" name="prezzo" class="errore">

        <p class="msg-errore">Il prezzo deve essere maggiore di 0</p>

        <label for="sconto">Sconto (%)</label>
        <input type="text" id="sconto" name="sconto">

        <button type="submit">Calcola</button>
    </form>
</body>
</html>