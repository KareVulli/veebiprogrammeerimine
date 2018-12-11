<?php
    require_once('includes/functions/news.php');
    $messages = getNews();
?>
<div class="list-group">
    <form>
    <?php 
        foreach ($messages as $message) {
            echo '<div class="list-group-item flex-column align-items-start">' .
                    '<div class="d-flex w-100 justify-content-between">' .
                        '<h5 class="mb-1">' . cleanInput($message['title']) . '</h5>' .
                        '<small class="text-nowrap">' . $message['created'] . '</small>' .
                    '</div>' .
                    '<p class="mb-1">' . $message['content'] . '</p>' .
                '</div>';
        }
    ?>
    </form>
</div>