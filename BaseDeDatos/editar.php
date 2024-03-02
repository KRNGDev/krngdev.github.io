<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "
http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Bases de datos</title>
        <link href="prueba.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
			
			// Si se ha recibido el código de algún producto, se almacena en la variable codigo
            if (isset($_POST['id'])) 
			{
				$codigo = $_POST['id'];
				
			}
			// se abre la base de datos como objeto PDO y se almacenan los posibles errores
            try {
				$dwes = new PDO("mysql:host=localhost;dbname=games", "root", "");
               // $dwes = new PDO("mysql:host=localhost;dbname=pyavgnfh_games", "pyavgnfh_games", "Karnag.86");
                $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e) {
                $error = $e->getCode();
                $mensaje = $e->getMessage();
            }
		?>
		<div id="encabezado-editar">
			<h1>Edici&oacute;n de un producto</h1>
		</div>
		<div id="contenido-editar">
			<h2>Producto:</h2>
			<?php
				// Si se recibio un codigo de producto y no se produjo ningun error
				//  mostramos los datos de ese producto
				
				if (!isset($error) && isset($codigo)) {
					// Necesitamos seleccionar el registro que coincide con el código recibido
					$sql = <<<SQL
						SELECT *
						FROM videojuegos
						WHERE videojuegos.id='$codigo'
					SQL;
					
					// Ejecutamos la consulta anterior
					$resultado = $dwes->query($sql);
					// si se ha encontrado el registro
					if($resultado) {
						// leemos el primer registro encontrado (y único, ya que buscamos por su campo clave)
						$row = $resultado->fetch();
						
						// metemos los datos del registro en sus correspondientes variables
						$codigo=$row['id'];
						$nombre=$row['nombre'];
						$desarrollador=$row['desarrollador'];
						$genero=$row['genero'];						
						$descripcion=$row['Descripcion'];
						$pvp=$row['ano_lanzamiento'];
						$plataforma=$row['plataforma'];	
						$consola=$row['consola_id'];
						$imagen=$row['imagen'];
						 // Convertir los datos binarios en una URL de imagen
    					$imageBase64 = base64_encode($imagen);
						$imageSrc = "data:image/jpeg;base64," . $imageBase64;

						
								echo "    
								<div id='contenedorEdicion' class='centrado'> 
									<div id='edicion'>    
										<form id='form_edit' action='actualizar.php' method='post' enctype='multipart/form-data'>
											C&oacute;digo: <input type='text' style='color: #F00;background-color: #ccc;' name='id' value='$codigo' readonly />
									
											<input type='hidden' name='consola' value='$consola' />
									
											<fieldset>
												<legend>Nombre: </legend>
												<input type='text' name='nombre' value='$nombre' size='50' />
											</fieldset>
											<fieldset>
												<legend>Desarrollador: </legend>
												<input type='text' name='desarrollador' value='$desarrollador' size='50' />
											</fieldset>
											<fieldset>
												<legend>Genero: </legend>
												<input type='text' name='genero' value='$genero' size='50' />
											</fieldset>
											<fieldset>
												<legend>Plataforma: </legend>
												<input type='text' name='plataforma' value='$plataforma'/>
											</fieldset>
											<fieldset>
												<legend>Descripcion: </legend>
												<textarea name='descripcion' rows='7' cols='50'>$descripcion</textarea>
											</fieldset>
											<fieldset>
												<legend>Año de Lanzamiento: </legend>
												<input type='text' name='ano_lanzamiento' value='$pvp'/>
											</fieldset>
											<fieldset>
												<legend for='imagen'>Imagen actual:</legend>
													<div class='imagen-container'>
														<img id='imagen' src='$imageSrc' alt='Imagen actual' />
													</div>
											</fieldset>
											<fieldset id='subirFotoBoton'>
												<legend for='imagen'>Selecciona una nueva imagen:</legend>
												<input type='file'class='nuevaImagen' name='nueva_imagen' accept='image/*' />
											</fieldset>
									
											<input type='submit' value='Actualizar' name='actualiza' />
											<input type='submit' value='Cancelar' name='cancela' />
									
										</form>
									</div>
								</div>";
						
					}
				}
			?>
		</div>
	</body>
</html>