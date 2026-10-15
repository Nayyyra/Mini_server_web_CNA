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

const botonesEliminar = document.querySelectorAll(".eliminate-button");

botonesEliminar.forEach((boton) => {
  boton.addEventListener("click", (evento) => {
    let nombre = prompt("Introduce la clave para eliminar el anuncio");

    if(nombre!=="7367"){
      alert("Incorrecto. No se eliminara el anuncio")
      evento.preventDefault();
      return;
    }
  });
});

const botonesEditar = document.querySelectorAll(".edit-button");

botonesEditar.forEach((boton) => {
  boton.addEventListener("click", (evento) => {
    document.getElementById("tituloFormulario").textContent = "Editar anuncio";
    document.getElementById("titulo").value = boton.dataset.titulo;
    document.getElementById("autor").value = boton.dataset.autor;
    document.getElementById("descripcion").value = boton.dataset.descripcion;
    document.getElementById("contenido").value = boton.dataset.contenido;
    document.getElementById("idAnuncio").value = boton.dataset.id;
    document.getElementById("enviar").setAttribute('name', 'actualizar');
    document.getElementById("enviar").textContent = "Editar";
  });
});
