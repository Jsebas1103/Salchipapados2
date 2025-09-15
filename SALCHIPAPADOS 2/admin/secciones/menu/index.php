<?php
session_start();
include_once '../../../control/Mysql.sql';

if (isset($_GET['txtID'])) {
    $txtID=(isset($_GET['txtID'])?$_GET['txtID']:'');

    $sentencia=$conexion->prepare("SELECT Imagen FROM tbl_menu WHERE ID=:ID ");
    $sentencia->bindParam(":ID",$txtID);
    $sentencia->execute();
    $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);
    
    if(isset($registro_imagen["Imagen"])){
        if(file_exists("../../../Imagenes/".$registro_imagen["Imagen"])){
            unlink("../../../Imagenes/".$registro_imagen["Imagen"]);
        }

    }

    $sentencia=$conexion->prepare("DELETE FROM tbl_menu WHERE ID=:ID ");
    $sentencia->bindParam(":ID",$txtID);
    $sentencia->execute();

}

//seleccionar registros
$sentencia = $conexion->prepare("SELECT * FROM `tbl_menu`");
$sentencia->execute();
$lista_menu = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include ("../../templat/header.php");
?>


<div class="card">
    <div class="card-header">Menu</div>
    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registro</a>

    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">TituloPreview</th>
                        <th scope="col">descripcion</th>
                        <th scope="col">PrecioPreview</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_menu as $registros) { ?>
                        <tr>
                            <td><?php echo $registros['ID']; ?></td>
                            <td><?php echo $registros['Titulo']; ?></td>
                            <td><?php echo $registros['Precio']; ?></td>

                            <td>
                              <img width="50" src="../../../Imagenes/<?php echo $registros['Imagen']; ?>" >  
                            </td>

                            <td><?php echo $registros['tituloPre']; ?></td>
                            <td><?php echo $registros['descripcion']; ?></td>
                            <td><?php echo $registros['precioPre']; ?></td>
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