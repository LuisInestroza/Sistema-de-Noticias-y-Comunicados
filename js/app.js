// Funcion para cambiar cada tab
function changeTab(tab) {
  // Declaración de variables
  var i; // Contador
  var change = document.getElementsByClassName("single-tab"); // Obtener el div a mostrar
  //Ciclo que se encarga de hacer los cambios
  for (i = 0; i < change.length; i++) {
    change[i].style.display = "none";
  }
  document.getElementById(tab).style.display = "block";
}


// Mostrar alertas del incio de sesion
document.addEventListener("DOMContentLoaded", () => {
  // Limpiar las alertas
  let alertas = document.querySelector(".alertas");

  if (alertas) {
    limpiarAlertas(alertas);
  }

});

const limpiarAlertas = alertas => {
  // Verificar si el div alertas tiene hijos
  const interval = setInterval(() => {
    if (alertas.children.length > 0) {
      alertas.removeChild(alertas.children[0]);
    } else {
      alertas.parentElement.removeChild(alertas);
      clearInterval(interval);
    }
  }, 3000);
};