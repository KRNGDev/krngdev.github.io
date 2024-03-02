<?php
// Obtener los datos del archivo subido
$imagenTmp = $_FILES["nueva_imagen"]["tmp_name"];
$imagenData = file_get_contents($imagenTmp);

// Conexión a la base de datos
$dwes = new PDO("mysql:host=localhost;dbname=games", "root", "");
$dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consulta SQL para insertar la imagen en la base de datos
$sql = "INSERT INTO videojuegos (nombre, imagen) VALUES (:nombre, :imagen)";
$stmt = $dwes->prepare($sql);
$stmt->bindParam(":nombre", $nombre); // Suponiendo que tienes la variable $nombre
$stmt->bindParam(":imagen", $imagenData, PDO::PARAM_LOB);
$stmt->execute();

// Redirigir a la página de éxito o mostrar un mensaje
echo "Imagen subida exitosamente.";
header("Location: editar.php");
?>
