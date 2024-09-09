<?php

//============================
//   Fonctions de chargement du thème
//============================

/**
 * Chargement des styles et scripts du thème.
 */
function nathalie_mota_scripts() {
    // Chargement du fichier CSS principal du thème
    wp_enqueue_style('nathalie-mota-style', get_template_directory_uri() . '/assets/sass/theme.css', array(), '1.1');
    // Chargement de jQuery
    wp_enqueue_script('jquery');
    // Chargement du script pour le menu burger
    wp_enqueue_script('burger-js', get_stylesheet_directory_uri() . '/assets/js/burger.js', array(), time(), true);  
     // Chargement de la modale de contact
    wp_enqueue_script('contact-modal-js', get_template_directory_uri() . '/assets/js/contact-modal.js', array(), time(), true); 
    // Chargement de scripts.js
    wp_enqueue_script('scripts-js', get_template_directory_uri() . '/assets/js/scripts.js', array(), time(), true);
    // Chargement du script pour les miniatures
    wp_enqueue_script('miniature-js', get_stylesheet_directory_uri() . '/assets/js/miniature.js', array('jquery'), '1.0.0', true);

    
}
add_action('wp_enqueue_scripts', 'nathalie_mota_scripts');

//============================
//   Support de fonctionnalités du thème
//============================

/**
 * Ajout du support des images mises en avant.
 */
add_theme_support('post-thumbnails');

/**
 * Ajout du support pour le titre automatique du site dans l'en-tête.
 */
add_theme_support('title-tag');

//============================
//   Enregistrement des menus
//============================

/**
 * Enregistrement des menus de navigation.
 */
function register_my_menus() {
    register_nav_menus(
        array(
            'main-menu'   => __('Main Menu'),  // Menu principal
            'footer-menu' => __('Footer Menu') // Menu pied de page
        )
    );
}
add_action('init', 'register_my_menus');

//============================
//   Requêtes et filtres personnalisés
//============================

/**
 * Fonction pour retirer la clause "AND (0 = 1)" de la requête WHERE
 */
function remove_zero_clause_from_where($where) {
    return str_replace("AND (0 = 1)", "", $where);
}

//============================
//   Fonction pour récupérer une image de fond aléatoire
//============================

function get_random_background_image() {
    // Arguments de la requête pour récupérer une photo aléatoire
    $args = array(
        'post_type'      => 'photo',      // Type de publication : photo
        'posts_per_page' => 1,            // Nombre de photos à récupérer (1 pour une photo aléatoire)
        'orderby'        => 'rand',       // Tri aléatoire
    );
  
    // Exécute la requête WP_Query avec les arguments
    $photo_query = new WP_Query($args);
  
    // Initialise la variable pour stocker l'URL de l'image
    $photo_url = '';
  
    // Vérifie s'il y a des photos dans la requête
    if ($photo_query->have_posts()) {
        // Boucle à travers les photos
        while ($photo_query->have_posts()) {
            $photo_query->the_post();
            // Récupère l'URL de l'image mise en avant
            $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }
        // Réinitialise les données post
        wp_reset_postdata();
    }
  
    // Retourne l'URL de l'image
    return $photo_url;
  }

?>
