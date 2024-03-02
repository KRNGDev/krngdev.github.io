<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "
http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Bases de datos</title>
        <!-- usamos la hoja de estilos que se indica en la tarea -->
        <link href="prueba.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
			// Si se recibe 'cod' se añade en la variable $codigo
            if (isset($_POST['id'])) $codigo = $_POST['id'];
			
			// Se abre la base de datos y se capturan los posibles errores
            try {
                $dwes = new PDO("mysql:host=localhost;dbname=games", "root", "");
				//$dwes = new PDO("mysql:host=localhost;dbname=pyavgnfh_games", "pyavgnfh_games", "Karnag.86");
                $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e) {
                $error = $e->getCode();
                $mensaje = $e->getMessage();
            }
		?>
		<div id="encabezado">
			<h1><u>Listado de productos de una familia</u></h1>
            <!-- Abrimos un formulario que envíe los datos via post a la propia página -->
			<form id="form_listado" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
				<span class='texto'>Consolas :  </span>
                <!-- Comenzamos a configurar el combo que contendrá los datos de las familias -->
				<select name="id" class="select">
					<?php
						// Si no han ocurrido errores en la apertura de la base de datos
						if (!isset($error)) {
							// Seleccionamos cod y nombre de la tabla familia
							$sql = "SELECT id, nombre FROM consolas";
							// Ejecutamos la consulta anterior sobre la BD abierta
							$resultado = $dwes->query($sql);
							// Si se encuentran datos
							if($resultado) {
								// Se lee el primer registro encontrado
								$row = $resultado->fetch();
								// Hacer mientras el registro leido sea distinto de null (mientras existan registros)
								while ($row != null) {
									// Se usa la orden de html 'option' con el valor del dato de familia leido
									echo "<option class='option' value='${row['id']}'";
									// Si se recibe un código de producto lo seleccionamos
									// en el desplegable usando selected='true'
									if (isset($codigo) && $codigo == $row['id'])
										echo " selected='true'";
										echo ' datos';
									// Se cierra el option poniendo el dato del nombre de la familia
									// Utilizo htmlentities para poner los datos sin caracteres 'raros'
									echo ">".htmlentities($row['nombre'])."</option>";
									// Se lee un nuevo registro (si no se encuentra ninguno más dará null)
									$row = $resultado->fetch();
								}
							}
						}
					?>
				</select>
                <!-- Mostramos el botón para autoenviarnos la selección realizada -->
				<input class="mostrar" type="submit" value="Mostrar" name="enviar"/>
			</form>
			
		</div>
		<div id="salir">
		<form id="botonSalir" action="index.html" method="post">
				<input class="BotonSalir" type="submit" value="Salir" name="Salir"/>
			</form>


		</div>
	
		
		<div id="contenido-listado">
			<h2>Productos de la familia:</h2>
			<div class="contenedor-columnas">
				
					<?php
					
						// Si se recibió un código de familia y no se produjo ningún error
						//  mostramos los productos de esa familia
						if (!isset($error) && isset($codigo)) {
							
							/* 	
								Seleccionamos todos los campos de la tabla videojuegos unida a la
								de consolas para aquellos que coincidan el campo en común del código de consolas
								De todos los registros nos quedamos únicamente con aquellos en que el código de 
								la consolas coincida con el código que nos envía el formulario anterior
							*/
							
							$sql = <<<SQL
								SELECT videojuegos.*
								FROM videojuegos INNER JOIN consolas ON videojuegos.consola_id=consolas.id
								WHERE consolas.id='$codigo'
								
		SQL;
							// ejecutamos la consulta anterior
							$resultado = $dwes->query($sql);
							// si existen datos...
							
							if($resultado) {
								
								// se lee el primer registro encontrado
								$row = $resultado->fetch();
								
								// hacer mientras existan registros encontrados
								while ($row != null) {
									
									// Creamos un formulario por cada registro encontrado
									// cargamos los valores del registro en sus correspondientes variables
									echo "<div id=listado-container>";
									$codPro=$row['id'];
									$nombre=$row['nombre'];
									$nombre_corto=$row['desarrollador'];
									$descripcion=$row['genero'];
									$pvp=$row['ano_lanzamiento'];
									$plataforma=$row['plataforma'];
									$imagen=$row['imagen'];
									// Convertir los datos binarios en una URL de imagen
									$imageBase64 = base64_encode($imagen);
									$imageSrc = "data:image/jpeg;base64," . $imageBase64;
									
									// con los valores obtenidos y los enviamos via post al fichero editar.php
									echo "<div class='container'>
										<fieldset style='width: 320px;'>
											<legend style='border: 1px solid #4b4b4b; border-radius: 10px; background-color: #4b4b4b7c;';>Id : <b style='color: #F00;'>$codPro</b></legend>

											<form class='formularioListado' id='form' action='editar.php' method='post'>
												<input type='hidden' name='id' value='$codPro'/>
												<fieldset id='nombre'>
													<legend>Nombre :</legend>
													<b style='color: antiquewhite;text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;'>$nombre</b>
												</fieldset>
												<fieldset>
													<legend>Desarrollador :</legend>
													<b style='color: antiquewhite; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;'>$nombre_corto</b>
												</fieldset>
												<fieldset>
													<legend>Año de lanzamiento :</legend> 
													<b style='color: antiquewhite; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;'>$pvp </b>
												</fieldset>
												<fieldset>
													<legend>Plataforma :</legend>
													<b style='color: antiquewhite; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;'>$plataforma</b></p>
												</fieldset>
													<input class='editar' type='submit' value='Editar' name='edit'/></p>
											</form>
										</fieldset>
										<fieldset id='imagen' >
											<legend for='imagen'>Imagen actual:</legend>
											<img  src='$imageSrc' alt='Imagen actual' />
										</fieldset>
									</div> ";   
									// se lee un nuevo registro (si no existe tendrá el valor null)
									$row = $resultado->fetch();
								} 
								
							}
						}
					?>
				
			</div>
		</div>
	</body>
</html>