<?php
function clean_data($date) {
    $result['psedo'] = filter_input(INPUT_POST, 'psedo', FILTER_SANITIZE_SPECIAL_CHARS); // Correct
    $result['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $result['inscription_date'] = $date->format('Y-m-d H:i:s');
    var_dump($result);
    return $result;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des données envoyées
    if (isset($_POST['password'], $_POST['confirm-password']) && $_POST['password'] === $_POST['confirm-password']) {
        // Nettoyage des données utilisateur
        $new_user_data = clean_data($date); // Corrigé : Utilise les données POST
        $new_user = new User();
        
        // Utilisation sécurisée de set_user
        try {
            $new_user->set_user($new_user_data);
            var_dump($new_user);
            // Persistance des données utilisateur
            $new_user->persist();
            echo "L'utilisateur a été créé avec succès. Bienvenue sur notre plateforme !";
        } catch (Exception $e) {
            // Gestion des exceptions avec message clair
            echo "Échec de la création de l'utilisateur : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    } else {
        // Message d'erreur pour des mots de passe non concordants
        echo "Les mots de passe ne correspondent pas. Veuillez réessayer.";
    }
}

?>
        <form class="form-auth" action="#" method="POST">

            <label for="psedo">Psedo :</label>
            <input type="text" id="psedo" name="psedo" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <button type="submit">S'inscrire</button>
            <p>Déjà un compte ? <a href="?page=login">Connectez-vous</a></p>
        </form>
