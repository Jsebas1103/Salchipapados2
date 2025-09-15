<?php
session_start();
include_once '../../../control/Mysql.sql';

if (isset($_GET['txtID'])) {
    $txtID=(isset($_GET['txtID'])?$_GET['txtID']:'');

    $sentencia=$conexion->prepare("SELECT Imagen FROM tbl_admin WHERE ID=:ID ");
    $sentencia->bindParam(":ID",$txtID);
    $sentencia->execute();
    $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);
    
    if(isset($registro_imagen["Imagen"])){
        if(file_exists("../../../Imagenes/".$registro_imagen["Imagen"])){
            unlink("../../../Imagenes/".$registro_imagen["Imagen"]);
        }

    }

    $sentencia=$conexion->prepare("DELETE FROM tbl_admin WHERE ID=:ID ");
    $sentencia->bindParam(":ID",$txtID);
    $sentencia->execute();

}

//seleccionar registros
$sentencia = $conexion->prepare("SELECT * FROM `tbl_admin`");
$sentencia->execute();
$lista_admin = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include ("../../templat/header.php");
?>


<div class="card">
    <div class="card-header">Admin</div>
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registro</a>

    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_admin as $registros) { ?>
                        <tr>
                            <td><?php echo $registros['ID']; ?></td>
                            <td><?php echo $registros['Nombre']; ?></td>
                            <td><?php echo $registros['Apellido']; ?></td>
                            <td><?php echo $registros['Correo']; ?></td>
                            <td><?php echo $registros['Telefono']; ?></td>  
                            <td>
                              <img width="50" src="../../../Imagenes/<?php echo $registros['Imagen']; ?>" >  
                            </td>
                           
                            <td>
                            <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo$registros['ID'];?>"role="button">Editar</a>
                            |
                            <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo$registros['ID'];?>"role="button">Eliminar</a>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ("../../templat/footer.php"); ?>