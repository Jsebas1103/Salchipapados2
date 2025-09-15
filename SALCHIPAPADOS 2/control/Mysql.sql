<?php

       //PHP PDO data objects es un conjunto de clases que permite interactuar con diferentes bases de datos
        $servidor="127.0.0.1";
        $usuario="root";
        $clave = "";

        try
        {
            $conexion = new PDO("mysql:host=$servidor;port=3306;dbname=db_salchipapados", $usuario, $clave);   
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        catch(PDOException $msg)
        {
            echo "Conexion fallida ". $msg->getMessage();
        }
        //PDO::ATTR_ERRMODE para obtener informe de algún error al intentar conectar y
        // PDO::ERRMODE_EXCEPTION para emitir excepciones al conectar a la Base de Datos.

?>