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
    // Chargement de scripts.js
    wp_enqueue_script('scripts-js', get_template_directory_uri() . '/assets/js/scripts.js', array(), time(), true);
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

?>