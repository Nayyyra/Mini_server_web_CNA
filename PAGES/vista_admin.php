<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Admin</title>
  <!-- Enlazamos la hoja de estilos de tu compañera -->
  <link rel="stylesheet" href="CSS/estilos.css">
  
</head>

<body>

  <!-- Barra superior con el estilo de tu compañera -->
  <header class="navegacion">
    <h1 class="nav-title">Tablón de Anuncios Digital</h1>
    <nav class="nav-links">
      <a href="index.php">Inicio</a>
      <a href="admin.php" class="active">Administración</a>
      <?php if ($esta_autenticado): ?>
        <a href="admin.php?logout=1" class="btn-login" style="text-decoration: none;">SALIR</a>
      <?php endif; ?>
    </nav>
  </header>

  <div class="contenedor-admin">

    <!-- si el usuario NO tiene la sesión iniciada, muestra todo el HTML que viene a continuación hasta llegar al else -->
    <?php if (!$esta_autenticado): ?>
      
      <!-- Usamos la clase form-card de tu compañera para que parezca una tarjeta bonita -->
      <div class="caja-login">
        <div class="form-card">
          <h2 class="form-title">Acceso restringido</h2>

          <?php if ($mensaje_error !== ''): ?>
            <div class="alerta-error"><?php echo $mensaje_error; ?></div>
          <?php endif; ?>

          <form method="POST" action="admin.php">
            <div class="form-group">
              <label for="password">Introduce la contraseña:</label>
              <div class="input-container">
                <input type="password" id="password" name="password" placeholder="Contraseña de admin" required>
              </div>
            </div>

            <!-- Botón degradado idéntico al de publicar -->
            <button type="submit" class="btn-submit">Entrar</button>
          </form>
        </div>
      </div>

    <!-- si el usuario es admin accede a su panel -->
    <?php else: ?>

      <!-- Banner superior reutilizando la clase banner_bienvenida -->
      <div class="banner_bienvenida">
        <h2>Panel de Administración</h2>
        <p>¡Bienvenido! Aquí podrás eliminar anuncios.</p>
      </div>

      <!-- Cuadrícula con las tarjetas de anuncios -->
      <div class="cards-grid">
        
        <!-- Tarjeta de ejemplo (luego vendrá de SQLite) -->
        <article class="card card-amarillo">
          <h3 class="card-title">Reunión de Padres</h3>
          <p class="card-body">Aviso sobre la reunión informativa del curso.</p>
          <div class="card-footer">
            <span class="author-info">Carlos M.<br><small>14 de Octubre</small></span>
          </div>

          <!-- Formulario individual para borrar este anuncio -->
          <form method="POST" action="admin.php" onsubmit="return confirm('¿Seguro que deseas eliminar este anuncio?');">
            <input type="hidden" name="eliminar_id" value="1">
            <button type="submit" class="btn-eliminar">Eliminar Anuncio</button>
          </form>
        </article>

      </div>

    <?php endif; ?>

  </div>

</body>
</html>