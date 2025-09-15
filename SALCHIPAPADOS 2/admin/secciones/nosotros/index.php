<?php
session_start();
include_once '../../../control/Mysql.sql';

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID']) ? $_GET['txtID'] : '');

    $sentencia = $conexion->prepare("SELECT imagen FROM tbl_nosotros WHERE ID=:ID ");
    $sentencia->bindParam(":ID", $txtID);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registro_imagen["imagen"])) {
        if (file_exists("../../../Imagenes/" . $registro_imagen["imagen"])) {
            unlink("../../../Imagenes/" . $registro_imagen["imagen"]);
        }

    }

    $sentencia = $conexion->prepare("DELETE FROM tbl_nosotros WHERE ID=:ID ");
    $sentencia->bindParam(":ID", $txtID);
    $sentencia->execute();

}

//seleccionar registros
$sentencia = $conexion->prepare("SELECT * FROM `tbl_nosotros`");
$sentencia->execute();
$lista_nosotros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include ("../../templat/header.php");
?>


<div class="card">
    <div class="card-header">Nosotros</div>
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registro</a>

    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_nosotros as $registros) { ?>
                        <tr>
                            <td><?php echo $registros['ID']; ?></td>
                            <td><?php echo $registros['titulo']; ?></td>
                            <td><?php echo $registros['descripcion']; ?></td>

                            <td>
                                <img width="50" src="../../../Imagenes/<?php echo $registros['imagen']; ?>">
                            </td>
                            <td>
                            <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $registros['ID']; ?>"
                                role="button">Editar</a>
                            |
                            <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $registros['ID']; ?>"
                                role="button">Eliminar</a>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ("../../templat/footer.php"); ?>