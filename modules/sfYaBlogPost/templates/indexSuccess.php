<?php
/**
 * Посты блога
 *
 * @param sfDoctrinePager $pager
 */
slot('page_header', 'Блог');
?>

<?php if (count($posts = $pager->getResults())): ?>
    <?php include_partial('sfYaBlogPost/list', array('posts' => $posts)); ?>

    <?php include_partial('global/inc.pagination', array(
        'pager' => $pager,
        'route' => 'sfYaBlogPost',
    )); ?>
<?php else: ?>
    <p>Блог пуст.</p>
<?php endif; ?>