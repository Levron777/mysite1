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
        <?php require_once("header.php") ;?>

<!-- Формируем левую колонку -->

        <div class="left_column">
            <?php 

/*Старый код с mysqli
                $article = mysqli_query($mysqli, "SELECT * FROM `articles` WHERE `id` = " . (int) $_GET['id']);
	      	if ( mysqli_num_rows($article) <= 0){*/

            $id = ($_GET['id'] ? intval(htmlentities(trim($_GET['id']))) : 1);
            $article = $pdo->prepare('SELECT * FROM `articles` WHERE `id` = ?');
            $article->bindValue(1, $id, PDO::PARAM_INT);
            $article->execute();
            $article_count = $article->fetchAll();
            if ($article_count <= 0) {
	       ?>
            <div>
                <div>
                <h3> 
                    Запрашиваемая Вами статья не найдена!
                </h3>
                </div>	
            </div>

            <?php 
                } else{

/*Старый mysqli код
                    $art = mysqli_fetch_assoc($article);
                    mysqli_query($mysqli, "UPDATE `articles` SET `views` = `views` +1 WHERE `id` = " . (int)$art['id']);*/
                    //$art = $article_count;
                    foreach ($article_count as $art) {
                    $views_update = $pdo->prepare("UPDATE `articles` SET `views` = `views` +1 WHERE `id` = ?");
                    $views_update->bindValue(1, $id, PDO::PARAM_INT);
                    $views_update->execute();
            ?>
            <div>
                <a class="article_views"><?php echo $art['views']; ?> просмотров</a>
                <h3 class="article_title"> 
                <?php 
                    echo $art['title']; 
                    echo "</ br>"; 
                ?>	
                </h3>
                <div class="article_text">
                    <?php 
                        echo $art['content'];
                    ?>		
                </div>	
                <br>
                <div class="post-share">
                    <span class="post-share_title">Поделиться публикацией</span>
                        <ul class="post-share_buttons social-icons">
                            <li class="social-icons_item social-icons_item_post">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=http://t1009/pages/article.php?id=<?php echo $art['id'];?>" class="social-icons_item-link social-icons_item-link_normal social-icons_item-link_facebook" title="Опубликовать ссылку в Facebook" onclick="window.open(this.href, 'Опубликовать ссылку в Facebook', 'width=640,height=436,toolbar=0,status=0'); return false">
                                <svg class="icon-svg" aria-hidden="true" aria-labelledby="title" version="1.1" role="img" width="24" height="24" viewBox="0 0 24 24"><path d="M14.889 8.608h-1.65c-.195 0-.413.257-.413.6v1.192h2.063v1.698h-2.063v5.102h-1.948v-5.102h-1.766v-1.698h1.766v-1c0-1.434.995-2.6 2.361-2.6h1.65v1.808z"></path></svg>
                                </a>
                            </li>
                            <li class="social-icons_item social-icons_item_post">
                                <a href="https://twitter.com/share?url=http://t1009/pages/article.php?id=<?php echo $art['id'];?>" class="social-icons_item-link social-icons_item-link_normal social-icons_item-link_twitter" title="Опубликовать ссылку в Twitter" onclick="window.open(this.href, 'Опубликовать ссылку в Twitter', 'width=800,height=300,resizable=yes,toolbar=0,status=0'); return false">
                                <svg class="icon-svg" aria-hidden="true" aria-labelledby="title" version="1.1" role="img" width="24" height="24" viewBox="0 0 24 24"><path d="M17.414 8.642c-.398.177-.826.296-1.276.35.459-.275.811-.71.977-1.229-.43.254-.905.439-1.41.539-.405-.432-.982-.702-1.621-.702-1.227 0-2.222.994-2.222 2.222 0 .174.019.344.058.506-1.846-.093-3.484-.978-4.579-2.322-.191.328-.301.71-.301 1.117 0 .77.392 1.45.988 1.849-.363-.011-.706-.111-1.006-.278v.028c0 1.077.766 1.974 1.782 2.178-.187.051-.383.078-.586.078-.143 0-.282-.014-.418-.04.282.882 1.103 1.525 2.075 1.542-.76.596-1.718.951-2.759.951-.179 0-.356-.01-.53-.031.983.63 2.15.998 3.406.998 4.086 0 6.321-3.386 6.321-6.321l-.006-.287c.433-.314.81-.705 1.107-1.15z"></path></svg>
                                </a>
                            </li>
                            <li class="social-icons_item social-icons_item_post">
                                <a href="http://vk.com/share.php?url=http://t1009/pages/article.php?id=<?php echo $art['id'];?>" class="social-icons_item-link social-icons_item-link_normal social-icons_item-link_vkontakte" title="Опубликовать ссылку во ВКонтакте" onclick="window.open(this.href, 'Опубликовать ссылку во Вконтакте', 'width=800,height=300,toolbar=0,status=0'); return false">
                                <svg class="icon-svg" aria-hidden="true" aria-labelledby="title" version="1.1" role="img" width="24" height="24" viewBox="0 0 24 24"><path d="M16.066 11.93s1.62-2.286 1.782-3.037c.054-.268-.064-.418-.343-.418h-1.406c-.322 0-.44.139-.537.343 0 0-.76 1.619-1.685 2.64-.297.33-.448.429-.612.429-.132 0-.193-.11-.193-.408v-2.607c0-.365-.043-.472-.343-.472h-2.254c-.172 0-.279.1-.279.236 0 .343.526.421.526 1.352v1.921c0 .386-.022.537-.204.537-.483 0-1.631-1.663-2.274-3.552-.129-.386-.268-.494-.633-.494h-1.406c-.204 0-.354.139-.354.343 0 .375.44 2.114 2.167 4.442 1.159 1.566 2.683 2.414 4.056 2.414.838 0 1.041-.139 1.041-.494v-1.202c0-.301.118-.429.29-.429.193 0 .534.062 1.33.848.945.901 1.01 1.276 1.525 1.276h1.578c.161 0 .311-.075.311-.343 0-.354-.462-.987-1.17-1.738-.29-.386-.762-.805-.912-.998-.215-.226-.151-.354-.001-.59z"></path></svg>
                                </a>
                            </li>
                            <li class="social-icons_item social-icons_item_post">
                                <a href="https://t.me/share/url?url=http://t1009/pages/article.php?id=<?php echo $art['id'];?>" class="social-icons_item-link social-icons_item-link_normal social-icons_item-link_telegram" title="Поделиться ссылкой в Telegram" onclick="window.open(this.href, 'Поделиться ссылкой в Telegram', 'width=800,height=300,toolbar=0,status=0'); return false">
                                <svg class="icon-svg" aria-hidden="true" aria-labelledby="title" version="1.1" role="img" width="24" height="24" viewBox="0 0 24 24"><path d="M17.17 7.621l-10.498 3.699c-.169.059-.206.205-.006.286l2.257.904 1.338.536 6.531-4.796s.189.057.125.126l-4.68 5.062-.27.299.356.192 2.962 1.594c.173.093.397.016.447-.199.058-.254 1.691-7.29 1.728-7.447.047-.204-.087-.328-.291-.256zm-6.922 8.637c0 .147.082.188.197.084l1.694-1.522-1.891-.978v2.416z"></path></svg>
                                </a>
                            </li>
                        </ul>
                </div>
            </div>
            <?php
        }
        ?>
            <br><br>
            <hr>
            <div class="comment_block">
                <a href="#comment-add-form">Добавить свой</a>
                <h3>Комментарии к статье </h3>
                <div class="comment_content">
                    <div>
                        <?php 
/*Старый mysqli код
                            $comments = mysqli_query($mysqli, "SELECT * FROM `comments` WHERE `articles_id` = " . (int)$art['id'] . " ORDER BY `id` DESC");
                            if(mysqli_num_rows($comments) <= 0){
                                echo "Ваш комментарий будет первым!";
                            }
                            while( $comment = mysqli_fetch_assoc($comments) ){*/

                            $comments = $pdo->prepare("SELECT * FROM `comments` WHERE `articles_id` = ? ORDER BY `id` DESC");
                            $comments->bindValue(1, $id, PDO::PARAM_INT);
                            $comments->execute();
                            $comments_count = $comments->fetchAll();
                            
                            if(empty($comments_count)) {
                                echo "Ваш комментарий будет первым!";
                            }
                            foreach ($comments_count as $comment) {
                                ?>
                                <article>
                                    <div>
                                        <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125);"></div>
                                            <div class="comment_author_text"><?php echo $comment['author']; ?></div>
                                                <div class="article__info__preview"><?php echo $comment['text'] ;?></div>
                                                    <div> <br> </div>
                                    </div>
                                </article>
                            <?php 
                            }
                            ?>
                    </div>
                </div>
            </div>

            <div id="comment-add-form" class="comment_block">
                <h3>Добавить комментарий</h3>
                <div class="block__content">
                    <form class="form" method="POST" action="/pages/article.php?id=<?php echo $art['id'];?>#comment-add-form">
                    <?php 
                        //$data = $_POST;
                        if (isset($_POST['do_post'])) {

                        if (trim($_POST['name']) == '') {
                        	$errors[] = 'Введите Ваше имя!';
                        }       

                        if (trim($_POST['email']) == '') {
                        	$errors[] = 'Введите Ваш email!';
                        } 

                        if (trim($_POST['text']) == '') {
                        	$errors[] = 'Введите комментарий!';
                        }

                        if (empty($errors)) {
//Добавляем комменты
/*Старый mysqli код
                    	$name = mysqli_real_escape_string($mysqli, $data['name']);
                    	$email = mysqli_real_escape_string($mysqli, $data['email']);
                    	$text = mysqli_real_escape_string($mysqli, $data['text']);
                    	$name = htmlentities($name);
                    	$email = htmlentities($email);
                    	$text = htmlentities($text);

                        mysqli_query($mysqli, "INSERT INTO `comments` (`articles_id`, `author`, `email`, `text`, `pubdate`) VALUES ('" . (int)$art['id'] . "', '" . $name . "', '" . $email . "', '" . $text . "', NOW())") or die(mysqli_error($mysqli));*/

                        $add_comment = $pdo->prepare("INSERT INTO `comments` (`articles_id`, `author`, `email`, `text`, `pubdate`) VALUES (:articles_id, :author, :email, :text, NOW())");
                        $add_comment->execute(array(':articles_id' => $art['id'], ':author' => $_POST['name'], ':email' => $_POST['email'], ':text' => $_POST['text']));

                            echo '<span style="color: green; font-weight: bold; margin-bottom: 20px; display: block; ">Комментарий добавлен</span>';
                        }else {

//Проверяем ошибки
                            echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block; ">'. $errors['0'] . '</span>';
                        }
                        }
                    ?>
                    <div class="form__group">
                        <div class="row">
                            <div>
                                <input type="text" name="name" class="form__control" placeholder="Ваше имя" value="<?php echo $_POST['name'];?>">
                            </div>
                            <div>
                            	<input type="text" name="email" class="form__control" placeholder="Ваш email" value="<?php echo $_POST['email'];?>">
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <textarea class="form__control" name="text" placeholder="Ваш комментарий..."><?php echo $_POST['text'];?></textarea>
                    </div>
                    <div class="form__group">
                        <input type="submit" name="do_post" value="Добавить" class="form__control">
                    </div>
                    </form>
                </div>
            </div>
        </div>
	<?php 
        }
	?>

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

