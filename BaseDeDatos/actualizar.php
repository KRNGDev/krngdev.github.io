<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "
http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Si no se pulsa el botón de aceptar, a los diez segundos se redirige a listado.php -->
       <meta http-equiv="refresh" content="20; url=listado.php" />	 
        <title>Base de datos</title>
        <link href="prueba.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
			// si se ha recibido el código del producto por post, se asigna su valor a la variable codigo
            if (isset($_POST['id'])) $codigo = $_POST['id'];
			// Se abre la base de datos y se almacenan los posibles errores
            try {
				$dwes = new PDO("mysql:host=localhost;dbname=games", "root", "");
               // $dwes = new PDO("mysql:host=localhost;dbname=pyavgnfh_games", "pyavgnfh_games", "Karnag.86");
                $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e) {
                $error = $e->getCode();
                $mensaje = $e->getMessage();
            }
		?>
		<div id="actualizar">
            <h2>Producto:</h2>
            <?php
            if (!isset($error) && isset($codigo)) {
                // Inicialización de variables
                $ok = true;
                $nombre = $_POST['nombre'];
                $desarrollador = $_POST['desarrollador'];
                $genero = $_POST['genero'];
                $descripcion = $_POST['descripcion'];
                $pvp = $_POST['ano_lanzamiento'];
                $plataforma = $_POST['plataforma'];
                $consola = $_POST['consola'];
                $nuevaImagenData = $_FILES['nueva_imagen'];

                if ($_FILES["nueva_imagen"]["error"] === UPLOAD_ERR_OK) {
                    $nuevaImagenTmp = $_FILES["nueva_imagen"]["tmp_name"];
                    $nuevaImagenData = file_get_contents($nuevaImagenTmp);
                   

                }

                // Consulta para obtener los datos del producto
                $sql = "SELECT * FROM videojuegos WHERE id=:codigo";
                $stmt = $dwes->prepare($sql);
                $stmt->bindParam(":codigo", $codigo);
                $stmt->execute();
                $row = $stmt->fetch();
                
                // Mostrar datos en modo edición
                echo "<form id='form_actualiza' action='listado.php' method='post' enctype='multipart/form-data'>";
                echo "<p>C&Oacute;DIGO: <b>$codigo</b></p>";
                echo "<p>NOMBRE: <b><input type='text' name='nombre' value='$nombre' disabled /></b></p>";
                echo "<p>DESARROLLADOR: <b><input type='text' name='desarrollador' value='$desarrollador' disabled /></b></p>";
                echo "<p>DECRIPCI&Oacute;N: <b><input type='text' size='70' value='".substr($descripcion, 0, 60)."...' disabled /></b></p>";
                echo "<p>AÑO DE LANZAMIENTO: <b><input type='text' name='ano_lanzamiento' value='$pvp' disabled /></b></p>";
                echo "<p>PLATAFORMA: <b><input type='text' name='plataforma' value='$plataforma' disabled /></b></p>";
                
                // Mostrar imagen actual
                echo "<img src='data:image/jpeg;base64,".base64_encode($row['imagen'])."' alt='Imagen actual'>";
                
                // Comprobación del botón de actualizar
                if (isset($_POST['actualiza'])) {
                    // Comenzar transacción
                    $dwes->beginTransaction();
                    
                    // Actualización de los datos
                    $sql = "UPDATE videojuegos SET nombre=:nombre, desarrollador=:desarrollador, descripcion=:descripcion, ano_lanzamiento=:pvp ";
                    
                    if ($nuevaImagenData !== null) {
                        $sql .= ", imagen=:nueva_imagen";
                    }
                    
                    $sql .= " WHERE id=:codigo";
                    
                    $stmt = $dwes->prepare($sql);
                    $stmt->bindParam(":nombre", $nombre);
                    $stmt->bindParam(":desarrollador", $desarrollador);
                    $stmt->bindParam(":descripcion", $descripcion);
                    $stmt->bindParam(":pvp", $pvp);
                    $stmt->bindParam(":codigo", $codigo);

                    if ($nuevaImagenData !== null) {
                        $stmt->bindParam(":nueva_imagen", $nuevaImagenData, PDO::PARAM_LOB);
                    }

                    // Ejecutar la actualización
                    if ($stmt->execute()) {
                        $dwes->commit();
                        echo "<h2>Se han actualizado los datos</h2>";
                    } else {
                        $dwes->rollback();
                        echo "<h2>NO HA SIDO POSIBLE ACTUALIZAR LOS DATOS</h2>";
                    }
                    
                    // Liberar la conexión a la base de datos
                    unset($dwes);
                } else {
                    echo "<h2>Ha pulsado 'cancelar'</h2>";
                }

                // Continuar con el formulario
                echo "<input type='hidden' name='id' value='$consola' />";
                echo "<input type='submit' value='continuar' name='continua' />";
                echo "</form>";
            }
            ?>
        </div>


	</body>
</html>