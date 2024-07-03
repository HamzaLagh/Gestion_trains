<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Données</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/modifier_supprimer.css">
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
    <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='message'>" . htmlspecialchars($_SESSION['message']) . "</div>";
                unset($_SESSION['message']); // Supprimer le message après l'affichage
            }
            ?>

    <div class="container-form">

                <div class="form-container">
                    <h2>Gestion des Voies</h2>
                    <div class="item-container">
                        <?php
                        include 'php/db_connect.php';
                        $sql = "SELECT * FROM voies";
                        $result = $conn->query($sql);

                        if ($result === false) {
                            echo "Erreur: " . $conn->error;
                        } else {
                            $voies = $result->fetch_all(MYSQLI_ASSOC);
                            if (count($voies) > 0) {
                                foreach ($voies as $voie) {
                                echo "<div class='item'><div class='item-p' >" . htmlspecialchars($voie['name']) . " - " . htmlspecialchars($voie['status']) . " - ". htmlspecialchars($voie['longueur']) . 
                                        "</div>
                                            
                                                <form action='php/delete_voie.php' method='post' style='display:inline;'>
                                                    <input type='hidden' name='id' value='" . htmlspecialchars($voie['id']) . "'>
                                                    <button class='supprimer' type='submit'>Supprimer</button>
                                                </form>
                                                <button class='modifier' onclick=\"openModal('modalVoie', " . htmlspecialchars($voie['id']) . ", '" . htmlspecialchars($voie['name']) . "', '" . htmlspecialchars($voie['status']) . "')\">Modifier</button>
                                        
                                        </div>";
                                    }
                            } else {
                                echo "<div class='item'>Aucune voie disponible</div>";
                            }
                        }
                        ?>
                    </div>
                </div>


                <div class="form-container">
                    <h2>Gestion des Natures</h2>
                    <div class="item-container">
                        <?php
                        $sql = "SELECT * FROM natures";
                        $result = $conn->query($sql);

                        if ($result === false) {
                            echo "Erreur: " . $conn->error;
                        } else {
                            $natures = $result->fetch_all(MYSQLI_ASSOC);
                            if (count($natures) > 0) {
                                foreach ($natures as $nature) {
                                    echo "<div class='item'><div class='item-p'>" . htmlspecialchars($nature['name']) . 
                                    "</div>
                                    <form action='php/delete_nature.php' method='post' style='display:inline;'>
                                            <input type='hidden' name='id' value='" . htmlspecialchars($nature['id']) . "'>
                                            <button class='supprimer' type='submit'>Supprimer</button>
                                        </form>

                                        <button class='modifier' onclick=\"openModal('modalNature', " . htmlspecialchars($nature['id']) . ", '" . htmlspecialchars($nature['name']) . "')\">Modifier</button>
                                    </div>";
                                }
                            } else {
                                echo "<div class='item'>Aucune nature disponible</div>";
                            }
                        }
                        ?>
                    </div>
                </div>


                <div class="form-container">
                    <h2>Gestion des Options</h2>
                    <div class="item-container">
                        <?php
                        $sql = "SELECT * FROM options";
                        $result = $conn->query($sql);

                        if ($result === false) {
                            echo "Erreur: " . $conn->error;
                        } else {
                            $options = $result->fetch_all(MYSQLI_ASSOC);
                            if (count($options) > 0) {
                                foreach ($options as $option) {
                                    echo "<div class='item'><div class='item-p' >" . htmlspecialchars($option['name']) . 
                                    "</div> <form action='php/delete_option.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($option['id']) . "'>
                                        <button class='supprimer' type='submit'>Supprimer</button>
                                            </form>
                                        <button class='modifier' onclick=\"openModal('modalOption', " . htmlspecialchars($option['id']) . ", '" . htmlspecialchars($option['name']) . "')\">Modifier</button>
                                        </div>";
                                }
                            } else {
                                echo "<div class='item'>Aucune option disponible</div>";
                            }
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
                
                

        
    </div>

    <!-- Modals -->
    <div id="modalVoie" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalVoie')">&times;</span>
            <h2>Modifier Voie</h2>
            <form id="formVoie" action="php/update_voie.php" method="post">
                <input type="hidden" name="id" id="voieId">
                <label for="voieName">Nom:</label>
                <input type="text" name="name" id="voieName" required>
                <label for="voieStatus">Statut:</label>
                <select name="status" id="voieStatus" required>
                    <option value="in_service">En service</option>
                    <option value="out_of_service">Hors service</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <button type="submit">Modifier</button>
            </form>
        </div>
    </div>

    <div id="modalNature" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalNature')">&times;</span>
            <h2>Modifier Nature</h2>
            <form id="formNature" action="php/update_nature.php" method="post">
                <input type="hidden" name="id" id="natureId">
                <label for="natureName">Nom:</label>
                <input type="text" name="name" id="natureName" required>
                <button type="submit">Modifier</button>
            </form>
        </div>
    </div>

    <div id="modalOption" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalOption')">&times;</span>
            <h2>Modifier Option</h2>
            <form id="formOption" action="php/update_option.php" method="post">
                <input type="hidden" name="id" id="optionId">
                <label for="optionName">Nom:</label>
                <input type="text" name="name" id="optionName" required>
                <button type="submit">Modifier</button>
            </form>
        </div>
    </div>
    <footer class="footer">
        <p>Gestion des Trains &copy; 2024</p>
    </footer>
    <script>
        function openModal(modalId, id, name, status = null) {
            document.getElementById(modalId).style.display = "block";
            if (modalId === 'modalVoie') {
                document.getElementById('voieId').value = id;
                document.getElementById('voieName').value = name;
                document.getElementById('voieStatus').value = status;
            } else if (modalId === 'modalNature') {
                document.getElementById('natureId').value = id;
                document.getElementById('natureName').value = name;
            } else if (modalId === 'modalOption') {
                document.getElementById('optionId').value = id;
                document.getElementById('optionName').value = name;
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
