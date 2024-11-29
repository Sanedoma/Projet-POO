<?php
session_start();
require_once './preload.php';

$date = new DateTime("now");

/*echo 'hello world !! ';
echo $_SERVER['DOCUMENT_ROOT'];

$article = new Article();
$article_data = [
    "title" => "Test mis à jour",
    "content" => "Ce contenu a été mis à jour",
    "author" => "WebdevooUpdated",
    "created_date" => $date->format('Y-m-d H:i:s') // Conversion correcte
];

$article->set_article($article_data);
var_dump($article);
$article->add_article();


$article = new Article(1);
var_dump($article);
$article_data = [
    "title" => "Test mis à jour",
    "content" => "Ce contenu a été mis à jour",
    "author" => "sanedoma", // Conversion correcte
];
$article->update_article($article_data);
var_dump($article);

*/
/* SET CURRENT PAGE */
if ( ! isset( $_SESSION["page"] ) ) {  
	$_SESSION["page"] = "index"; //"commandes"; 
} 
if ( isset($_REQUEST["page"]) ) { 
	$_SESSION["page"] = $_REQUEST["page"]; 
} 
if(!isset($_SESSION['psedo'])){
    $_SESSION['psedo'] = "guest";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./source/styles/style.css">
    <link rel="stylesheet" href="./source/styles/header.css">
    <link rel="stylesheet" href="./source/styles/<?= htmlspecialchars($_SESSION['page'])?>.css">    
    <title>Document</title>
</head>
<body>
    <?php include("./templates/header.html");?>
    <main>
    <?php include("./view/". $_SESSION['page'] .".php");?>
    </main>
    <footer>
        <p>© 2024 - made & design by Sanedoma</p>
    </footer>
</body>
</html>