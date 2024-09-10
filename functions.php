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
    // Chargement du script de la lightbox
    wp_enqueue_script('lightbox-js', get_stylesheet_directory_uri() . '/assets/js/lightbox.js', array(), time(), true);


     // Enregistrer et localiser les scripts pour Select2
  wp_enqueue_script('select2-script', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0', true);
  wp_enqueue_style('select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
  wp_enqueue_script('select2-js', get_stylesheet_directory_uri() . '/assets/js/select2.js', array('jquery'), '1.0.0', true);

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
//   PAGINATION ET FILTRES
//============================

/**
 * Enregistre les scripts nécessaires et localise les scripts pour la pagination et les filtres.
 */
function enqueue_load_more_photos_script() {
    // Enregistrement des scripts nécessaires pour la pagination et les filtres.
    wp_enqueue_script('pagination', get_stylesheet_directory_uri() . '/assets/js/pagination.js', array('jquery'), null, true);
    wp_enqueue_script('filtres', get_stylesheet_directory_uri() . '/assets/js/filtres.js', array('jquery'), null, true);
  
    // Définition des paramètres AJAX communs pour être passés aux scripts.
    $ajax_params = array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'ajax_nonce' => wp_create_nonce('load_more_photos_nonce')
  );
  
    // Localisation des scripts pour passer les paramètres AJAX aux scripts en front-end.
    wp_localize_script('pagination', 'ajax_filtres', $ajax_params);
    wp_localize_script('filtres', 'ajax_filtres', $ajax_params);
  }
  add_action('wp_enqueue_scripts', 'enqueue_load_more_photos_script');
  
  /**
   * Traite les requêtes AJAX pour charger plus de photos.
   */
  function load_more_photos() {
    // Vérification du nonce pour sécuriser la requête AJAX.
    check_ajax_referer('load_more_photos_nonce', 'nonce'); 
  
    // Récupération des paramètres envoyés par la requête AJAX.
    $offset = isset($_POST['offset']) ? absint($_POST['offset']) : 0;
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? $_POST['order'] : 'DESC';
    
    // Configuration des arguments pour WP_Query selon les paramètres reçus.
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => $order,
        'tax_query' => []
    ];
  
    // Ajout de conditions supplémentaires de taxonomie si nécessaire.
    if (!empty($categorie) || !empty($format)) {
        $args['tax_query']['relation'] = 'AND';
        if (!empty($categorie)) {
          $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie
        ];
        }
  
        if (!empty($format)) {
            $args['tax_query'][] = [
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => $format
            ];
        }
    }
  
    // Exécution de la requête WP_Query.
    $query = new WP_Query($args);
    $output = '';
  
    // Vérifie s'il y a des photos dans la requête
    if ($query->have_posts()) {
        // Boucle à travers les photos
        while ($query->have_posts()) {
            $query->the_post();
            ob_start();
            // Inclusion du template pour afficher un bloc de photo.
            get_template_part('templates-part/block-photo', get_post_format()); 
            $output .= ob_get_clean();
        }
  
        // Vérification de la disponibilité d'autres photos.
        $has_more_photos = $query->found_posts > $offset + $query->post_count;
  
        // Réinitialisation des données globales du post.
        wp_reset_postdata();
  
        // Envoi de la réussite avec le contenu généré et l'état des photos restantes.
        wp_send_json_success(['html' => $output, 'has_more_photos' => $has_more_photos]);
    } else {
        // En cas d'absence de posts, envoi d'une erreur.
        wp_send_json_error('');
    }
    
    // Arrêt de l'exécution pour retourner une réponse propre.
    wp_die(); 
  }
  
  // Ajout des actions pour les requêtes AJAX pour les utilisateurs connectés et non connectés.
  add_action('wp_ajax_load_more_photos', 'load_more_photos');
  add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');  
  

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
