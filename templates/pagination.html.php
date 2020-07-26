<nav aria-label="pagination">
    <?php if (!empty($data['pages']) && $data['pages']['total'] > 1): ?>
        <ul class="pagination">
            <?php if ($data['pages']['current'] == 1): ?>
                <li class="page-item disabled">
                    <a class="page-link" href="#">&laquo; Previous</a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link"
                       href="<?php echo $config['basePath'] . '?orderby=' . $data['pages']['orderBy'] . '&page=' . ($data['pages']['current'] - 1); ?>">
                        &laquo; Previous
                    </a>
                </li>
            <?php endif; ?>

            <?php
            $skipped = false;
            for ($i = 0; $i < $data['pages']['total']; $i++):
                if (($i > 1 && $i < $data['pages']['total'] - 2)
                    && ($i < $data['pages']['current'] - 4 || $i > $data['pages']['current'] + 2)) {
                    $skipped = true;
                    continue;
                } ?>
                <?php if ($skipped): $skipped = false; ?>
                <li class="page-item disabled">
                    <a class="page-link">...</a>
                </li>
            <?php endif; ?>
                <li class="page-item<?php if ($data['pages']['current'] == $i + 1): ?> active<?php endif; ?>">
                    <a class="page-link"
                       href="<?php echo $config['basePath'] . '?orderby=' . $data['pages']['orderBy'] . '&page=' . ($i + 1); ?>">
                        <?php echo $i + 1; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($data['pages']['current'] == $data['pages']['total']): ?>
                <li class="page-item disabled">
                    <a class="page-link" href="#">Next &raquo;</a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link"
                       href="<?php echo $config['basePath'] . '?orderby=' . $data['pages']['orderBy'] . '&page=' . ($data['pages']['current'] + 1); ?>">
                        Next &raquo;
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</nav>
