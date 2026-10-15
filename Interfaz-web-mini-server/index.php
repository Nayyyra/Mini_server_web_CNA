<?php
require "php/conexion.php"; 
require "php/funcionesBD.php";

crearTodo($db);
    if (isset($_POST['enviar'])) {
      crearAnuncio($db);
      header("Location: index.php");
      exit();
    }
    if (isset($_POST['eliminar'])) {
      eliminarAnuncio($db);
      header("Location: index.php");
      exit();
    } 
    if (isset($_POST['actualizar'])) {
      modificarAnuncio($db);
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

      <!-- Feed anuncios -->
      <div class="cards-grid">
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
<?php $db->close(); ?>
</html>