<?php

use dmstr\adminlte\widgets\Menu;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4"">
<a href="" title="" class="brand-link">
    <span class="brand-text font-weight-light">Voting EAP</span>
</a>
<section class="sidebar">
    <nav class="mt-2">


        <?= Menu::widget(
            [
                'options' => ['class' => 'nav nav-pills nav-sidebar nav-child-indent flex-column"', 'data-widget' => 'tree'],
                'items' => \backend\components\Menu::getAdminMenu()
            ]
        ) ?>
    </nav>
</section>

</aside>
