<?php

require("../../../lang/lang.php");
$strings = tr();

include( "baglanti.php" );

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = htmlspecialchars($_POST['ad']);
    $soyad = htmlspecialchars($_POST['soyad']);
    $email = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['tel']);

    // Iniciar la transacción
    $db->beginTransaction();

    // Verificar si ya existe un registro con el mismo correo electrónico
    $kontrolSql = "SELECT * FROM kayit WHERE email = '$email' FOR UPDATE";
    $kontrolSonuc = $db->query($kontrolSql);
    $results = $kontrolSonuc->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        // Se encontró un registro con el mismo correo electrónico, emitir una advertencia.
        echo $strings['warning']; // ¡Registro fallido: ya existe una cuenta con el correo electrónico registrado!
    } else {
        // No existe un registro con el mismo correo electrónico, agregarlo.
        $ekleSql = "INSERT INTO kayit (ad, soyad, email, tel) VALUES ('$ad', '$soyad', '$email', '$tel')";

        if ($db->exec($ekleSql)) {
            echo $strings['successful']; // ¡Registro completado!
        } else {
            echo $strings['unsuccessful']; // ¡Registro fallido!
        }
    }

    // Confirmar la transacción
    $db->commit();
}




if (isset($_POST['email'])) {
    session_start();
    $_SESSION['email'] = $_POST['email'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title><?php echo "Race Condition" ?></title>
   
    
</head>
<body>

<div class="container col-md-4 shadow-lg rounded">
    <div class="d-flex row justify-content-center pt-lg-5 " style="margin-top: 20vh;text-align:center;">
        <div class="alert alert-primary col-md-7 mb-4" role="alert">
            <?php echo $strings['text']; ?>
        </div>

        <h2><?php echo $strings['information']; ?></h2>

        <form action="index.php" method="post">
    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['name']; ?>:</label>
        <div class="col-sm-5">
            <input type="text" name="ad" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['surname']; ?>:</label>
        <div class="col-sm-5">
            <input type="text" name="soyad" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['email']; ?>:</label>
        <div class="col-sm-5">
            <input type="email" name="email" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['phone']; ?>:</label>
        <div class="col-sm-5">
            <input type="number" name="tel" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="<?php echo $strings['register']; ?>">
    </div>
</form>


      
        <div style="margin-top: 10px;"></div>

        <a href="kayitlar.php" class="btn btn-danger btn-primary-sm"><?php echo $strings['registers']; ?></a>
    </div>
</div>



    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="11" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
