<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Trains</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">

</head>
<body>


    
<!-- Modal pour la mise à jour du train -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier le train</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="update-train-form" action="update_train.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="train-id" name="train_id">
                    <input type="text" id="train-number" name="train_number" placeholder="Numéro du train" required>
                    <input type="time" id="departure-time" name="departure_time" placeholder="Heure de départ" required>
                    <input type="time" id="arrival-time" name="arrival_time" placeholder="Heure d'arrivée" required>
                    <select name="nature_id" required>
                        <?php
                        include 'php/db_connect.php';
                        $sql = "SELECT * FROM natures";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Aucune nature disponible</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                    <input type="text" id="origin" name="origin" placeholder="Provenance" required>
                    <input type="text" id="destination" name="destination" placeholder="Destination" required>
                    <select name="track" required>
                        <?php
                        include 'php/db_connect.php';
                        
                        $sql = "SELECT * FROM voies";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                // Récupérez également le statut de la voie
                                $trackId = $row['id'];
                                $trackName = $row['name'];
                                $trackStatus = $row['status']; // Assurez-vous que 'status' correspond à la colonne dans votre table 'voies'
                                
                                // Ajoutez l'option avec l'attribut data-status
                                echo "<option value='$trackId' data-status='$trackStatus'>$trackName</option>";
                            }
                        } else {
                            echo "<option value='' disabled>Aucune voie disponible</option>";
                        }

                        $conn->close();
                        ?>
                    </select>
                <select name="option">
                    <?php
                    include 'php/db_connect.php';
                    $sql = "SELECT * FROM options";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Aucune option disponible</option>";
                    }
                    $conn->close();
                    ?>
                 </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <button type="button" class="btn btn-danger" id="delete-train-button">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="container-all" >

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
                    <a href="" style="text-decoration: none;font-size:26px;color: black;"><i class="bi bi-arrows-fullscreen"></i></a>
                </div>


                <div  id="branding" style="padding: 0px 25px;">
                    <img src="images/images.png" alt="" width="200" height="">
                </div>



                <div  id="branding">
                    <h5>Paris Gare de Lyon - <?php echo date('d/m/Y'); ?></h5>
                </div>         
            </div>
        </header>


        <div class="hour-now">
                <p><span id="current-time"></span></p>
        </div>
        <!-- affihage de msg pour les voies -->
        <div id="error-message" style="color: red; margin-bottom: 10px; display: none;">La voie est en maintenance ou hors service. Sélectionnez une autre voie.</div>


    <section class="showcase">
        <div class="form-container mx-auto">
        <?php
            if (isset($_SESSION['train_message'])) {
                echo "<p>" . htmlspecialchars($_SESSION['train_message']) . "</p>";
                unset($_SESSION['train_message']); 
            }
            ?>               
            <h2>Ajouter un train</h2>
            <form id="add-train-form" action="train.php" method="post" onsubmit="return validateTrack()">
                <input type="number" min="0" name="number" placeholder="Numéro du train" required>
                <input type="time" name="departure_time" placeholder="Heure de départ" required>
                <input type="time" name="arrival_time" placeholder="Heure d'arrivée" required>
                <select name="nature_id" required>
                    <option value="">Sélectionnez la nature</option>
                    <?php
                    include 'php/db_connect.php';
                    $sql = "SELECT * FROM natures";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Aucune nature disponible</option>";
                    }
                    $conn->close();
                    ?>
                </select>
                <input type="text" name="origin" placeholder="Provenance" required>
                <input type="text" name="destination" placeholder="Destination" required>

                <select name="track" required>
                    <option value="">Sélectionnez la voie</option>
                    <?php
                    include 'php/db_connect.php';
                    
                    $sql = "SELECT * FROM voies";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Récupérez également le statut de la voie
                            $trackId = $row['id'];
                            $trackName = $row['name'];
                            $trackStatus = $row['status']; // Assurez-vous que 'status' correspond à la colonne dans votre table 'voies'
                            
                            // Ajoutez l'option avec l'attribut data-status
                            echo "<option value='$trackId' data-status='$trackStatus'>$trackName</option>";
                        }
                    } else {
                        echo "<option value='' disabled>Aucune voie disponible</option>";
                    }

                    $conn->close();
                    ?>
                </select>


                 <select name="option">
                    <option value="id">Sélectionnez l'option</option>
                    <?php
                    include 'php/db_connect.php';
                    $sql = "SELECT * FROM options";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Aucune option disponible</option>";
                    }
                    $conn->close();
                    ?>
                 </select>
                <button type="submit">Ajouter</button>
            </form>
        </div>
    </section>


    <section class="main-content">
        <div class="timeline-container">
            <div class="track-labels">
                <?php
                include 'php/db_connect.php';

                $sql_tracks = "SELECT * FROM voies";
                $result_tracks = $conn->query($sql_tracks);

                if ($result_tracks->num_rows > 0) {
                    while ($track = $result_tracks->fetch_assoc()) {
                        $track_name = $track['name'];
                        $longueur = $track['longueur'];
                        echo '<div class="track-label">' . $track_name . '<span style="font-size:12px;background-color:white;margin-left:10px;">'. $longueur . '</span></div>' ;
                    }
                } else {
                    echo "<div class='track-label'>Aucune voie disponible.</div>";
                }
                ?>
            </div>

            <div class="timeline-content">
                <div class="timeline-header">
                    <?php
                    // Boucle pour afficher chaque heure et intervalle de 15 minutes
                    for ($hour = 0; $hour < 24; $hour++) {
                        for ($minute = 0; $minute < 60; $minute += 15) {
                            $time_label = str_pad($hour, 2, '0', STR_PAD_LEFT) . 'h' . str_pad($minute, 2, '0', STR_PAD_LEFT);
                            $class = ($minute == 0) ? 'time-label full-hour' : 'time-label small-interval';
                            echo '<div class="' . $class . '">' . $time_label . '</div>';
                        }
                    }
                    ?>
                </div>

                
                <div class="timeline-body">
                <div id="current-time-bar"></div>

                    <?php
                    // Réinitialiser le pointeur de résultat et récupérer à nouveau les données pour la chronologie
                    $result_tracks->data_seek(0);

                    if ($result_tracks->num_rows > 0) {
                        while ($track = $result_tracks->fetch_assoc()) {
                            $track_id = $track['id'];
                            $track_status = $track['status']; // Assuming 'status' indicates whether the track is in service, maintenance, or out of service
                    
                            // Define CSS class based on track status
                            $track_class = '';
                            if ($track_status == 'out_of_service') {
                                $track_class = 'track-out-of-service';
                            } elseif ($track_status == 'maintenance') {
                                $track_class = 'track-maintenance';
                            }
                    
                            echo '<div class="track ' . $track_class . '" id="track' . $track_id . '">';
                    
                            $sql_trains = "
                                SELECT trains.*, natures.name AS nature_name, natures.color
                                FROM trains
                                JOIN natures ON trains.nature_id = natures.id
                                WHERE track = $track_id";
                            $result_trains = $conn->query($sql_trains);
                    
                            if ($result_trains->num_rows > 0) {
                                while ($train = $result_trains->fetch_assoc()) {
                                    $train_number = $train['number'];
                                    $train_nature = $train['nature_name']; // Train nature name
                                    $departure_time = $train['departure_time']; // Departure time
                                    $arrival_time = $train['arrival_time']; // Arrival time
                    
                                    // Calculate position and width based on time
                                    $start = strtotime($departure_time);
                                    $end = strtotime($arrival_time);
                                    $day_start = strtotime('00:00');
                                    $left_percent = (($start - $day_start) / 86400) * 100;
                                    $width_percent = (($end - $start) / 86400) * 100;
                    
                                    echo '<div data-id="' . $train['id'] . '" data-bs-toggle="modal" data-bs-target="#exampleModal" class="train train-item" style="left: ' . $left_percent . '%; width: ' . $width_percent . '%; background-color: ' . $train['color'] . ';z-index:5;">';
                                    echo '<span style="position:absolute;left:0;bottom:1;font-size:13px;color:black;font-weight:600;" class="train-time">' . date('H:i', $start) . '</span>'; // Departure time
                                    echo '<span class="train-label">' . $train_nature . ' ' . $train_number . '</span>';
                                    echo '<span style="position:absolute;right:0;font-size:13px;color:black;font-weight:600;" class="train-time">' . date('H:i', $end) . '</span>'; // Arrival time
                                    echo '</div>';
                                }
                            }
                    
                            echo '</div>';
                        }
                    } else {
                        echo "<div class='track'>No tracks available.</div>";
                    }
                  ?>                   
                </div>
            </div>

            <div class="track-labels">
                <?php
                include 'php/db_connect.php';

                $sql_tracks = "SELECT * FROM voies";
                $result_tracks = $conn->query($sql_tracks);

                if ($result_tracks->num_rows > 0) {
                    while ($track = $result_tracks->fetch_assoc()) {
                        $track_name = $track['name'];
                        $longueur = $track['longueur'];
                        echo '<div class="track-label">' . $track_name . '<span style="font-size:12px;background-color:white;margin-left:10px;">'. $longueur . '</span></div>' ;
                    }
                } else {
                    echo "<div class='track-label'>Aucune voie disponible.</div>";
                }
                ?>
            </div>

        </div>
    </section>




