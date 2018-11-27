<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php
            if ($page > 0) {
                $disabled = '';
                $pageUrl = '?page=' . ($page - 1);
                        
            } else {
                $disabled = 'disabled';
                $pageUrl = '#';
            }
            echo '<li class="page-item ' . $disabled . '">
                <a class="page-link" href="' . $pageUrl . '" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>';

            for($i = 0; $i < $maxPages; $i++) {
                if ($i == $page) {
                    $current = true;
                    $active = 'active';
                } else {
                    $current = false;
                    $active = '';
                }
                echo '<li class="page-item ' . $active . '">';
                if ($current) {
                    echo '<span class="page-link">' . 
                        ($i + 1) . '
                        <span class="sr-only">(current)</span>'.
                    '</span>';
                } else {
                    echo '<a class="page-link" href="?page=' . $i . '">' . ($i + 1) . '</a>';
                }
                echo '</li>';
            }
            
            if ($page < $maxPages - 1) {
                $disabled = '';
                $pageUrl = '?page=' . ($page + 1);
                        
            } else {
                $disabled = 'disabled';
                $pageUrl = '#';
            }
            echo '<li class="page-item ' . $disabled . '">
                <a class="page-link" href="' . $pageUrl . '" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>';
        ?>
    </ul>
</nav>