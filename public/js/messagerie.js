// Après le chargement de la page, positionne la barre de défilement en bas des messages
window.addEventListener('load', function() {
    var messageList = document.getElementById('messageList');
    messageList.scrollTop = messageList.scrollHeight;
});