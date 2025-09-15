<?php 
session_start();
include_once '../../../control/Mysql.sql';

if($_POST){
    $nombre = (isset($_POST['Nombre'])) ? $_POST['Nombre'] :'';
    $apellido = (isset($_POST['Apellido'])) ? $_POST['Apellido'] :'';
    $correo = (isset($_POST['Correo'])) ? $_POST['Correo'] :'';
    $telefono = (isset($_POST['Telefono'])) ? $_POST['Telefono'] :'';
    $imagen= (isset($_FILES['Imagen']['name'])) ? $_FILES['Imagen']['name'] :'';
    
    
    //Este codigo te enbia la imagen a una carpeta local con una fecha de subida
    $fecha_imagen=new DateTime();
    $nombre_archivo_imagen=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";
    $tmp_imagen=$_FILES['Imagen']['tmp_name'];
    if ($tmp_imagen!=""){
        move_uploaded_file($tmp_imagen, "../../../Imagenes/".$nombre_archivo_imagen);
    }
    //

    $sentencia=$conexion->prepare("INSERT INTO `tbl_admin` 
    (`ID`, `Nombre`, `Apellido`, `Correo`, `Telefono`, `Imagen`) VALUES 
    (NULL, :nombre, :apellido, :correo, :telefono, :imagen)");
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":apellido", $apellido);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":imagen", $nombre_archivo_imagen);
    


    $sentencia->execute();
    $mensaje="Registro agregado con exito.";
    header("Location:index.php?mensaje=".$mensaje);

}

include ("../../templat/header.php"); 
?>


<div class="card">
    <div class="card-header">Administradores</div>
    <div class="card-body">

        <form action="" enctype="multipart/form-data" method="post">

            <div class="mb-3">
                <label for="Nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="Nombre" id="Nombre" placeholder="Nombre" />

            </div>
            <div class="mb-3">
                <label for="Apellido" class="form-label">Apellido:</label>
                <input type="text" class="form-control" name="Apellido" id="Apellido" placeholder="Apellido" />

            </div>
            <div class="mb-3">
                <label for="Correo" class="form-label">Correo:</label>
                <input type="email" class="form-control" name="Correo" id="Correo" placeholder="Correo" />
            </div>
            <div class="mb-3">
                <label for="Telefono" class="form-label">Telefono:</label>
                <input type="text" class="form-control" name="Telefono" id="Telefono" placeholder="Telefono" />
            </div>
            <div class="mb-3">
                <label for="Imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="Imagen" id="Imagen" placeholder="Imagen" />

            </div>
                                  
            <button type="submit" class="btn btn-success">Agregar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>

        </form>
    </div>

</div>










<?php include ("../../templat/footer.php"); ?>