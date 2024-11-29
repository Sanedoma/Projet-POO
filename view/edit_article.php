<?php
if (!isset($_SESSION['psedo']) || $_SESSION['psedo'] === "guest") {
    die("Vous n'êtes pas connecté à un compte.");
}

$title_page = "Editer l'article";
if (isset($_GET['set']) && $_GET['set'] === 'yes') {
    $title_page = "Ajout d'Article";
}

if (isset($_GET['id_article']) && is_numeric($_GET['id_article'])) {
    $article = new Article((int)$_GET['id_article']);
} else {
    $article = new Article();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = $_POST['content'];

    if (isset($_GET['set']) && $_GET['set'] === 'no') {
        $article->set_content($content);
        $article->set_title($title);
        $article->set_modif_date();
        $article->update_article();
    } else {
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS);
        $date = new DateTime();
        $article->set_author($author);
        $article->set_content($content);
        $article->set_title($title);
        $article->set_created_date($date->format('Y-m-d H:i:s'));
        $article->add_article();
    }
}
?>
<section>
    <h1><?= htmlspecialchars($title_page) ?></h1>
    <div>
        <form action="" method="post">
            <input type="hidden" name="author" value="<?= htmlspecialchars($_SESSION['psedo'])?>">
            <label for="">Titre de l'article</label>
            <input type="text" placeholder="veuillez entrer le titre de votre article" name="title" id="title" value="<?= htmlspecialchars($article->get_title(), ENT_QUOTES, 'UTF-8')?>">
            <br>
            <label for="">Contenue de l'article</label>
            <textarea name="content" id="content" placeholder="Veuillez ecrire votre article" ><?= htmlspecialchars($article->get_content(), ENT_QUOTES, 'UTF-8')?></textarea>
            <button type="submit">envoyer l'article</button>
        </form>
    </div>

</section>