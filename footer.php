<footer>
    <nav>
        <?php
        // Fonction pour le menu footer
        wp_nav_menu( array(
            'theme_location' => 'footer-menu',
            'container'      => 'false',
            'menu_class'     => 'footer-menu',
        ) );
        ?>
    </nav>


<!-- Fonction pour appeler le template contact-modal.php -->
<?php get_template_part('templates-part/contact-modal'); ?>


    <div class="footer-credits">
        <p>Tous droits réservés</p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>