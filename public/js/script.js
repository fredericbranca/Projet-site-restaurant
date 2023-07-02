  // Script pour la durée du message d'alerte avant de le faire disparaître
  function tempAlert(duration, className){
    var msg = document.getElementById(className);
    console.log(msg);
    msg.style.transition = "1s";
    msg.style.opacity = "1";
    setTimeout(function(){
        msg.style.opacity = "0";
    },duration);
}