</div>

    <footer class="footer">
        <p>Gestion des Trains &copy; 2024</p>
    </footer>

    <script src="script.js"></script>
    <script>
    // Fonction pour mettre à jour l'heure actuelle
    function updateCurrentTime() {
        const currentTimeElement = document.getElementById('current-time');
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const currentTimeString = `Heure actuelle: ${hours}:${minutes}:${seconds}`;
        currentTimeElement.textContent = currentTimeString;
    }

    // Mettre à jour l'heure actuelle toutes les secondes
    setInterval(updateCurrentTime, 1000);

    // Appeler la fonction une fois au chargement pour initialiser
    updateCurrentTime();
</script>



<!-- <script>
    function updateCurrentTimeBar() {
    const currentTime = new Date();
    const hours = currentTime.getHours();
    const minutes = currentTime.getMinutes();
    const seconds = currentTime.getSeconds();

    // Calcul du pourcentage de la journée écoulée
    const totalSecondsInDay = 24 * 60 * 60;
    const currentSeconds = hours * 3600 + minutes * 60 + seconds;
    const percentageOfDay = (currentSeconds / totalSecondsInDay) * 100;

    // Mise à jour de la position de la barre verticale
    const currentTimeBar = document.getElementById('current-time-bar');
    currentTimeBar.style.left = percentageOfDay + '%';
    }

    // Appel de la fonction pour mettre à jour la position de la barre toutes les secondes
    setInterval(updateCurrentTimeBar, 1000);

    // Appel initial de la fonction pour l'initialisation au chargement de la page
    updateCurrentTimeBar();

