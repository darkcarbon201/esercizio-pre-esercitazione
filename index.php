<?php 

$mostra_risultato = false;

$errore_prodotto = false;

$errore_prezzo = false;

$errore_sconto = false;


if (isset($_POST["calcola"])) {
    $prodotto = (isset($_POST["prodotto"]) && !empty($_POST["prodotto"]) && !is_numeric($_POST["prodotto"])) ? htmlspecialchars($_POST["prodotto"]) : "NOT_VALID";

    $prezzo = (isset($_POST["prezzo"]) && is_numeric($_POST["prezzo"]) && !empty($_POST["prezzo"])) ? floatval($_POST["prezzo"]) : "NOT_VALID";

    $sconto = (isset($_POST["sconto"]) && is_numeric($_POST["sconto"]) && !empty($_POST["sconto"])) ? intval($_POST["sconto"]) : "NOT_VALID";



    if($prodotto == "NOT_VALID" || strlen($prodotto) > 30){
        $errore_prodotto = true; 
    }

    if($prezzo == "NOT_VALID" || $prezzo <= 0){
        $errore_prezzo = true;
    }

    if($sconto == "NOT_VALID" || $sconto < 1 || $sconto > 90 ){
        $errore_sconto = true;
    }

    if ($errore_prodotto == false && $errore_prezzo == false && $errore_sconto == false) {
        $prezzo_finale = $prezzo - ($prezzo * $sconto / 100);
        $mostra_risultato = true;
    }

    if($errore_sconto == true){
        $tipoDi_sconto = "NOT_VALID";
    }elseif($sconto <= 20 ){
        $tipoDi_sconto = "piccolo";
        $fascia = "PICCOLO";
    }elseif($sconto >= 20 && $sconto <= 49 ){
        $tipoDi_sconto = "buono";
        $fascia = "BUONO";
    }else{
        $tipoDi_sconto = "super";
        $fascia = "SUPER";
    }


    $data = date("d/m/o, H:i:s");

    $record = implode("," ,[$data, $prodotto, $prezzo, $sconto, $tipoDi_sconto]).PHP_EOL;

    $nomeFile = "log.csv";

    $file = fopen($nomeFile, "a");

    fwrite($file, $record);

    fclose($file);
}





?>


<?php if($mostra_risultato == true): ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Calcolatore di sconto</title>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <div class="risultato-card">
        <div class="card <?php echo $tipoDi_sconto;?>">
            <div>Prodotto: <?php echo $prodotto; ?></div>
            <div>Prezzo: <?php echo number_format($prezzo_finale,2); ?></div>
            <div>Sconto: <?php echo $sconto;?></div>
            <div>Tipo di Sconto: <?php echo $fascia;?> </div>
            <a href="index.php" class = "recalculate-link">Calcola di nuovo</a>
        </div>
    </div>
</body>
</html>

<?php else:?>


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

        <?php if($errore_prodotto == true):?>
        <p class="msg-errore">Inserisci un nome valido</p>
        <?php endif?>

        <input type="text" id="prodotto" name="prodotto" maxlength="30">

        <!-- ------------------- -->

        <label for="prezzo">Prezzo (€)</label>
        <input type="text" id="prezzo" name="prezzo" <?php if ($errore_prezzo == true) { echo 'class="errore"'; } ?>>
       
        <?php if($errore_prezzo == true):?>
        <p class="msg-errore">Il prezzo deve essere maggiore di 0</p>
        <?php endif?>

        <!-- ------------------- -->

        <label for="sconto">Sconto (%)</label>

        <?php if($errore_sconto == true):?>
        <p class="msg-errore">Inserisci uno sconto tra 1 e 90</p>
        <?php endif?>
        
        <input type="text" id="sconto" name="sconto">

        <!-- ------------------- -->

        <button type="submit" name = "calcola">Calcola</button>


    </form>
</body>
</html>

<?php endif ?>