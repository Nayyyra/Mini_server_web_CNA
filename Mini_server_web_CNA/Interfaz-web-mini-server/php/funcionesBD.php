<?php
    /* Crea la tabla si no existe con sus campos obligatorios */
    function crearTodo($db){
        $db->exec('CREATE TABLE IF NOT EXISTS anuncios (id INTEGER PRIMARY KEY AUTOINCREMENT, titulo TEXT NOT NULL UNIQUE, descripcion TEXT NOT NULL, autor TEXT NOT NULL, contenido TEXT NOT NULL, fecha TEXT NOT NULL)');
    }
    
    /* Modifica un anuncio existente */
    function modificarAnuncio($db){
        /* Recoge los datos nuevos y la ID del anuncio enviados desde el formulario */
        $titulo = $_POST['titulo'];
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];
        $autor = $_POST['autor'];
        $contenido = $_POST['contenido'];
        $fecha = date('Y-m-d H:i:s');

        /* Sentencia preparada para editar los datos según id */
        $sentencia = $db->prepare("UPDATE anuncios SET titulo = :titulo, descripcion = :descripcion, autor = :autor, contenido = :contenido, fecha = :fecha WHERE id = :id");
        
        /* Asigna los datos actualizados a los parámetros correspondientes */
        $sentencia->bindValue(':id', $id, SQLITE3_INTEGER);
        $sentencia->bindValue(':titulo', $titulo, SQLITE3_TEXT);  
        $sentencia->bindValue(':descripcion', $descripcion, SQLITE3_TEXT);
        $sentencia->bindValue(':autor', $autor, SQLITE3_TEXT); 
        $sentencia->bindValue(':contenido', $contenido, SQLITE3_TEXT);
        $sentencia->bindValue(':fecha', $fecha, SQLITE3_TEXT); 
        $sentencia->execute();  
    }

    /* Muestra todos los anuncios aplicando el patrón de colores en zigzag */
    function mostrarAnuncios($db) {
        $colores = ['card-amarillo', 'card-naranja', 'card-rosa', 'card-morado'];
        $columnas = 4;
        $indice = 0;

        /* Consulta la bbdd para obtener los anuncios ordenados del más reciente al más antiguo */
        $resultado = $db->query("SELECT * FROM anuncios ORDER BY id DESC");

        /* Recorre toso los anuncios obtenidos y convierte cada uno en un array asociativo */
        while ($anuncio = $resultado->fetchArray(SQLITE3_ASSOC)) {
            /* Cálculo del zigzag: fila par izquierda a derecha, fila impar derecha a izquierda */
            /* Fila en la que está el anuncio */
            $fila = intdiv($indice, $columnas);
            /* Columna */
            $col = $indice % $columnas;
            /* Color e invierte dirección */
            $colorIndex = ($fila % 2 === 0) ? $col : ($columnas - 1 - $col);
            $claseColor = $colores[$colorIndex];
            ?>
            <!-- Se pinta el anuncio con su color correspondiente -->
            <article class="card <?php echo $claseColor; ?>">
                <div>
                    <!-- Muestra los datos del anuncio y usa htmlspecialchars() para prevenir ataques XSS -->
                    <h3 class="card-title"><?php echo htmlspecialchars($anuncio['titulo']); ?></h3>
                    <p class="card-body"><?php echo htmlspecialchars($anuncio['descripcion']); ?></p>
                    <p class="card-body"><?php echo htmlspecialchars($anuncio['contenido']); ?></p>
                </div>
                
                <!-- Mostramos en el footer del anuncio autor y fecha -->
                <div class="card-footer">
                    <span class="author-info">
                        <?php echo htmlspecialchars($anuncio['autor']); ?>
                        <br>
                        <small><?php echo htmlspecialchars($anuncio['fecha']); ?></small>
                    </span>

                    <!-- Metemos input type="hidden" para meter ahí el pin y el id
                     del anuncio a borrar para enviarlo a través de un POST -->
                    <div class="card-acciones">
                        <form action="index.php" class="form-eliminar" method="POST">
                            <input type="hidden" name="pin" class="input-pin">
                            <button type="submit" class="btn-card btn-eliminar" name="eliminar" value="<?php echo $anuncio['id']; ?>">Eliminar</button>
                        </form>
                        <!-- Guardamos con el botón de editar los datos del anuncio editados -->
                        <button type="button" class="btn-card btn-editar edit-button" 
                                data-id="<?php echo $anuncio['id']; ?>" 
                                data-titulo="<?php echo htmlspecialchars($anuncio['titulo']); ?>" 
                                data-autor="<?php echo htmlspecialchars($anuncio['autor']); ?>" 
                                data-descripcion="<?php echo htmlspecialchars($anuncio['descripcion']); ?>" 
                                data-contenido="<?php echo htmlspecialchars($anuncio['contenido']); ?>">Editar</button>
                    </div>
                </div>
            </article>
            <?php
            $indice++;
        }
    }

    /* Inserta un nuevo anuncio en la base de datos */
    function crearAnuncio($db){
        /* Recoge del formulario los datos enviados por el usuario */
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $autor = $_POST['autor'];
        $contenido = $_POST['contenido'];
        $fecha = date('Y-m-d H:i:s');
        /* Sentencia para insertar los datos */
        $sentencia = $db->prepare("INSERT OR IGNORE INTO anuncios (titulo, descripcion, autor, contenido, fecha) VALUES (:titulo, :descripcion, :autor, :contenido, :fecha)");
        /* Asigna los datos a los parámetros correspondientes */
        $sentencia->bindValue(':titulo', $titulo, SQLITE3_TEXT);
        $sentencia->bindValue(':descripcion', $descripcion, SQLITE3_TEXT);
        $sentencia->bindValue(':autor', $autor, SQLITE3_TEXT); 
        $sentencia->bindValue(':contenido', $contenido, SQLITE3_TEXT);
        $sentencia->bindValue(':fecha', $fecha, SQLITE3_TEXT); 
        $sentencia->execute();  
    }

    /* Valida la clave en el servidor y borra el anuncio si es correcta */
    function eliminarAnuncio($db){
        $clave = '7367';

        /* Recogemos el PIN que envió JavaScript en el formulario de manera oculta */
        /* Operador ternario, pregunta si se envió un campo llamado pin */
        /* Si se cumple se quitan los espacios y se guarda el pin, sino asigna una cadena vacía a pin */
        $pinIntroducido = isset($_POST['pin']) ? trim($_POST['pin']) : '';

        // Si el pin no es igual a la clave, frenamos y no borramos nada
        if ($pinIntroducido !== $clave) {
            return false;
        }

        /* Si la clave es correcta, recoge el id del anuncio a eliminar */
        $id = $_POST['eliminar'];
        /* Sentencia para delete */
        $sentencia = $db->prepare("DELETE FROM anuncios WHERE id = :id");
        $sentencia->bindValue(':id', $id, SQLITE3_INTEGER);
        $sentencia->execute();

        return true; // true == el borrado se ha efectuado correctamente
    }
?>