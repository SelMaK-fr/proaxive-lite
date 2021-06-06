/* Variable de l'ID omega-content */
var content = document.querySelector('#omega-content');
/* Variable de l'ID omega-sidebar-body */
var sidebarBody = document.querySelector('#omega-sidebar-body');
/* Variable du bouton hamburger */
var button = document.querySelector('#omega-button');
/* Variable de la div overlay */
var overlay = document.querySelector('#omega-overlay');
/* Class CSS */
var activatedClass = 'omega-activated';
var contentNav = document.querySelector('#omega');


sidebarBody.innerHTML = content.innerHTML

/**
 * Permet de d'ajouter la class CSS omega-activated si le bouton est cliqué
 */
button.addEventListener('click', function (e){
    e.preventDefault;
    contentNav.classList.add(activatedClass);
});

/**
 * Permet de fermer la sidebar avec la touche echap du clavier
 */
button.addEventListener('keydown', function (e){
    if (this.parentNode.classList.contains(activatedClass))
    {
        if (e.repeat === false && e.which === 27)
            this.parentNode.classList.remove(activatedClass);
    }
});

/**
 * Permet de fermer la sidebar si clic dans l'overlay
 */
overlay.addEventListener('click', function (e){
    e.preventDefault;
    this.parentNode.classList.remove(activatedClass);
})



