<?php get_header(); ?>

<?php
// Ici on recupere les custom fields photo, référence et type
$photoId = get_field('photo');
$reference = get_field('reference');
$refUppercase = strtoupper($reference);
$type = get_field('type');
$typeUppercase = mb_strtoupper ($type);

// Ici on recupere les taxonomies: catégories, formats et années
$categories = get_the_terms(get_the_ID(), 'categorie');
$categorie = !empty($categories) ? $categories[0]->name : '';
$categoryUppercase = mb_strtoupper($categorie);
$formats = get_the_terms(get_the_ID(), 'format');
$format_name = $formats ? ucwords($formats[0]->name) : '';
$formatUppercase = mb_strtoupper($format_name);

// Récupérer l'année de publication de la photo de WordPress
$annee = get_the_date('Y');  


// Pour définir les URL's des vignettes pour le post précédent et suivant
$nextPost = get_next_post();
$previousPost = get_previous_post();
$previousThumbnailURL = $previousPost ? get_the_post_thumbnail_url($previousPost->ID, 'thumbnail') : '';
$nextThumbnailURL = $nextPost ? get_the_post_thumbnail_url($nextPost->ID, 'thumbnail') : '';
?>

<!-- Section contenant les détails d'une photo -->
<section class="photo__list">
    <div class="photo__gallery">
        <div class="photo__detail">
            <div class="photo__container">
                              
                <!-- Affiche l'image de la photo -->
                <img src="<?php echo esc_url($photoId); ?>" alt="<?php the_title_attribute(); ?>">
            </div>

            <div class="photo__info">
                <!-- Affiche le titre de la photo -->
                <h2><?php echo esc_html(get_the_title()); ?></h2>

                <!-- Afffiche les métadonnés de la photo -->
                <div class="photo__meta">
                    <p>RÉFÉRENCE : <span id="single-reference"><?php echo esc_html($refUppercase); ?></span></p>
                    <p>CATÉGORIE : <?php echo esc_html($categorie); ?></p>
                    <p>FORMAT : <?php echo esc_html($formatUppercase); ?></p>
                    <p>TYPE : <?php echo esc_html($typeUppercase); ?></p>
                    <p>ANNÉE : <?php echo esc_html($annee); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="contact__container">
        <div class="contact">
            <!-- Affiche un message et un bouton pour contacter l'auteur de la photo -->
            <p class="interested">Cette photo vous intéresse ?</p>
            <button class="contact-btn" id="contact__button" data-reference="<?php echo $refUppercase; ?>">Contact</button>
        </div>

        <div class="navPhotos">
            <div class="miniature" id="miniature"></div>
                
                                  
            <div class="navArrow">
                <!-- Affiche les flèches de navigation vers les photos précédentes et suivantes -->
                <?php if (!empty($previousPost)) : ?>
                    <img class="arrow arrow-left" src="<?php echo get_theme_file_uri() . '/assets/images/left.png'; ?>" alt="Photo précédente" data-thumbnail-url="<?php echo $previousThumbnailURL; ?>" data-target-url="<?php echo esc_url(get_permalink($previousPost->ID)); ?>">
                <?php endif; ?>

                <?php if (!empty($nextPost)) : ?>
                    <img class="arrow arrow-right" src="<?php echo get_theme_file_uri() . '/assets/images/right.png'; ?>" alt="Photo suivante" data-thumbnail-url="<?php echo $nextThumbnailURL; ?>" data-target-url="<?php echo esc_url(get_permalink($nextPost->ID)); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Section de suggestions de photos similaires -->
<section class="suggestions">
    <div class="title__suggestion">
        <h3>VOUS AIMEREZ AUSSI</h3>
    </div>


<?php get_footer(); ?>