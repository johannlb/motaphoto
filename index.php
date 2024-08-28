<?php get_header(); ?>

    <?php
    // Boucle WordPress pour afficher le contenu de la page
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        <?php
        endwhile;
    else :
        echo '<p>Aucun contenu trouvé</p>';
    endif;
    ?>


<?php get_footer(); ?>