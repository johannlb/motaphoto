jQuery(document).ready(function ($) {
  const menuBurger = $(".burgerMenu");
  const nav = $(".navbar__menu");

  menuBurger.on("click", function () {
    nav.toggleClass("open");
    if (nav.hasClass("open")) {
      menuBurger.addClass("open"); // Assurez-vous que la croix est affichée
    } else {
      menuBurger.removeClass("open");
      nav.removeClass("close"); // Assurez-vous de retirer la classe close
    }
  });
});