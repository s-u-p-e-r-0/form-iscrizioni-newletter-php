<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Iscrizione Newsletter</title>
    <link rel="stylesheet" href="style.css">
</head>
    
    
<?php

// Definisco le variabili per email di notifica e database
$email_notifica = "tuamail@mail.com"; // Sostituisci con la tua email
$nome_file = "iscritti.txt"; // Nome file per il salvataggio degli iscritti

// Controllo se il form è stato inviato
if (isset($_POST['invio'])) {

    // Recupero i dati dal form
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $cognome = filter_var($_POST['cognome'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Controllo se i campi sono vuoti
    if (empty($nome) || empty($cognome) || empty($email)) {
        $errore = "Compila tutti i campi.";
    } else {

        // Formatto il messaggio di notifica
        $messaggio = "Nuova iscrizione newsletter:\n\nNome: $nome $cognome\nEmail: $email";

        // Invio l'email di notifica
        if (mail($email_notifica, "Nuova iscrizione newsletter", $messaggio)) {
            $successo = "Grazie per l'iscrizione alla newsletter!";

            // Salvo i dati dell'iscritto nel file
            $fp = fopen($nome_file, "a");
            fwrite($fp, "$nome $cognome | $email\n");
            fclose($fp);
        } else {
            $errore = "Errore nell'invio email. Riprova più tardi.";
        }
    }
}

?>
    
    
<body>

    <h1>Iscrizione Newsletter</h1>

    <?php if (isset($errore)): ?>
        <p class="errore"><?php echo $errore; ?></p>
    <?php endif; ?>

    <?php if (isset($successo)): ?>
        <p class="successo"><?php echo $successo; ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit" name="invio">Iscriviti</button>

    </form>

</body>
</html>