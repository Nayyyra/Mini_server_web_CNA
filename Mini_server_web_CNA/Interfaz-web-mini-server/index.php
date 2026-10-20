<?php
/* Incluimos los archivos de conexión y funciones */
require "php/conexion.php"; 
require "php/funcionesBD.php";

// Evitar que el navegador guarde la página en caché
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0");

crearTodo($db);
  // Crea anuncio si el usuario pulsa enviar
    if (isset($_POST['enviar'])) {
      crearAnuncio($db);
      /* Recarga la página para limpiar los datos del form */
      header("Location: index.php");
      exit();
    }

  // Borra si el usuario pulsó eliminar
    if (isset($_POST['eliminar'])) {
      $borradoCorrecto = eliminarAnuncio($db);
      if ($borradoCorrecto) {
        /* Si el borrado es ok pone en la url status=borrado_ok */
        header("Location: index.php?status=borrado_ok");
      } else {
        /* Sino pone en la url status=pin_incorrecto */
        header("Location: index.php?status=pin_incorrecto");
      }
      exit();
    }

    /* Edita anuncio si el usuario guarda cambios en un anuncio editado */
    if (isset($_POST['actualizar'])) {
      modificarAnuncio($db);
      /* Recarga la página con los datos del anuncio actualizados */
      header("Location: index.php");
      exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tablón de Anuncios Digital - DAW</title>
  <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>

  <!-- Encabezado superior -->
  <header class="navegacion">
    <h1 class="nav-title">Tablón de Anuncios Digital</h1>
  </header>

  <!-- Contenedor principal -->
  <div class="main-container">
    <!-- Banner y grid de anuncios -->
    <main class="feed-section">
      
      <!-- Banner bienvenida -->
      <div class="banner_bienvenida">
        <h2>¡Bienvenido al Tablón Digital!</h2>
        <p>Comparte y descubre novedades del centro</p>
      </div>

      
  <!--Anuncio borrado / error-->
  <!-- Comprobamos que que la url tiene un parámetro (tras intentar borrado) -->
  <?php if (isset($_GET['status'])): ?>
    <div id="caja-aviso" class="caja-aviso">
      <div class="cuerpo-aviso">
        <span class="icono-aviso">
          <!-- Si el status es ok no muestra nada, sino un emoji de advertencia -->
          <?php echo $_GET['status'] === 'borrado_ok' ? '' : '⚠️'; ?>
        </span>
        <p class="texto-aviso">
          <?php
            /* Si el borrado fue correcto muestra "Anuncio eliminado correctamente", sino "Pin incorrecto" */ 
            echo $_GET['status'] === 'borrado_ok' 
              ? 'Anuncio eliminado correctamente.' 
              : 'Pin incorrecto. No se pudo eliminar el anuncio.'; 
          ?>
        </p>
      </div>

      <div class="pie-aviso">
        <button id="btn-cerrar-aviso" class="btn-cerrar-aviso" type="button">Aceptar</button>
      </div>
      </div>
  <?php endif; ?>

      <!-- Feed anuncios -->
      <div class="cards-grid">
        <!-- Función para mostrar los anuncios -->
        <?php mostrarAnuncios($db); ?>
      </div>
    </main>

    <!-- Formulario para publicar anuncios -->
    <aside class="form-section">
      <div class="form-card">
        <h2 class="form-title" id="tituloFormulario">Publicar nuevo anuncio</h2>
        
        <form action="index.php" method="POST">
          <input type="hidden" name="id" value="id" id="idAnuncio">

          <div class="form-group">
            <label for="titulo">Título</label>
            <div class="input-container">
              <input type="text" id="titulo" name="titulo" placeholder="Introduce el título" required>
            </div>
          </div>

          <div class="form-group">
            <label for="autor">Autor</label>
            <div class="input-container">
              <input type="text" id="autor" name="autor" placeholder="Introduce tu nombre" required>
            </div>
          </div>

          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <div class="input-container">
              <textarea id="descripcion" name="descripcion" rows="5" placeholder="Introduce descripción" required></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="contenido">Contenido</label>
            <div class="input-container">
              <textarea id="contenido" name="contenido" rows="5" placeholder="Introduce contenido" required></textarea>
            </div>
          </div>

          <button type="submit" class="btn-submit" name="enviar" id="enviar">Publicar</button>
        </form>
      </div>
    </aside>

  </div>
  <!-- Conexión con JS -->
  <script src="JS/app.js"></script>
</body>
<!-- Cierra la conexión con la bbdd -->
<?php $db->close(); ?>
</html>