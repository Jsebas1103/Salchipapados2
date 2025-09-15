<?php
session_start();
include_once '../../../control/Mysql.sql';

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']) ? $_GET['txtID'] : '');
    $sentencia = $conexion->prepare("SELECT * FROM tbl_admin WHERE ID=:ID ");
    $sentencia->bindParam(":ID", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $Nombre = $registro['Nombre'];
    $Apellido = $registro['Apellido'];
    $Correo = $registro['Correo'];
    $Telefono = $registro['Telefono'];
    $imagen = $registro['Imagen'];
    
   

}

if ($_POST) {

    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : '';
    $Nombre = (isset($_POST['Nombre'])) ? $_POST['Nombre'] : '';
    $Apellido = (isset($_POST['Apellido'])) ? $_POST['Apellido'] : '';
    $Correo = (isset($_POST['Correo'])) ? $_POST['Correo'] : '';
    $Telefono = (isset($_POST['Telefono'])) ? $_POST['Telefono'] : '';
    

    $sentencia = $conexion->prepare("UPDATE tbl_admin 
    SET 
    Nombre=:nombre,
    Apellido=:apellido,
    Correo=:correo,
    Telefono=:telefono WHERE ID=:ID ");
    $sentencia->bindParam(":ID", $txtID);
    $sentencia->bindParam(":nombre", $Nombre);
    $sentencia->bindParam(":apellido", $Apellido);
    $sentencia->bindParam(":correo", $Correo);
    $sentencia->bindParam(":telefono", $Telefono);
    
    $sentencia->execute();

    if ($_FILES['Imagen']['name'] != "") {
        $imagen = (isset($_FILES['Imagen']['name'])) ? $_FILES['Imagen']['name'] : '';
        //Este codigo te enbia la imagen a una carpeta local con una fecha de subida
        $fecha_imagen = new DateTime();
        $nombre_archivo_imagen = ($imagen != "") ? $fecha_imagen->getTimestamp() . "_" . $imagen : "";
        $tmp_imagen = $_FILES['Imagen']['tmp_name'];

        if ($tmp_imagen != "") {
            move_uploaded_file($tmp_imagen, "../../../Imagenes/" . $nombre_archivo_imagen);
        }
        $txtID = (isset($_GET['txtID']) ? $_GET['txtID'] : '');
        //borrado del archibo anterior
        $sentencia = $conexion->prepare("SELECT Imagen FROM tbl_admin WHERE ID=:ID ");
        $sentencia->bindParam(":ID", $txtID);
        $sentencia->execute();
        $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_imagen["Imagen"])) {
            if (file_exists("../../../Imagenes/" . $registro_imagen["Imagen"])) {
                unlink("../../../Imagenes/" . $registro_imagen["Imagen"]);
            }

        }
        //

        $sentencia = $conexion->prepare("UPDATE tbl_admin SET Imagen=:imagen WHERE ID=:ID ");
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
    <div class="card-header">Administradores</div>
    <div class="card-body">

        <form action="" enctype="multipart/form-data" method="post">

            <div class="mb-3">
                <label for="Nombre" class="form-label">Nombre:</label>
                <input type="text" value="<?php echo $Nombre; ?>" class="form-control" name="Nombre" id="Nombre"
                    placeholder="Nombre" />

            </div>
            <div class="mb-3">
                <label for="Apellido" class="form-label">Apellido:</label>
                <input type="text" value="<?php echo $Apellido; ?>" class="form-control" name="Apellido" id="Apellido"
                    placeholder="Apellido" />

            </div>
            <div class="mb-3">
                <label for="Correo" class="form-label">Correo:</label>
                <input type="email" value="<?php echo $Correo; ?>" class="form-control" name="Correo"
                    id="Correo" placeholder="Correo" />
            </div>
            <div class="mb-3">
                <label for="Telefono" class="form-label">Telefono:</label>
                <input type="text" value="<?php echo $Telefono; ?>" class="form-control" name="Telefono"
                    id="Telefono" placeholder="Telefono" />
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>

                <img width="50" src="../../../Imagenes/<?php echo $imagen; ?>">
                <input type="file" class="form-control" name="Imagen" id="Imagen" placeholder="imagen" />

            </div>

           
            
            
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>

        </form>
    </div>

</div>

<?php include ("../../templat/footer.php"); ?>