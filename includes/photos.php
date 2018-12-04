<?php 
if (isset($_GET['page']) && $maxPages > 0) {
    $page = intval($_GET['page']);
    if ($page < 0) {
        $page = 0;
    } elseif ($page >= $maxPages) {
        $page = $maxPages - 1;
    }
} else {
    $page = 0;
}

$javascript = '<script type="text/javascript" src="assets/js/photos.js"></script>';

?>

<?php require_once('includes/header.php'); ?>
    <div class="modal fade" id="image-modal" tabindex="-1" role="dialog" aria-labelledby="image-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="image-modal-label">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="full-image" class="rounded mx-auto d-block" alt="placeholder">
                    <h5 class="mt-3">Lisa kommentaar</h5>
                    <div id="status"></div>
                    <form>
                        <div class="form-group">
                            <label for="rating">Hinnang</label>
                            <select class="form-control" id="rating">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option selected>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <button id="add-comment" type="submit" class="btn btn-primary">Kommentaar</button>
                    </form>
                    <h5 class="mt-3">Kommentaarid</h5>
                    <ul id="comments" class="list-group">
                        <li class="list-group-item list-group-item-action flex-column">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">User Name</h5>
                                <small>3 days ago</small>
                            </div>
                            <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            <small><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></small>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
	<div class="container mt-4">
		<div class="row">
            <div class="col">
                <div class="center">
                    <h3>Tund 11 - Pildid</h3>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="d-flex flex-row justify-content-center flex-wrap">
                <?php
                $images = $getPhotos($page);
                if (empty($images)) {
                    echo '<p>Pilte pole</p>';
                } else {
                    

                    foreach ($images as $image) {
                        $stars = '';
                        if ($image['rating'] == null) {
                            $rating = "";
                        } else {
                            $rating = round($image['rating']);
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < $rating) {
                                    $stars .= '<i class="fas fa-star"></i>';
                                } else {
                                    $stars .= '<i class="far fa-star"></i>';
                                }
                            }
                        }

                        echo '<div class="p-4">'.
                            '<img class="img-thumbnail image-priview" data-photo="' . $image['id'] . '" data-url="' . $fullPath . $image['file'] . '" src="' . $path . $image['file'] . '" alt="' . $image['title'] . '">'.
                            '<p class="text-center">' . $stars . '</p>' .
                        '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <?php require('includes/pagination.php'); ?>
    </div>
<?php require_once('includes/footer.php'); ?>