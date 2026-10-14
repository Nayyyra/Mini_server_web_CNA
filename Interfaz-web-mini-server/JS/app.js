document.addEventListener('DOMContentLoaded', () => {
  const formulario = document.querySelector('.form-card form');
  const cardsGrid = document.querySelector('.cards-grid');

  // Paleta de colores estándar (de izquierda a derecha)
  const coloresPatron = [
    'card-amarillo',
    'card-naranja',
    'card-rosa',
    'card-morado'
  ];

  // Función para calcular el color en zigzag
  function getSiguienteColorZigZag() {
    const totalTarjetas = cardsGrid.children.length;
    const columnas = 4; // Grid de 4 columnas por fila

    const fila = Math.floor(totalTarjetas / columnas);
    const columna = totalTarjetas % columnas;

    // Fila PAR (0, 2, 4...): Izquierda a Derecha (0, 1, 2, 3)
    // Fila IMPAR (1, 3, 5...): Derecha a Izquierda (3, 2, 1, 0)
    const indiceColor = (fila % 2 === 0) ? columna : (columnas - 1 - columna);

    return coloresPatron[indiceColor];
  }

  formulario.addEventListener('submit', (event) => {
    event.preventDefault();

    const titulo = document.getElementById('titulo').value.trim();
    const autor = document.getElementById('autor').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();

    if (titulo === '' || autor === '' || descripcion === '') {
      alert('Por favor, completa todos los campos.');
      return;
    }

    const hoy = new Date();
    const fechaFormateada = hoy.toLocaleDateString('es-ES', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    });

    // Calcular color dinámico
    const colorActual = getSiguienteColorZigZag();

    // Crear la tarjeta dinámicamente
    const nuevaTarjeta = document.createElement('article');
    nuevaTarjeta.className = `card ${colorActual}`;

    nuevaTarjeta.innerHTML = `
      <h3 class="card-title">${escapeHTML(titulo)}</h3>
      <p class="card-body">${escapeHTML(descripcion)}</p>
      <div class="card-footer">
        <span class="author-info">${escapeHTML(autor)}<br><small>${fechaFormateada}</small></span>
      </div>
    `;

    cardsGrid.appendChild(nuevaTarjeta);
    formulario.reset();
  });

  // Función de prevención de XSS
  function escapeHTML(str) {
    return str.replace(/[&<>'"]/g, 
      tag => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#39;',
        '"': '&quot;'
      }[tag] || tag)
    );
  }
});