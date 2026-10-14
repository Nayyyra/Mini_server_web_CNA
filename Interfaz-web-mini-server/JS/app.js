// Cuando carga la página
document.addEventListener('DOMContentLoaded', () => {
  // Busca el form dentro del contenedor con la clase form-card
  const formulario = document.querySelector('.form-card form');
  // Busca el contenedor con la clase cards-grid 
  const cardsGrid = document.querySelector('.cards-grid');

  // Patrón de colores estándar para los anuncios (de izquierda a derecha)
  const coloresPatron = [
    'card-amarillo',
    'card-naranja',
    'card-rosa',
    'card-morado'
  ];

  // Función para calcular el color en zigzag
  function getSiguienteColorZigZag() {
    // Cuenta las tarjetas guardadas dentro del contenedor
    const totalTarjetas = cardsGrid.children.length;
    // Número de columnas (anuncios) por fila
    const columnas = 4;
    // Calcula el número de fila en el que irá la siguiente tarjeta
    const fila = Math.floor(totalTarjetas / columnas);
    // Calcula la columna en la que irá la tarjeta
    const columna = totalTarjetas % columnas;

    // Fila PAR (0, 2, 4...): Izquierda a Derecha (0, 1, 2, 3)
    // Fila IMPAR (1, 3, 5...): Derecha a Izquierda (3, 2, 1, 0)
    const indiceColor = (fila % 2 === 0) ? columna : (columnas - 1 - columna);

    // Devuelve el patrón de color calculado
    return coloresPatron[indiceColor];
  }

  // Cuando se hace click en el botón de publicar del formulario
  formulario.addEventListener('submit', (event) => {
    // Evita que se recargue la página y se borren los anuncios ya publicados
    event.preventDefault();

    // Guardamos los datos que ha introducido el usuario en los input y eliminamos posibles espacios
    const titulo = document.getElementById('titulo').value.trim();
    const autor = document.getElementById('autor').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();

    // Si alguno de los campos está vacío, muestra mensaje y no deja publicar
    if (titulo === '' || autor === '' || descripcion === '') {
      alert('Por favor, completa todos los campos.');
      return;
    }

    // Obtiene la fecha del momento en el que se publica el anuncio
    const hoy = new Date();
    // Formateamos la fecha para que aparezca en formato dd/mm/yyyy
    const fechaFormateada = hoy.toLocaleDateString('es-ES', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    });

    // Ejectua la función para calcular color de la nueva tarjeta
    const colorActual = getSiguienteColorZigZag();

    // Crea la nueva tarjeta
    const nuevaTarjeta = document.createElement('article');
    // Le asigna la clase css del color que sea la tarjeta
    nuevaTarjeta.className = `card ${colorActual}`;

    // Escribe los valores pasados por el usuario en la nueva tarjeta
    nuevaTarjeta.innerHTML = `
      <h3 class="card-title">${titulo}</h3>
      <p class="card-body">${descripcion}</p>
      <div class="card-footer">
        <span class="author-info">${autor}<br><small>${fechaFormateada}</small></span>
      </div>
    `;

    // Añadimos la tarjeta que se acaba de crear al final del contenedor
    cardsGrid.appendChild(nuevaTarjeta);
    // Vacía los campos del fomulario
    formulario.reset();
  });
  
});