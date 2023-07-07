// Scroll à une position choisie
function scrollToPosition(position) {
    window.scrollTo({
        top: position,
        behavior: 'smooth' // 'smooth' pour un défilement fluide, 'auto' pour un défilement instantané
    });
}

scrollToPosition(500);

// Après le chargement de la page, positionne la barre de défilement en bas des messages
window.addEventListener('load', function () {
    var messageList = document.getElementById('messageList');
    messageList.scrollTop = messageList.scrollHeight;
});