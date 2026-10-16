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
<!--metemos input type = "hidden" para meter ahí el pin y el id del anuncio a borrar para enviarlo a través de un POST-->
                <form action="index.php" class="form-group" method="POST">
                    <input type="hidden" name="pin" class="input-pin">
                    <button type="submit" class="eliminate-button" name="eliminar" value="<?php echo $anuncio['id']?>">Eliminar Anuncio</button>
                </form>
                <button class="edit-button" data-id="<?php echo $anuncio['id']?>" data-titulo="<?php echo $anuncio['titulo']?>" data-autor="<?php echo $anuncio['autor']?>" data-descripcion="<?php echo $anuncio['descripcion']?>" data-contenido="<?php echo $anuncio['contenido']?>">Editar Anuncio</button>
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
    $clave = '7367';

    // Recogemos el PIN que envió JavaScript en el formulario oculto
    $pinIntroducido = isset($_POST['pin']) ? trim($_POST['pin']) : '';

    // Si el pin no es igual a la clave, frenamos y no borramos nada
    if ($pinIntroducido !== $clave) {
        return;
    }

    $id = $_POST['eliminar'];
    $sentencia = $db->prepare("DELETE FROM anuncios WHERE id = :id");
    $sentencia->bindValue(':id', $id, SQLITE3_INTEGER);
    $sentencia->execute();

    return true; //true == el borrado se ha efectuado
}

    function modificarAnuncio($db){
        $titulo=$_POST['titulo'];
        $id=$_POST['id'];
        $descripcion=$_POST['descripcion'];
        $autor=$_POST['autor'];
        $contenido=$_POST['contenido'];
        $fecha = date('Y-m-d H:i:s');
        $sentencia= $db->prepare("UPDATE anuncios SET titulo= :titulo, descripcion= :descripcion, autor=:autor, contenido=:contenido, fecha=:fecha WHERE id= :id");
        $sentencia->bindValue(':id', $id, SQLITE3_INTEGER);
        $sentencia->bindValue(':titulo', $titulo, SQLITE3_TEXT);  
        $sentencia->bindValue(':descripcion', $descripcion, SQLITE3_TEXT);
        $sentencia->bindValue(':autor', $autor, SQLITE3_TEXT); 
        $sentencia->bindValue(':contenido', $contenido, SQLITE3_TEXT);
        $sentencia->bindValue(':fecha', $fecha, SQLITE3_TEXT); 
        $sentencia->execute();  
    }
?> 