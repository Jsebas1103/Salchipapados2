<?php 
session_start();
include_once '../../../control/Mysql.sql';

if($_POST){
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] :'';
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] :'';
    $imagen= (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] :'';
    
    
    //Este codigo te enbia la imagen a una carpeta local con una fecha de subida
    $fecha_imagen=new DateTime();
    $nombre_archivo_imagen=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";
    $tmp_imagen=$_FILES['imagen']['tmp_name'];
    if ($tmp_imagen!=""){
        move_uploaded_file($tmp_imagen, "../../../Imagenes/".$nombre_archivo_imagen);
    }
    //

    $sentencia=$conexion->prepare("INSERT INTO `tbl_nosotros` 
    (`ID`, `titulo`, `descripcion`, `imagen`) VALUES 
    (NULL, :titulo, :descripcion , :imagen)");
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":imagen", $nombre_archivo_imagen);
    $sentencia->execute();
    $mensaje="Registro agregado con exito.";
    header("Location:index.php?mensaje=".$mensaje);

}

include ("../../templat/header.php"); 
?>


<div class="card">
    <div class="card-header">Nosotros</div>
    <div class="card-body">

        <form action="" enctype="multipart/form-data" method="post">

            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="titulo" />

            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="descripcion" />

            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="imagen" />

            </div>

           
           
            <button type="submit" class="btn btn-success">Agregar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>

        </form>
    </div>

</div>










<?php include ("../../templat/footer.php"); ?>