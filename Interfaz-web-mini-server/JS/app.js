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

  });

