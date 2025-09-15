<?php
session_start();
include_once '../../../control/Mysql.sql';

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']) ? $_GET['txtID'] : '');
    $sentencia = $conexion->prepare("SELECT * FROM tbl_nosotros WHERE ID=:ID ");
    $sentencia->bindParam(":ID", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $titulo = $registro['titulo'];
    $descripcion = $registro['descripcion'];
    $imagen = $registro['imagen'];
    
    
    

}

if ($_POST) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '';
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '';
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
    

    $sentencia = $conexion->prepare("UPDATE tbl_nosotros
    SET 
    titulo=:titulo,
    descripcion=:descripcion
    
    WHERE ID=:ID ");
    $sentencia->bindParam(":ID", $txtID);
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
   
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
        
        //borrado del archibo anterior
        $sentencia = $conexion->prepare("SELECT imagen FROM tbl_nosotros WHERE ID=:ID ");
        $sentencia->bindParam(":ID", $txtID);
        $sentencia->execute();
        $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_imagen["imagen"])) {
            if (file_exists("../../../Imagenes/" . $registro_imagen["imagen"])) {
                unlink("../../../Imagenes/" . $registro_imagen["imagen"]);
            }

        }
        //

        $sentencia = $conexion->prepare("UPDATE tbl_nosotros SET imagen=:imagen WHERE ID=:ID ");
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
                <label for="descripcion" class="form-label">Descripcion:</label>
                <input type="text" value="<?php echo $descripcion; ?>" class="form-control" name="descripcion"
                    id="descripcion" placeholder="descripcion" />
            </div>
            
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>

                <img width="50" src="../../../Imagenes/<?php echo $imagen; ?>">
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="imagen" />

            </div>

            
           
           
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>

        </form>
    </div>

</div>

<?php include ("../../templat/footer.php"); ?>