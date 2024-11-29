<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $psedo = filter_input(INPUT_POST, 'psedo', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($psedo && $password) {
        // Récupération de l'utilisateur
        $user = new User($psedo);

        if ($user && password_verify($password, $user->get_password())) {
            // Mot de passe correct, démarrer une session
            $_SESSION['psedo'] = $user->get_psedo();
            $_SESSION['id'] = $user->get_id();
            $_SESSION['password'] = $password;
            $_SESSION['inscription_date'] = $user->get_inscription_date();
            echo "Connexion réussie. Bienvenue, " . htmlspecialchars($user->get_psedo()) . "!";
        } else {
            echo "Identifiant ou mot de passe incorrect.";
        }
    } else {
        echo "Veuillez fournir un pseudo et un mot de passe.";
    }
}

?>


    <form class="form-auth" action="#" method="POST">
        <label for="psedo">psedo :</label>
        <input type="psedo" id="psedo" name="psedo" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
        <p>Pas encore inscrit ? <a href="?page=signup">Inscrivez-vous</a></p>
    </form>
