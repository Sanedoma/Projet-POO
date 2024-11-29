<?php


if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id_article"])) {
    $id = $_GET["id_article"];

    // Validation de l'identifiant de l'article
    if (!is_numeric($id)) {
        die("Identifiant de l'article invalide.");
    }

    // Instanciation de l'article
    $article = new Article($id);

    // Vérification que l'article existe
    if ($article->get_title() === null) {
        die("Article introuvable.");
    }
} else {
    die("Aucun article spécifié.");
}
?>

<article>
    <section id="head">
        <h1 id="title"><?= htmlspecialchars($article->get_title(), ENT_QUOTES, 'UTF-8') ?></h1>
        <p id="info">
            Auteur : <?= htmlspecialchars($article->get_author(), ENT_QUOTES, 'UTF-8') ?> <br>
            Date de création : <?= htmlspecialchars($article->get_created_date(), ENT_QUOTES, 'UTF-8') ?> <br>
            Date de modification : <?= htmlspecialchars($article->get_modif_date(), ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php if (isset($_SESSION['psedo']) && $_SESSION['psedo'] === $article->get_author()): ?>
            <a href="?page=edit_article&id_article=<?= htmlspecialchars($article->get_id(), ENT_QUOTES, 'UTF-8') ?>&set=no">Éditer l'article</a>
        <?php endif; ?>
    </section>
    <section id="content">
        <?= nl2br(htmlspecialchars($article->get_content(), ENT_QUOTES, 'UTF-8')) ?>
    </section>
    <br><br>
</article>
