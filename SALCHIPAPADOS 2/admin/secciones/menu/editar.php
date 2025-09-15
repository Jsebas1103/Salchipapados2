<?php
session_start();
include_once '../../../control/Mysql.sql';

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']) ? $_GET['txtID'] : '');
    $sentencia = $conexion->prepare("SELECT * FROM tbl_menu WHERE ID=:ID ");
    $sentencia->bindParam(":ID", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $titulo = $registro['Titulo'];
    $precio = $registro['Precio'];
    $imagen = $registro['Imagen'];
    $tituloPre = $registro['tituloPre'];
    $descripcion = $registro['descripcion'];
    $precioPre = $registro['precioPre'];

}

if ($_POST) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '';
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '';
    $precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
    /*$imagen = (isset($_FILES['imagen']['name']))?$_FILES['imagen']['name'] :'';*/
    $tituloPre = (isset($_POST['tituloPre'])) ? $_POST['tituloPre'] : '';
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
    $precioPre = (isset($_POST['precioPre'])) ? $_POST['precioPre'] : '';

    $sentencia = $conexion->prepare("UPDATE tbl_menu 
    SET 
    Titulo=:titulo,
    Precio=:precio,
    /*Imagen=:imagen,*/
    tituloPre=:tituloPre,
    descripcion=:descripcion,
    precioPre=:precioPre
    WHERE ID=:ID ");
    $sentencia->bindParam(":ID", $txtID);
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":precio", $precio);
    /*$sentencia->bindParam(":imagen", $imagen);*/
    $sentencia->bindParam(":tituloPre", $tituloPre);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":precioPre", $precioPre);
    $sentencia->execute();

    if ($_FILES['imagen']['name'] != "") {
        $imagen = (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : '';
        //Este codigo te enbia la imagen a una carpeta local con una fecha de subida
        $fecha_imagen = new DateTime();
        $nombre_archivo_imagen = ($imagen != "") ? $fecha_imagen->getTimestamp() . "_" . $imagen : "";
        $tmp_imagen = $_FILES['imagen']['tmp_name'];

        if ($tmp_imagen != "") {
            move_uploaded_file($tmp_imagen, "../../../Imagenes/" . $nombre_archivo_imagen);
        }
        /*$txtID = (isset($_GET['txtID']) ? $_GET['txtID'] : '');*/
        //borrado del archibo anterior
        $sentencia = $conexion->prepare("SELECT Imagen FROM tbl_menu WHERE ID=:ID ");
        $sentencia->bindParam(":ID", $txtID);
        $sentencia->execute();
        $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_imagen["Imagen"])) {
            if (file_exists("../../../Imagenes/" . $registro_imagen["Imagen"])) {
                unlink("../../../Imagenes/" . $registro_imagen["Imagen"]);
            }

        }
        //

        $sentencia = $conexion->prepare("UPDATE tbl_menu SET Imagen=:imagen WHERE ID=:ID ");
        $sentencia->bindParam(":imagen", $nombre_archivo_imagen);
        $sentencia->bindParam(":ID", $txtID);
        $sentencia->execute();
        
    }

    $mensaje="Actualizacion agregada con exito.";
    header("Location:index.php?mensaje=".$mensaje);

}
include ("../../templat/header.php");
?>



<div class="card">
    <div class="card-header">Productos del menu</div>
    <div class="card-body">

        <form action="" enctype="multipart/form-data" method="post">

            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo:</label>
                <input type="text" value="<?php echo $titulo; ?>" class="form-control" name="titulo" id="titulo"
                    placeholder="titulo" />

            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" value="<?php echo $precio; ?>" class="form-control" name="precio" id="precio"
                    placeholder="precio" />

            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>

                <img width="50" src="../../../Imagenes/<?php echo $imagen; ?>">
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="imagen" />

            </div>

            <div class="mb-3">
                <label for="tituloPre" class="form-label">TituloPreview:</label>
                <input type="text" value="<?php echo $tituloPre; ?>" class="form-control" name="tituloPre"
                    id="tituloPre" placeholder="tituloPre" />
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <input type="text" value="<?php echo $descripcion; ?>" class="form-control" name="descripcion"
                    id="descripcion" placeholder="descripcion" />
            </div>
            <div class="mb-3">
                <label for="precioPre" class="form-label">PrecioPreview:</label>
                <input type="text" value="<?php echo $precioPre; ?>" class="form-control" name="precioPre"
                    id="precioPre" placeholder="precioPre" />

            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>

        </form>
    </div>

</div>

<?php include ("../../templat/footer.php"); ?>