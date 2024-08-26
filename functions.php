<?php

function nathalie_mota_scripts() {
    // Chargement du thème
    wp_enqueue_style('nathalie-mota-style', get_template_directory_uri() . '/assets/sass/theme.css', array(), 1.1);
}

add_action('wp_enqueue_scripts', 'nathalie_mota_scripts');

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' ); 
add_theme_support( 'title-tag' );

// Ajouter des emplacements de menus
register_nav_menus( array(
	'main' => 'Menu Principal',
	'footer' => 'Menu footer',
));