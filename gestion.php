<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/gestion.css">


</head>
<body>
    <div class="container-all">

        
        <header class="header-nav">
            <div>
                <div id="branding" style="border-right: 2px solid black;padding: 9px 25px;">
                    <img src="images/logo sncf reseau.png" alt="" width="100" height="">
                </div>
                <div class="dropdown"  style="float: right; padding: 26px 5px;">
                <a class="btn btn-dark" style="font-size: 15px;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-list"></i>
                </a>

                <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="index.php">Accueil</a></li>
                    <li><a class="dropdown-item" href="gestion.php">Ajout ... </a></li>
                    <li><a class="dropdown-item" href="modifier_supprimer.php">Gestion voies...</a></li>
                </ul>
                </div>
                
                <div style=" float: right;padding: 19px 25px;">
                    <a href="/login.html" style="text-decoration: none;font-size:36px;color: black; "><i class="bi bi-person-fill"></i></a>
                </div>
                <div style="font-weight: 700; float: right;padding: 26px 5px;">
                    <a href="/index.php" style="text-decoration: none;font-size:26px;color: black;"><i class="bi bi-arrows-fullscreen"></i></a>
                </div>
   
                <div  id="branding" style="padding: 0px 25px;">
                    <img src="images/images.png" alt="" width="200" height="">
                </div>                
            </div>
    
        </header>
    
        <div class="container-form ">
    
        <div class="form-container">
        <div class="message">
            <?php
            if (isset($_SESSION['voie_message'])) {
                echo "<p>" . htmlspecialchars($_SESSION['voie_message']) . "</p>";
                unset($_SESSION['voie_message']); 
            }
            ?>
        </div>

        <h2>Gestion des Voies</h2>
        <form action="php/voie.php" method="post">
            <input type="text" name="name" placeholder="Nom de la voie" required>
            <input type="text" name="longueur" placeholder="Longueur de la voie" required>
            <select name="status" required>
                <option value="in_service">En service</option>
                <option value="out_of_service">Hors service</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <button type="submit">Ajouter voie</button>
        </form>
    </div>

    <div class="form-container">
        <div class="message">
            <?php
            if (isset($_SESSION['nature_message'])) {
                echo "<p>" . htmlspecialchars($_SESSION['nature_message']) . "</p>";
                unset($_SESSION['nature_message']); 
            }
            ?>
        </div>

        <h2>Gestion des Natures</h2>
        <form action="php/nature.php" method="post">
            <input type="text" name="name" placeholder="Nom de la nature" required>
            <button type="submit">Ajouter nature</button>
        </form>
    </div>

    <div class="form-container">
        <div class="message">
            <?php
            if (isset($_SESSION['option_message'])) {
                echo "<p>" . htmlspecialchars($_SESSION['option_message']) . "</p>";
                unset($_SESSION['option_message']); 
            }
            ?>
        </div>

        <h2>Gestion des Options</h2>
        <form action="php/option.php" method="post">
            <input type="text" name="name" placeholder="Nom de l'option" required>
            <button type="submit">Ajouter option</button>
        </form>
    </div>

    <div class="form-container">
        <div class="message">
            <?php
            if (isset($_SESSION['gare_message'])) {
                echo "<p>" . htmlspecialchars($_SESSION['gare_message']) . "</p>";
                unset($_SESSION['gare_message']); 
            }
            ?>
        </div>

        <h2>Gestion des Gares</h2>
        <form action="php/ajout_gare.php" method="post">
            <input type="text" name="name" placeholder="Nom de la gare" required>
            <input type="text" name="location" placeholder="Localisation" required>
            <button type="submit">Ajouter</button>
        </form>
    </div>


    
    </div>

    <footer class="footer">
        <p>Gestion des Trains &copy; 2024</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>