const cita={hora:""};function iniciarApp(){buscarPorFecha()}function buscarPorFecha(){document.querySelector("#fecha").addEventListener("input",(function(n){const t=n.target.value;window.location=`?fecha=${t}`}))}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));