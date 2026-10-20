/* Se ejecuta cuando se carga el HTML entero */
document.addEventListener('DOMContentLoaded', () => {
  /* Guardamos inputs del form */
  const formulario = document.querySelector('.form-card form');

  const inputTitulo = document.getElementById('titulo');
  const inputAutor = document.getElementById('autor');
  const inputDescripcion = document.getElementById('descripcion');
  const inputContenido = document.getElementById('contenido');

  // Escuchamos los caracteres que se estan introduciendo en cada campo para eliminar el aviso de error
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

  /* Validación del form cuando se va a enviar */
  formulario.addEventListener('submit', (event) => {
    /* Establecemos por defecto que sea true */
    let formularioValido = true;

    /* Guardamos el valor del título */
    const inputTitulo = document.getElementById('titulo');
    const valorTitulo = inputTitulo.value.trim();

    /* Validación del título */
    if (valorTitulo === '') {
      mostrarError(inputTitulo, 'El título es obligatorio.');
      formularioValido = false;
    } else if (valorTitulo.length < 5) {
      mostrarError(inputTitulo, 'El título debe tener al menos 5 caracteres.');
      formularioValido = false;
    } else {
      limpiarError(inputTitulo);
    }

    /* Guardamos el valor del autor */
    const inputAutor = document.getElementById('autor');
    const valorAutor = inputAutor.value.trim();

    /* Validación del autor */
    if (valorAutor === '') {
      mostrarError(inputAutor, 'El autor es obligatorio.');
      formularioValido = false;
    } else if (valorAutor.length < 3) {
      mostrarError(inputAutor, 'El autor debe tener al menos 3 caracteres.');
      formularioValido = false;
    } else {
      limpiarError(inputAutor);
    }
    
    /* Guardamos el valor de la descripción */
    const inputDescripcion = document.getElementById('descripcion');
    const valorDescripcion = inputDescripcion.value.trim();
    
    /* Validación de la descripción */
    if (valorDescripcion === '') {
      mostrarError(inputDescripcion, 'La descripción es obligatoria.');
      formularioValido = false;
    } else if (valorDescripcion.length < 10) {
      mostrarError(inputDescripcion, 'La descripción debe tener al menos 10 caracteres.');
      formularioValido = false;
    } else {
      limpiarError(inputDescripcion);
    }
    
    /* Guardamos el valor del contenido */
    const inputContenido = document.getElementById('contenido');
    const valorContenido = inputContenido.value.trim();

    /* Validación del contenido */
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
      /* Se cancela la acción (en este caso enviar el formulario) */
      event.preventDefault();
    }
  });
});

/* Guardamos la caja del mensaje de aviso y el botón de cerrar el aviso */
const cajaAviso = document.getElementById('caja-aviso');
const btnCerrarAviso = document.getElementById('btn-cerrar-aviso');

/* Si hay caja de aviso */
if (cajaAviso) {
  /* Si el navegador permite la función window.history.replaceState
  limpia los parámetros como ?status= de la URL */
  if (window.history.replaceState) {
    /* Borra todo lo que haya después del signo de interrogación en la dirección web */
    window.history.replaceState(null, '', window.location.pathname);
  }

  // Quitar la ventanita de aviso
  const cerrarAviso = () => {
    cajaAviso.remove();
  };

  // Cerrar al pulsar aceptar
  if (btnCerrarAviso) {
    btnCerrarAviso.addEventListener('click', cerrarAviso);
  }

  // Sino cerrar tras 4s
  setTimeout(cerrarAviso, 4000);
}

/* Guardamos todos los botones para eliminar anuncios */
const botonesEliminar = document.querySelectorAll(".btn-eliminar");

/* Recorremos los botones que permiten eliminar anuncios */
botonesEliminar.forEach((boton) => {
  /* Cuando se haga click en alguno de ellos */
  boton.addEventListener("click", (evento) => {
    /* Te pide pin para eliminar el anuncio */
    const pinIntroducido = prompt("Introduce la clave para eliminar el anuncio:");

    // Si cancelo o lo dejo en blanco, se frena el envío
    if (pinIntroducido === null || pinIntroducido.trim() === "") {
      evento.preventDefault();
      return;
    }

    /* Busca el formulario contenedor del botón */
    const formulario = boton.closest("form");
    /* Al localizar ese formulario, busca dentro de él la casilla invisible
    que tiene la clase .input-pin (que es un input type="hidden") */
    const inputPin = formulario.querySelector(".input-pin");

    // Metemos lo que ha tecleado el usuario dentro del input (value="x")
    inputPin.value = pinIntroducido.trim();
  });
});

/* Guardamos todos los botones para editar anuncios */
const botonesEditar = document.querySelectorAll(".edit-button");

/* Recorremos todos los botones */
botonesEditar.forEach((boton) => {
  /* Al hacer click sobre alguno */
  boton.addEventListener("click", (evento) => {
    /* Se cambia el título del formulario a "Editar anuncio" */
    document.getElementById("tituloFormulario").textContent = "Editar anuncio";
    /* Se asigna los valores del anuncio a los campos del form para poder editarlos */
    document.getElementById("titulo").value = boton.dataset.titulo;
    document.getElementById("autor").value = boton.dataset.autor;
    document.getElementById("descripcion").value = boton.dataset.descripcion;
    document.getElementById("contenido").value = boton.dataset.contenido;
    document.getElementById("idAnuncio").value = boton.dataset.id;
    /* Cambiamos el atributo name de enviar */
    document.getElementById("enviar").setAttribute('name', 'actualizar');
    /* Cambiamos el texto que muestra a editar */
    document.getElementById("enviar").textContent = "Editar";
  });
});

/* Función para mostrar mensajes de error visuales debajo de cada campo */
function mostrarError(input, mensaje) {
  /* Closest se encarga de localizar la cajita que envuelve el punto
  donde esta el error para que el mensaje salga en el sitio corrrecto */
  const grupo = input.closest('.form-group');
  
  // Limpiamos por si ya había un mensaje de error antes
  const errorPrevio = grupo.querySelector('.error-mensaje');
  if (errorPrevio) {
    errorPrevio.remove();
  }

  /* Añade la clase css a la casilla del formulario */
  input.classList.add('input-error');

  /* Crea una etiqueta <span> con el mensaje de error y la inserta */
  const span = document.createElement('span');
  /* Le asigna una clase */
  span.className = 'error-mensaje';
  span.textContent = mensaje;
  grupo.appendChild(span);
}

/* Función para limpiar las alertas visuales de error */
function limpiarError(input) {
  /* Quita la clase css */
  input.classList.remove('input-error');
  const grupo = input.closest('.form-group');
  const errorPrevio = grupo.querySelector('.error-mensaje');
  if (errorPrevio) {
    errorPrevio.remove();
  }
}

/* Fuerza la recarga de la página si el usuario regresa con las flechas de navegación del navegador */
window.addEventListener('pageshow', (event) => {
  /* Si la página viene guardada de la caché */
  if (event.persisted) {
    /* Recarga la página solicitandola al server para actualizar el contenido */
    window.location.reload();
  }
});
