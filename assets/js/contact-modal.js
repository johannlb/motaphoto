// JS pour la popup modal

(function ($) {
  // Fonction pour ouvrir la modale
  function openModal() {
    $(".popup__overlay").css("display", "flex");
  }

  // Fonction pour fermer la modale
  function closeModal() {
    $(".popup__overlay").css("display", "none");
  }

  // Gestion du clic sur le bouton de contact
  $(".contact-btn").on("click", function (event) {
    event.preventDefault();

    // Récupérer la valeur de l'attribut data-reference du bouton cliqué
    var reference = $(this).attr("data-reference");

    // Pour définir la valeur du champ #refoto dans la modale de contact
    $("#refoto").val(reference);

    openModal();
  });

  // Gestion du clic sur les liens du menu (si nécessaire)
  $(".menu-contact-link").on("click", function (event) {
    event.preventDefault();

    // Vider le champ #refoto dans la modale de contact si ce n'est pas un bouton de contact
    $("#refoto").val("");

    openModal();
  });

  // Gestion du clic en dehors de la modale pour la fermer
  $(".popup__overlay").on("click", function (event) {
    if (event.target === this) {
      closeModal();
    }
  });

  // Gestion du clic sur la croix pour fermer la modale
  $(".popup__close").on("click", function () {
    closeModal();
  });

  // Gestion du clic sur la touche "Echap" pour fermer la modale
  $(document).on("keydown", function (e) {
    if (e.key === "Escape") {
      closeModal();
    }
  });
})(jQuery);