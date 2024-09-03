<?php
// Pour récupérer l'URL de la photo
$photoUrl = get_the_post_thumbnail_url(get_the_ID(), 'large');

// vérifier si l'URL de l'image mise en avant a été récupéré avec succès
if ($photoUrl) {
    // Récupère le titre, l'URL du post, la référence et la catégorie comme avant
    $title_photo = get_the_title();
    $url_post = get_permalink();
    $reference = get_field('reference');
    $categories = get_the_terms(get_the_ID(), 'categorie');
    $categorie = !empty($categories) ? $categories[0]->name : '';

    // Affichage du bloc de photo
    ?>
    <div class="block__photo">
        <img src="<?php echo esc_url($photoUrl); ?>" alt="<?php the_title_attribute(); ?>">
        <div class="overlay">
            <h2><?php echo esc_html($title_photo); ?></h2>
            <?php if (!empty($categorie)) : ?>
                <h3><?php echo esc_html($categorie); ?></h3>
            <?php endif; ?>
            <div class="eye-icon">
                <a href="<?php echo esc_url($url_post); ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icon_eye.svg" alt="Voir la photo">
                </a>
            </div>
            <div class="icon-fullscreen" data-full="<?php echo esc_attr($photoUrl); ?>" data-category="<?php echo esc_attr($categorie); ?>" data-reference="<?php echo esc_attr($reference); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/Icon_fullscreen.svg" alt="Voir l'image en plein écran">
            </div>
        </div>
    </div>
    <?php
} else {
    // Si aucune image n'est trouvée, afficher un autre contenu
    echo '<p>Aucune image disponible pour cette publication.</p>';
}