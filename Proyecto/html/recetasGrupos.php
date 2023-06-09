<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>C & C | Recetas del Grupo</title>

	<!-- Bootstrap -->
	<link href="../../gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="../../gentelella-master/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="../../gentelella-master/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="../../gentelella-master/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="../../gentelella-master/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>C & C</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="../../gentelella-master/production/images/img.jpg" alt="..."
								class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Bienvenido</span>
							<h2>Nombre de usuario</h2>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<ul class="nav side-menu">
                                <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
                                <li><a href="misRecetas.html"><i class="fa fa-birthday-cake"></i> Mis recetas</a></li>
                                <li><a><i class="fa fa-group"></i> Grupos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="#">Familia</a></li>
                                        <li><a href="#">Amigos</a></li>
                                    </ul>
                                </li>
                                <li><a href="planeacion.html"><i class="fa fa-list-alt"></i> Planeación de recetas</a></li>
                                <li><a href="#"><i class="fa fa-money"></i> Lista de compras</a></li>
                            </ul>
						</div>
					</div>
					<!-- /sidebar menu -->
				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>
					<nav class="nav navbar-nav">
						<ul class=" navbar-right">
							<li class="nav-item dropdown open" style="padding-left: 15px;">
								<button type="button" class="btn btn-primary btn-sm" id="logout">Log out</button>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
					</div>
					<div class="clearfix"></div>

					<div class="row">
						<!-- PARTE IZQUIERDA-->
						<div class="col-md-8 ">
							<div class="x_panel">
								<div class="x_title">
									<h3>Recetas del Grupo</h3>
									<div class="clearfix"></div>
								</div>


								<!-- AQUÍ VAN LAS RECETAS DEL USUARIO -->
								<div class="col-md-10 col-sm-10">
									<div class="form-group row">
										<div class="col-md-8 col-sm-8   form-group pull-right top_search">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Search for...">
												<span class="input-group-btn">
													<button class="btn btn-secondary" type="button">Go!</button>
												</span>
											</div>
										</div>
										<div class="col-md-2 col-sm-2" align="right">
                                            <button type="button" onclick="mostrarVentana()" class="btn btn-primary">Añadir recetas</button>
                                            
                                        </div>
                                    
                                        <script src="script.js"></script>
                                        <script>function mostrarVentana() {
                                            const ventanaEmergente = document.getElementById('miVentana');
                                            ventanaEmergente.style.display = 'block';
                                        }
                                        
                                        function cerrarVentana() {
                                            const ventanaEmergente = document.getElementById('miVentana');
                                            ventanaEmergente.style.display = 'none';
                                        }
                                        </script>
                                      
                                            <div class="col-md-2 col-sm-2 " align="right">
											<a href="eliminargrupo.php"><button type="button" class="btn btn-danger">Eliminar grupo</button></a>
										</div>
									</div>
									<!-- LÍNEA 1 DE RECETAS-->
									<div class="form-group row" id="contenedor-recetas">
                                        
										
									</div>
                                    <div id="miVentana" class="ventana">
                                        <h2>Mis recetas</h2>

                                        <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recetasDB";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$resultadorecetas = mysqli_query($conn, "SELECT nombre, idRecetas, duracion, tiempo_comida, porciones FROM recetas WHERE Usuarios_correo='a@gmail.com'");

if (mysqli_num_rows($resultadorecetas) > 0) {
    echo "<ul>";
    while ($receta = mysqli_fetch_assoc($resultadorecetas)) {
        $nombreReceta = $receta['nombre'];
        $idReceta = $receta['idRecetas'];
        $duracionReceta = $receta['duracion'];
        $tiempoComida = $receta['tiempo_comida'];
        $porciones = $receta['porciones'];

        echo "<li>";
        echo "<a href=\"#step-$idReceta\" data-step=\"$idReceta\">";
        echo "<strong>Receta: </strong>$nombreReceta<br>";
        echo "<strong>ID: </strong>$idReceta<br>";
        echo "<strong>Duración: </strong>$duracionReceta<br>";
        echo "<strong>Tiempo de comida: </strong>$tiempoComida<br>";
        echo "<strong>Porciones: </strong>$porciones<br>";
        echo "</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "No se encontraron recetas.";
}

mysqli_close($conn);
?>






                                        <button onclick="cerrarVentana()" class="btn btn-primary">Añadir</button>
                                        <button onclick="cerrarVentana()" class="btn btn-danger">Cerrar</button>
                                    </div>
								</div>
							</div>
						</div>

						<!-- PARTE DERECHA O FILTROS-->
						<!-- <div class="col-md-4 ">

                        <INGREDIENTES NECESARIOS>
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Ingredientes necesarios</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal form-label-left">
                                    <div class="control-group row">
                                        <div class="col-md-12 col-sm-12 ">
                                            <input id="tags_1" type="text" class="tags form-control" value="Tortilla, Arroz, Frijol" />
                                            <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                        </div>
                                    </div>                                  
                                </form>
                            </div>
                        </div>

                        <INGREDIENTES EXCLUIDOS>
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Ingredientes excluidos</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal form-label-left">
                                    <div class="control-group row">
                                        <div class="col-md-12 col-sm-12 ">
                                            <input id="tags_1" type="text" class="tags form-control" value="Nuez, Pescado" />
                                            <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                        </div>
                                    </div>                                  
                                </form>
                            </div>
                        </div>

                        <TIEMPO DE COMIDA>
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Tiempo de comida</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal form-label-left">                     
                                    <div class="form-group row">
                                        <div class="col-md-9 col-sm-9 ">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat" checked="checked"> Desayuno
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Almuerzo
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Comida
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Merienda
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Cena
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </form>
                            </div>
                        </div>

                        <TIPO DE COMIDA>
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Tipo de comida</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal form-label-left">                     
                                    <div class="form-group row">
                                        <div class="col-md-9 col-sm-9 ">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Entrada
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Principal
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Botanas
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat" checked="checked"> Bebidas
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Sopas y ensaladas
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Postres
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat" checked="checked"> Aperitivos
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </form>
                            </div>
                        </div>

                        <TIPO DE ALIMENTACIÓN>
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Tipo de alimentación</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal form-label-left">                     
                                    <div class="form-group row">
                                        <div class="col-md-9 col-sm-9 ">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat" checked="checked"> Vegetariana
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Vegana
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat"> Sin lácteos
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </form>
                            </div>
                        </div>
                    </div> -->
					</div>
				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					© 2023 Desarrollado por METAS
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>
	<iframe src="../php/session.php" style="display: none;"></iframe>
	<!-- jQuery -->
	<script src="../../gentelella-master/vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../../gentelella-master/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="../../gentelella-master/vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="../../gentelella-master/vendors/nprogress/nprogress.js"></script>
	<!-- jQuery Tags Input -->
	<script src="../../gentelella-master/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- iCheck -->
	<script src="../../gentelella-master/vendors/iCheck/icheck.min.js"></script>
	<!-- jQuery Smart Wizard -->
	<script src="../../gentelella-master/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="../../gentelella-master/build/js/custom.min.js"></script>
	<script type="module" src="../js/misRecetas.js"></script>
    <script type="module" src="../js/grupos.js"></script>
	<!--Para saber si existe la sesion o el correo-->
	<script>
		//Existe la session iniciada, sino redirigir a que inicie sesion
		async function session() {
			const response = await fetch("../php/session.php");
			const data = await response.json();
			const user = data.correo;
			if (user == null) {
				window.location.replace("../html/index.html");
			}

			return user;
		}
		session();
	</script>

</body>

</html>