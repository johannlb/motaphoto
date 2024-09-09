<?php
// La boucle WordPress pour afficher les photos avec WP_Query
$args = array(
    'post_type' => 'photo', // Type de publication : photo
    'posts_per_page' => 8, // Limite à 8 photos par défaut
    
);

// Exécute la requête WP_Query avec les arguments
$block__photo = new WP_Query($args);

// Vérifie s'il y a des photos dans la requête
if ($block__photo->have_posts()) :
    // Je définie les arguments pour le bloc photo
    set_query_var('photo_block_args', array('context' => 'front-page'));

    // Boucle pour afficher chaque photo
    while ($block__photo->have_posts()) :;
        $block__photo->the_post();
    ?>
        <div class="photo-item">
            <?php
        // Inclure le contenu du template "block-photo.php"
        get_template_part('templates-part/block-photo');
        ?>
        </div>

<?php
    endwhile;

    // Je réinitialise la requête
    wp_reset_postdata();
else :
    // Message si aucune photo trouvée
    echo 'Aucune photo trouvée.';
endif;
?>
</div>