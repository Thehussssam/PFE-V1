<?php

// start session
session_start();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ajouter un Emploi - JobConnect</title>

    <!-- styles -->
    <link rel="stylesheet" href="../assets/css/style_job.css">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

    <!-- job form -->
    <form class="job-container" action="../actions/add_job_action.php" method="POST">

        <!-- hidden company id -->
        <input type="hidden" name="id_entreprise" value="<?= $_SESSION['user_id']; ?>">

        <!-- header -->
        <header class="job-header">
            <h1>Post a New Job</h1>
            <p>Fill in the details below to create a new job requisition.</p>
        </header>

        <!-- form grid -->
        <div class="form-grid">

            <div class="input-group full-width">
                <label for="job-title">Titre du Poste</label>
                <input type="text" id="job-title" name="titre"
                       placeholder="Ex: Senior Frontend Engineer" required>
            </div>

            <div class="input-group">

                <label for="job-category">Catégorie</label>

                <div class="select-wrapper">
                    <select id="job-category" name="categorie" required>

                        <option value="" disabled selected>Choisir une catégorie...</option>

                        <option value="Web Development">Web Development</option>
                        <option value="Design">Design</option>
                        <option value="Cybersecurity">Cybersecurity</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Mobile Development">Mobile Development</option>
                        <option value="Data Science">Data Science</option>
                        <option value="Remote Jobs">Remote Jobs</option>
                        <option value="Product Management">Product Management</option>

                    </select>
                </div>

            </div>

            <div class="input-group">

                <label for="job-location">Localisation</label>

                <input type="text"
                       id="job-location"
                       name="location"
                       placeholder="Ex: Casablanca, Remote"
                       required>

            </div>

            <div class="input-group">

                <label for="job-contract">Type de Contrat</label>

                <div class="select-wrapper">
                    <select id="job-contract" name="type_contrat" required>

                        <option value="" disabled selected>Choisir le type...</option>

                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                        <option value="Stage">Stage</option>
                        <option value="Freelance">Freelance</option>

                    </select>
                </div>

            </div>

            <div class="input-group full-width">

                <label for="job-description">Description du Poste</label>

                <div class="textarea-wrapper">
                    <textarea id="job-description"
                              name="description"
                              placeholder="Décrivez les missions, les compétences requises..."
                              required></textarea>
                </div>

            </div>

        </div>

        <!-- divider -->
        <hr class="divider">

        <!-- footer -->
        <footer class="job-footer">
            <button type="submit" class="btn-submit">
                Create Job Requisition
            </button>
        </footer>

    </form>

</body>

</html>