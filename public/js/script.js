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

// Script pour activer ou désactiver le darkMode
function toggleLightDarkMode() { 
  const container = document.getElementById('main');
  const dataTheme = container.getAttribute('data-theme');
  if(dataTheme === 'dark') {
    container.setAttribute('data-theme', 'light');
    window.sessionStorage.setItem('mode', 'light');
  } else {
    container.setAttribute('data-theme', 'dark');
    window.sessionStorage.setItem('mode', 'dark');
  }
}

// Applique le theme dark ou light en fonction du mode enregistré en session
if("mode" in window.sessionStorage) {
  const container = document.getElementById('main');
  if(window.sessionStorage.getItem("mode") == "dark") {
    container.setAttribute('data-theme', 'dark');
    document.getElementById("switchMode").checked = true;
  }
  if(window.sessionStorage.getItem("mode") == "light") {
    container.setAttribute('data-theme', 'light');
    document.getElementById("switchMode").checked = false;
  }
}