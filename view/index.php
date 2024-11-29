<section class="articles">
    <?php
        $articles = new Article();
        $listArticles = $articles->list_article();

        foreach ($listArticles as $article): ?>
            <article>
                <h2><?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                <p><?= htmlspecialchars(substr($article['content'], 0, 50))?></p>
                <a href="?page=view_article&id_article=<?= htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8') ?>">Lire la suite</a>
            </article>
    <?php endforeach; ?>
</section>
