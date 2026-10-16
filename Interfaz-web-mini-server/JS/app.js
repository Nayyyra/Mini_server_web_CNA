document.addEventListener('DOMContentLoaded', () => {
  const formulario = document.querySelector('.form-card form');

  const inputTitulo = document.getElementById('titulo');
  const inputAutor = document.getElementById('autor');
  const inputDescripcion = document.getElementById('descripcion');
  const inputContenido = document.getElementById('contenido');

  //escuchamos los caracteres que se estan introduciendo en cada campo para eliminar el aviso de error en tiempo real en lugar de recargar la página continuamente.
  inputTitulo.addEventListener('input', () => {
    if (inputTitulo.value.trim().length >= 5) {
      limpiarError(inputTitulo);
    }
  });

  inputAutor.addEventListener('input', () => {
    if (inputAutor.value.trim().length >= 3) {
      limpiarError(inputAutor);
    }
  });

  inputDescripcion.addEventListener('input', () => {
    if (inputDescripcion.value.trim().length >= 10) {
      limpiarError(inputDescripcion);
    }
  });

  inputContenido.addEventListener('input', () => {
    if (inputContenido.value.trim().length >= 25) {
      limpiarError(inputContenido);
    }
  });

  formulario.addEventListener('submit', (event) => {
    let formularioValido = true;

    const inputTitulo = document.getElementById('titulo');
    const valorTitulo = inputTitulo.value.trim();

    if (valorTitulo === '') {
      mostrarError(inputTitulo, 'El título es obligatorio.');
      formularioValido = false;
    } else if (valorTitulo.length < 5) {
      mostrarError(inputTitulo, 'El título debe tener al menos 5 caracteres.');
      formularioValido = false;
    } else {
      limpiarError(inputTitulo);
    }

    const inputAutor = document.getElementById('autor');
    const valorAutor = inputAutor.value.trim();

    if (valorAutor === '') {
      mostrarError(inputAutor, 'El autor es obligatorio.');
      formularioValido = false;
    } else if (valorAutor.length < 3) {
      mostrarError(inputAutor, 'El autor debe tener al menos 3 caracteres.');
      formularioValido = false;
    } else {
      limpiarError(inputAutor);
    }

    const inputDescripcion = document.getElementById('descripcion');
    const valorDescripcion = inputDescripcion.value.trim();

    if (valorDescripcion === '') {
      mostrarError(inputDescripcion, 'La descripción es obligatoria.');
      formularioValido = false;
    } else if (valorDescripcion.length < 10) {
      mostrarError(inputDescripcion, 'La descripción debe tener al menos 10 caracteres.');
      formularioValido = false;
    } else {
      limpiarError(inputDescripcion);
    }
    

    const inputContenido = document.getElementById('contenido');
    const valorContenido = inputContenido.value.trim();

    if (valorContenido === '') {
      mostrarError(inputContenido, 'El contenido es obligatorio.');
      formularioValido = false;
    } else if (valorContenido.length < 25) {
      mostrarError(inputContenido, 'El contenido debe tener al menos 25 caracteres.');
      formularioValido = false;
    } else {
      limpiarError(inputContenido);
    }

    // Si no se cumplen las condiciones para publicar el anuncio, cancelamos el envío del formulario
    if (formularioValido === false) {
      event.preventDefault();
    }
  });
});

  // Anuncio borrado o no
const cajaAviso = document.getElementById('caja-aviso');
const btnCerrarAviso = document.getElementById('btn-cerrar-aviso');

if (cajaAviso) {
  // Quitar la ventanita
  const cerrarAviso = () => {
    cajaAviso.remove();
  };

  // Cerrar al pulsar aceptar
  if (btnCerrarAviso) {
    btnCerrarAviso.addEventListener('click', cerrarAviso);
  }

  //sino cerrar tras 4s
  setTimeout(cerrarAviso, 4000);
}

const botonesEliminar = document.querySelectorAll(".eliminate-button");

botonesEliminar.forEach((boton) => {
  boton.addEventListener("click", (evento) => {
    const pinIntroducido = prompt("Introduce la clave para eliminar el anuncio:");

    // Si cancela o lo deja en blanco, frenamos el envío
    if (pinIntroducido === null || pinIntroducido.trim() === "") {
      evento.preventDefault();
      return;
    }

    const formulario = boton.closest("form");
    const inputPin = formulario.querySelector(".input-pin");

    // Metemos lo que ha tecleado el usuario dentro del input hidden  
    inputPin.value = pinIntroducido.trim();
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

function mostrarError(input, mensaje) {
  //closest se encarga de localizar la cajita que envuelve el punto donde esta el error para que el mensaje salga en el sitio corrrecto
  const grupo = input.closest('.form-group');
  
  // limpiamos por si ya había un mensaje de error antes
  const errorPrevio = grupo.querySelector('.error-mensaje');
  if (errorPrevio) {
    errorPrevio.remove();
  }

  input.classList.add('input-error');

  const span = document.createElement('span');
  span.className = 'error-mensaje';
  span.textContent = mensaje;
  grupo.appendChild(span);
}

function limpiarError(input) {
  input.classList.remove('input-error');
  const grupo = input.closest('.form-group');
  const errorPrevio = grupo.querySelector('.error-mensaje');
  if (errorPrevio) {
    errorPrevio.remove();
  }
}
