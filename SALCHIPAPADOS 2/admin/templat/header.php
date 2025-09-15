<?php
$url_base = "http://localhost/SALCHIPAPADOS%202/admin/";
?>
<!doctype html>
<html lang="en">
    <head>
        <title>ADMINISTRADOR</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand navbar-light bg-light">
                <div class="nav navbar-nav">
                    <a class="nav-item nav-link active" href="#" aria-current="page"
                        >Adminsitrador <span class="visually-hidden">(current)</span></a
                    >
                    <a class="nav-item nav-link" href="<?php echo $url_base;?>secciones/inicio/">Inicio</a>
                    <a class="nav-item nav-link" href= "<?php echo $url_base;?>secciones/menu/">Menu</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base;?>secciones/nosotros/">Nosotros</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base;?>secciones/configuraciones/">Configuraciones</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base;?>secciones/usuarios/">Usuarios</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base;?>secciones/administradores/">Administradores</a>
                    <a class="nav-item nav-link" href="../Login.php">Cerrar Sesion</a>
                </div>
            </nav>
            
            <!-- place navbar here -->
        </header>
    <main class="container">
        <br>