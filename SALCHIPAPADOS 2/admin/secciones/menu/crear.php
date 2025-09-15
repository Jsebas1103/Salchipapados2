<?php 
session_start();
include_once '../../../control/Mysql.sql';

if($_POST){
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] :'';
    $precio = (isset($_POST['precio'])) ? $_POST['precio'] :'';
    $imagen= (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] :'';
    $tituloPre = (isset($_POST['tituloPre'])) ? $_POST['tituloPre'] :'';
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] :'';
    $precioPre = (isset($_POST['precioPre'])) ? $_POST['precioPre'] :'';
    
    //Este codigo te enbia la imagen a una carpeta local con una fecha de subida
    $fecha_imagen=new DateTime();
    $nombre_archivo_imagen=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";
    $tmp_imagen=$_FILES['imagen']['tmp_name'];
    if ($tmp_imagen!=""){
        move_uploaded_file($tmp_imagen, "../../../Imagenes/".$nombre_archivo_imagen);
    }
    //

    $sentencia=$conexion->prepare("INSERT INTO `tbl_menu` 
    (`ID`, `Titulo`, `Precio`, `Imagen`, `tituloPre`, `descripcion`, `precioPre`) VALUES 
    (NULL, :titulo, :precio, :imagen, :tituloPre, :descripcion, :precioPre)");
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":imagen", $nombre_archivo_imagen);
    $sentencia->bindParam(":tituloPre", $tituloPre);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":precioPre", $precioPre);


    $sentencia->execute();
    $mensaje="Registro agregado con exito.";
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
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="titulo" />

            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" class="form-control" name="precio" id="precio" placeholder="precio" />

            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="imagen" />

            </div>

            <div class="mb-3">
                <label for="tituloPre" class="form-label">TituloPreview:</label>
                <input type="text" class="form-control" name="tituloPre" id="tituloPre" placeholder="tituloPre" />
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="descripcion" />
            </div>
            <div class="mb-3">
                <label for="precioPre" class="form-label">PrecioPreview:</label>
                <input type="text" class="form-control" name="precioPre" id="precioPre" placeholder="precioPre" />

            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>

        </form>
    </div>

</div>










<?php include ("../../templat/footer.php"); ?>