</script> -->


<!-- <script>
    function updateCurrentTimeBar() {
        const currentTime = new Date();
        const hours = currentTime.getHours();
        const minutes = currentTime.getMinutes();
        const seconds = currentTime.getSeconds();

        // Calcul du pourcentage de la journée écoulée
        const totalMinutesInDay = 24 * 60;
        const currentMinutes = hours * 60 + minutes;
        const percentageOfDay = (currentMinutes / totalMinutesInDay) * 100;

        // Mise à jour de la position de la barre verticale
        const currentTimeBar = document.getElementById('current-time-bar');
        currentTimeBar.style.left = percentageOfDay + '%';
    }

    // Appel de la fonction pour mettre à jour la position de la barre toutes les secondes
    setInterval(updateCurrentTimeBar, 1000);

    // Appel initial de la fonction pour l'initialisation au chargement de la page
    updateCurrentTimeBar();
</script> -->


<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $(".train-item").click(function() {
            var trainId = $(this).data("id");

            $.ajax({
                url: 'get_train_info.php',
                method: 'GET',
                data: { id: trainId },
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        var trainData = response; // Les données JSON sont directement utilisables

                        // Mettre à jour le titre du modal avec le numéro du train
                        $("#exampleModal .modal-title").text("Modifier le train " + trainData.number);

                        // Remplir les champs du formulaire du modal avec les données du train
                        $("#train-id").val(trainData.id);
                        $("#train-number").val(trainData.number);
                        $("#departure-time").val(trainData.departure_time);
                        $("#arrival-time").val(trainData.arrival_time);
                        $("#origin").val(trainData.origin);
                        $("#destination").val(trainData.destination);

                        // Remplir les options de nature
                        $.ajax({
                            url: 'get_natures.php',
                            method: 'GET',
                            success: function(natures) {
                                var natureOptions = '';
                                natures.forEach(function(nature) {
                                    var selected = nature.id == trainData.nature_id ? 'selected' : '';
                                    natureOptions += '<option value="' + nature.id + '" ' + selected + '>' + nature.name + '</option>';
                                });
                                $("#nature-id").html(natureOptions);
                            }
                        });

                        // Remplir les options de voie
                        $.ajax({
                            url: 'get_tracks.php',
                            method: 'GET',
                            success: function(tracks) {
                                var trackOptions = '';
                                tracks.forEach(function(track) {
                                    var selected = track.id == trainData.track ? 'selected' : '';
                                    trackOptions += '<option value="' + track.id + '" ' + selected + '>' + track.name + '</option>';
                                });
                                $("#track").html(trackOptions);
                            }
                        });

                        // Remplir les options
                        $.ajax({
                            url: 'get_options.php',
                            method: 'GET',
                            success: function(options) {
                                var optionOptions = '';
                                options.forEach(function(option) {
                                    var selected = option.name == trainData.option ? 'selected' : '';
                                    optionOptions += '<option value="' + option.name + '" ' + selected + '>' + option.name + '</option>';
                                });
                                $("#option").html(optionOptions);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Erreur lors de la récupération des informations du train. Vérifiez la console pour plus de détails.");
                }
            });
        });

        // Soumettre le formulaire de mise à jour
        $("#update-train-form").submit(function(event) {
            event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

            var formData = $(this).serialize(); // Sérialiser les données du formulaire

            $.ajax({
                url: $(this).attr("action"), // Récupérer l'URL d'action du formulaire
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.success);
                        window.location.reload(); // Recharger la page après mise à jour
                    } else if (response.error) {
                        alert(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Erreur lors de la mise à jour du train. Vérifiez la console pour plus de détails.");
                }
            });
        });

        // Gestion du clic sur le bouton de suppression
        $("#delete-train-button").click(function() {
            var trainId = $("#train-id").val();

            if (confirm("Êtes-vous sûr de vouloir supprimer ce train ?")) {
                $.ajax({
                    url: 'delete_train.php',
                    method: 'POST',
                    data: { id: trainId },
                    success: function(response) {
                        if (response.success) {
                            alert(response.success);
                            window.location.reload(); // Recharger la page après suppression
                        } else if (response.error) {
                            alert(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert("Erreur lors de la suppression du train. Vérifiez la console pour plus de détails.");
                    }
                });
            }
        });
    });
</script>
<script>
    function updateCurrentTimeBar() {
        const currentTime = new Date();
        const hours = currentTime.getHours();
        const minutes = currentTime.getMinutes();
        const seconds = currentTime.getSeconds();

        // Calcul du pourcentage de la journée écoulée
        const totalSecondsInDay = 24 * 60 * 60;
        const currentSeconds = hours * 3600 + minutes * 60 + seconds;
        const percentageOfDay = (currentSeconds / totalSecondsInDay) * 100;

        // Mise à jour de la position de la barre verticale
        const currentTimeBar = document.getElementById('current-time-bar');
        currentTimeBar.style.left = percentageOfDay + '%';
    }

    // Appel de la fonction pour mettre à jour la position de la barre toutes les secondes
    setInterval(updateCurrentTimeBar, 1000);

    // Appel initial de la fonction pour l'initialisation au chargement de la page
    updateCurrentTimeBar();
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
    
