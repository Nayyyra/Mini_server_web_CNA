document.addEventListener('DOMContentLoaded', () => {
  const formulario = document.querySelector('.form-card form');

  formulario.addEventListener('submit', (event) => {

    const titulo = document.getElementById('titulo').value.trim();
    const autor = document.getElementById('autor').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    const contenido = document.getElementById('contenido').value.trim();

    if (titulo === '' || autor === '' || descripcion === '' || contenido === '') {
      alert('Por favor, completa todos los campos.');
      event.preventDefault();
      return;
    }
  })
})

const botones = document.querySelectorAll(".eliminate-button");

botones.forEach((boton) => {
  boton.addEventListener("click", (evento) => {
    let nombre = prompt("Introduce la clave para eliminar el anuncio");

    if(nombre!=="7367"){
      alert("Incorrecto. No se eliminara el anuncio")
      evento.preventDefault();
      return;
    }
  });
});