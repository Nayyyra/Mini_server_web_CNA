<?php
    function crearTodo($db){
        $db->exec('CREATE TABLE IF NOT EXISTS anuncios (id INTEGER PRIMARY KEY AUTOINCREMENT, titulo TEXT NOT NULL UNIQUE, descripcion TEXT NOT NULL, autor TEXT NOT NULL, contenido TEXT NOT NULL, fecha TEXT NOT NULL)');
    }

    function mostrarAnuncios($db){
        $result = $db->query('SELECT * FROM anuncios');
        while ($anuncio = $result->fetchArray()) {
        ?>
            <article class="card card-amarillo">

                <h3 class="card-title">
                    <?php echo $anuncio['titulo']?>
                </h3>

                <p class="card-body">
                    <?php echo $anuncio['descripcion']?>
                </p>

                <p class="card-body">
                    <?php echo $anuncio['contenido']?>
                </p>

                <div class="card-footer">
                    <span class="author-info">
                        <?php echo $anuncio['autor']?>
                        <br>
                        <small><?php echo $anuncio['fecha']?></small>
                    </span>
                <form action="index.php" class="form-group" method="POST">
                    <button type="submit" class="eliminate-button" name="id" value="<?php echo $anuncio['id']?>">Eliminar Anuncio</button>
                </form>

                </div>
            </article>
        <?php
        }
    }

    function crearAnuncio($db){
        $titulo=$_POST['titulo'];
        $descripcion=$_POST['descripcion'];
        $autor=$_POST['autor'];
        $contenido=$_POST['contenido'];
        $fecha = date('Y-m-d H:i:s');
        $sentencia= $db->prepare("INSERT OR IGNORE INTO anuncios (titulo, descripcion, autor, contenido,fecha) VALUES (:titulo,:descripcion,:autor,:contenido,:fecha)");
        $sentencia->bindValue(':titulo', $titulo, SQLITE3_TEXT);
        $sentencia->bindValue(':descripcion', $descripcion, SQLITE3_TEXT);
        $sentencia->bindValue(':autor', $autor, SQLITE3_TEXT); 
        $sentencia->bindValue(':contenido', $contenido, SQLITE3_TEXT);
        $sentencia->bindValue(':fecha', $fecha, SQLITE3_TEXT); 
        $sentencia->execute();  
    }

    function eliminarAnuncio($db){
        $id=$_POST['id'];
        $sentencia= $db->prepare("DELETE FROM anuncios WHERE id = :id");
        $sentencia->bindValue(':id', $id, SQLITE3_INTEGER);
        $sentencia->execute();
    }


?> 