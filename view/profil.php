<?php
$articles = new Article();
$articles_list = $articles->list_article_user($_SESSION['psedo']);

?>
<div class="profile-page">
    <div class="user-info">
        <h2>Profil utilisateur</h2>
        <p><strong>Pseudo :</strong> <?php echo htmlspecialchars($_SESSION['psedo']); ?></p>
        <p><strong>Mot de passe :</strong> ******</p>
        <p><strong>Date de création :</strong> <?php echo htmlspecialchars($_SESSION['inscription_date']); ?></p>
    </div>

    <div class="user-articles">
        <h2>Articles de l'utilisateur</h2>
        <?php if (!empty($articles)): ?>
            <ul>
                <?php foreach ($articles_list as $article): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($article['content'], 0, 100)) . '...'; ?></p>
                        <a href="view_article.php?id=<?php echo $article['id']; ?>">Lire l'article</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </div>
</div>
