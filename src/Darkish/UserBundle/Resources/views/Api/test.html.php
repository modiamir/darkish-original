<?php $view->extend('::base.html.twig') ?>

<?php $view['slots']->set('title', 'DarkishUserBundle:Api:test') ?>

<?php $view['slots']->start('body') ?>
    <h1>Welcome to the Api:test page</h1>
<?php $view['slots']->stop() ?>
