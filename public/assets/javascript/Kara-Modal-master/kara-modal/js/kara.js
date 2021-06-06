/**
 * Source : http://www.grafikart.fr
 */
/* Variable modal */
let modal = null
/* Selecteur du focus */
const focusableSelector = "button, a, input, textarea"
/* Variable focusables */
let focusables = []
/* Variable qui cible l'élément précédent */
let previouslyFocusedElement = null

/**
 * Permet d'ouvir la boite modal
 * @param {*} e 
 */
const openModal = async function (e) {
    e.preventDefault()
    const target = e.target.getAttribute('href')
    if (target.startsWith('#')){
        modal = document.querySelector(target)
    } else {
        modal = await loadModal(target)
    }
    
    focusables = Array.from(modal.querySelectorAll(focusableSelector))
    previouslyFocusedElement = document.querySelector(':focus')
    modal.style.display = null
    focusables[0].focus()
    modal.removeAttribute('aria-hidden')
    modal.setAttribute('aria-modal', 'true')
    modal.addEventListener('click', closeModal)
    modal.querySelector('.js-kara-modal-close').addEventListener('click', closeModal)
    modal.querySelector('.js-kara-modal-stop').addEventListener('click', stopPropagation)
}

/**
 * Permet de fermer la boite modal
 * @param {*} e 
 */
const closeModal = function (e) {
    if (modal === null) return
    if (previouslyFocusedElement !== null) previouslyFocusedElement.focus()
    e.preventDefault()
    modal.setAttribute('aria-hidden', 'true')
    modal.removeAttribute('aria-modal')
    modal.removeEventListener('click', closeModal)
    modal.querySelector('.js-kara-modal-close').removeEventListener('click', closeModal)
    modal.querySelector('.js-kara-modal-stop').removeEventListener('click', stopPropagation)
    const hideModal = function () {
        modal.style.display = "none"
        modal.removeEventListener('animationend', hideModal)
        modal = null
    }
    modal.addEventListener('animationend', hideModal)
}

/**
 * Permet de stoper la propagation
 */
const stopPropagation = function (e) {
    e.stopPropagation()
}

/**
 * Permet de focus les éléments
 */
const focusInModal = function (e) {
    e.preventDefault()
    let index = focusables.findIndex(f => f === modal.querySelector(':focus'))
    if (e.shiftKey === true) {
        index--
    } else{
        index++
    }
    
    if (index >= focusables.length) {
        index = 0
    }
    if (index < 0) {
        index = focusables.length - 1
    }
    focusables[index].focus()
}

/**
 * Permet de charger une modal en Ajax
 */
const loadModal = async function (url) {
  const target = '#' + url.split('#')[1]
  const existingModal = document.querySelector(target)
  if (existingModal !== null) return existingModal
  const html = await fetch(url).then(response => response.text())
  const element = document.createRange().createContextualFragment(html).querySelector(target)
  if (element === null) throw `L'élément ${target} n'a pas été trouvé dans la page ${url}`
  document.body.append(element)
  return element
}


/**
 * Permet d'appeler la function afin d'ouvrir la boite modal
 */
document.querySelectorAll('.js-kara-modal').forEach(a => {
    a.addEventListener('click', openModal)
    
})

/**
 * Permet de fermer la boite modal avec la touche "Echap"
 */
window.addEventListener('keydown', function (e) {
    if (e.key === "Escape" || e.key == "Esc") {
        closeModal(e)
    }
    if (e.key == 'Tab' && modal !== null) {
        focusInModal(e)
    }
})