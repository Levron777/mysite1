<?php
  require_once "../config.php";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>

<!-- Custom style-->
    <link rel="stylesheet" type="text/css" href="/style/style.css">

<!-- Homepage-->
    <link rel="home" title="Лучшие новости" href="index.php">

<!-- Bootstrap-->
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">-->
</head>
<body>
    <div class="container">
	<?php 
        require_once("header.php");
	?>

<!-- Формируем левую колонку -->

	<div class="left_column">
        <div>
<!--Определяем количество статей в базе данных, также определяем для вывода кол-во статей на одной странице-->
        <?php

		$page = 1;
		$per_page = 5;
		if (isset($_GET['page'])){
            $page = (int)$_GET['page'];
		} 
/*Старый mysqli код	
		$total_articles = mysqli_query($mysqli, "SELECT COUNT(`id`) AS `total_count` FROM `articles` WHERE `category` = 'Novosibirsk'");
                $total_count = mysqli_fetch_assoc($total_articles);*/
        $total_articles = $pdo->query("SELECT COUNT(`id`) AS `total_count` FROM `articles`WHERE `category` = 'Novosibirsk'");
        $total_count = $total_articles->fetch();
        $total_count = $total_count['total_count'];
		$total_pages = ceil($total_count/$per_page);
                
		if ($page <= 1 || $page > $total_pages) {
            $page = 1;
        }
		$art = ($page * $per_page) - $per_page;

		/*$articles = mysqli_query($mysqli, "SELECT * FROM `articles` WHERE `category` = 'Novosibirsk' ORDER BY `id` DESC LIMIT $art, $per_page");*/
        $articles = $pdo->prepare("SELECT * FROM `articles` WHERE `category` = 'Novosibirsk' ORDER BY `id` DESC LIMIT ?, ?");
        $articles->bindValue(1, $art, PDO::PARAM_INT);
        $articles->bindValue(2, $per_page, PDO::PARAM_INT);
        $articles->execute();
        $articles_page = $articles->fetchAll();
        $articles_exist = true;
        if ($articles_page <= 0) {
            echo "Статьи не обнаружены!";
            $articles_exist = false;
        }

        if ( $articles_exist == true ) {
            echo '<div class="container">';
            if( $page > 1 ) {
                echo '<a class="prev_page" href="/pages/novosibirsk.php?page='.($page - 1).'"> ← Предыдущая страница | </a>';
            }
                if( $page < $total_pages ) {
                    echo '<a class="next_page" href="/pages/novosibirsk.php?page='.($page + 1).'">Следующая страница  → </a>';
                }
            echo '</div>';
        }

//Выводим статьи 

		//while ($art = mysqli_fetch_assoc($articles)){
        foreach($articles_page as $art) {
        ?>
            <div>
    		<h3> 
    		<a class="article_title" href="/pages/article.php?id=<?php echo $art['id'];?>"><?php echo $art['title']; ?></a>
    		<?php echo "</ br>"; ?>
    		</h3>
                <div class="article_text">
                <?php 
			echo mb_substr(strip_tags($art['content']), 0, 200, 'utf-8') . " ..." ;
                ?>
                </div>
            </div>
		<?php
		}
		?>	
            </div>
	</div>

<!-- Формируем правую колонку -->
	<aside>
        <div class="adv_block">
            <img src="/images/sky_right_column.jpg" class="img_aside">
            <p>Реклама</p>
            <p></p>
            <p></p>
        </div>
    </aside>


<!-- Очищаем макет для размещения подвала -->
	<div class="clear"></div>
	<?php require_once("footer.php") ;?>
    </div>
</body>
</html>
