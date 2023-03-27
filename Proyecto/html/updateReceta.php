<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recetasDB";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Obtener los valores actuales de la base de datos
$resultadonombre = mysqli_query($conn, "SELECT nombre FROM recetas WHERE idRecetas = 1");
$resultadoduracion = mysqli_query($conn, "SELECT duracion FROM recetas WHERE idRecetas = 1");
$resultadoporcion = mysqli_query($conn, "SELECT porciones FROM recetas WHERE idRecetas = 1");
$resultadotc = mysqli_query($conn, "SELECT tiempo_comida FROM recetas WHERE idRecetas = 1");


$nombre = mysqli_fetch_assoc($resultadonombre)["nombre"];
$duracion = mysqli_fetch_assoc($resultadoduracion)["duracion"];
$porciones = mysqli_fetch_assoc($resultadoporcion)["porciones"];
$tiempoc = mysqli_fetch_assoc($resultadotc)["tiempo_comida"];


// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Comida y Compras</title>

	<!-- Bootstrap -->
	<link href="../../gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="../../gentelella-master/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="../../gentelella-master/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Dropzone.js -->
    <link href="../../gentelella-master/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="../../gentelella-master/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="../../gentelella-master/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="../../gentelella-master/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="../../gentelella-master/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="../../gentelella-master/vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
	<link href="../../gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

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
							<img src="../../gentelella-master/production/images/img.jpg" alt="..." class="img-circle profile_img">
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
                                <li><a><i class="fa fa-birthday-cake"></i> Mis recetas</a></li>
								<li><a><i class="fa fa-group"></i> Grupos <span class="fa fa-chevron-down"></span></a>
									<ul class="nav child_menu">
										<li><a href="#">Familia</a></li>
										<li><a href="#">Amigos</a></li>
									</ul>
								</li>
								<li><a><i class="fa fa-list-alt"></i> Planeación de recetas</a></li>
                                <li><a><i class="fa fa-money"></i> Lista de compras</a></li>
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
								<button type="button" class="btn btn-primary btn-sm">Log out</button>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h3>Modificar receta</h3>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<form id="demo-form" data-parsley-validate action="\\ComidayCompras/Proyecto/php/actualizar.php" method="post">                                        
                                        <div class="form-group row">
											<label class="col-form-label col-md-12 col-sm-12 "></label>
											<div class="col-md-10 col-sm-10 ">
                                                <label for="fullname">Nombre</label>
												<input type="text" name="nombre" class="form-control" placeholder="<?php echo $nombre; ?>">
                                                                                                                                             
											</div>
                                            <div class="col-md-2 col-sm-2 " align="center">
												<label for="fullname">¿Ya no te interesa?</label>
												<button type="button" class="btn btn-danger" onclick="window.location.href='\\ComidayCompras/Proyecto/php/eliminar_receta.php';">Eliminar receta</button>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label col-md-12 col-sm-12 "></label>
											<div class="col-md-6 col-sm-6 ">
                                                <label for="fullname">Ingrediente</label>
												<input type="text" class="form-control" placeholder="Levadura">
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-12 col-sm-12 "></label>
                                                    <div class="col-md-6 col-sm-6 ">
                                                        <label for="fullname">Cantidad</label>
                                                        <input type="text" class="form-control" placeholder="10">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 ">
                                                        <label for="fullname">Unidad de medida</label>
                                                        <select id="unidad_medida" class="form-control">
                                                            <option value="">Elige...</option>
                                                            <option value="" selected>Gramos (gr.)</option>
                                                            <option value="">Piezas (pzs)</option>
                                                            <option value="">Litros (l)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6 col-sm-6 ">
                                                        
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 " align="right">
                                                        <button type="button" class="btn btn-primary">Agregar</button>
                                                    </div>                                                      
                                                </div>
                                                                                             
											</div>
                                            <div class="col-md-6 col-sm-6 ">
                                                <label for="fullname">Lista de ingredientes</label>
												<table class="col-md-12 col-sm-12 " style="border: solid #84cc16; padding: 15px;">
													<tr>
														<td class="col-md-1 col-sm-1"><i type="button" class="fa fa-times-circle-o" align="right" style="color: rgb(255, 0, 89);"></i></td>
														<td class="col-md-11 col-sm-11" type="button">Huevo (3 piezas)</td>
													</tr>
													<tr>
														<td class="col-md-1 col-sm-1"><i type="button" class="fa fa-times-circle-o" align="right" style="color: rgb(255, 0, 89);"></i></td>
														<td class="col-md-11 col-sm-11" type="button">Harina (350 gr.)</td>
													</tr>
													<tr>
														<td class="col-md-1 col-sm-1"><i type="button" class="fa fa-times-circle-o" align="right" style="color: rgb(255, 0, 89);"></i></td>
														<td class="col-md-11 col-sm-11" type="button">Azúcar (250 gr.)</td>
													</tr>
													<tr>
														<td class="col-md-1 col-sm-1"><i type="button" class="fa fa-times-circle-o" align="right" style="color: rgb(255, 0, 89);"></i></td>
														<td class="col-md-11 col-sm-11" type="button">Yogur natural (125 gr.)</td>
													</tr>
												</table>
											</div>
										</div>

                                        

                                        <div class="form-group row">
											<div class="col-md-6 col-sm-6 ">
                                                <div class="form-group row">
                                                    <div class="col-md-4 col-sm-4 ">
                                                        <label for="fullname">No. de paso</label>
                                                        <input type="text" class="form-control" placeholder="3">
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 ">
                                                        <label for="fullname">Imagen de apoyo</label>
                                                        <input type="file">
                                                    </div>
                                                </div>
                                                <label for="fullname">Paso</label>
												<textarea class="form-control" rows="2" placeholder="Mezcla hasta que todos los ingredientes se integren..."></textarea>
                                                
                                                <div class="form-group row"></div>
                                                <div class="form-group row">
                                                    <div class="col-md-6 col-sm-6 ">
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 " align="right">
                                                        <button type="button" class="btn btn-primary">Agregar</button>
                                                    </div>                                                      
                                                </div>                                     
											</div>
                                            
                                            <div class="col-md-6 col-sm-6 ">
                                                <label for="fullname">Procedimiento</label>
                                                <table class="col-md-12 col-sm-12 " style="border: solid #84cc16; padding: 15px;">
													<tr>
														<td class="col-md-1 col-sm-1"><i type="button" class="fa fa-times-circle-o" align="right" style="color: rgb(255, 0, 89);"></i></td>
														<td class="col-md-11 col-sm-11" type="button" >
															1. En un recipiente de regular tamaño bate el azúcar con los huevos, puedes hacerlo a mano o utilizar una batidora eléctrica, el único requerimiento es hacerlo hasta que la mezcla crezca hasta casi el doble.
															<br>
															<img style="width: 30%; display: block;" src="../img/3.png" alt="image" />
														</td>
													</tr>
													<tr>
														<td class="col-md-1 col-sm-1"><i type="button" class="fa fa-times-circle-o" align="right" style="color: rgb(255, 0, 89);"></i></td>
														<td class="col-md-11 col-sm-11" type="button">2. Agrega el aceite y luego el yogur.
															<br>
															<img style="width: 30%; display: block;" src="../img/3.png" alt="image" />
														</td>
												</table>
											</div>
										</div>

                                        <div class="form-group row">
											<div class="col-md-6 col-sm-6 ">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Duración</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="duracion" class="form-control" placeholder="<?php echo $duracion; ?>">
                                                </div>                               
											</div>
                                            
                                            <div class="col-md-6 col-sm-6 ">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Porciones</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="text" name="porciones" class="form-control" placeholder="<?php echo $porciones; ?>">
                                                </div>                               
											</div>
										</div>

                                        <div class="form-group row">
											<div class="col-md-6 col-sm-6 ">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Tiempo de comida</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <select id="unidad_medida" name="tiempo_comida" class="form-control">
                                                        <option value="">Elige...</option>
                                                        <option value="Desayuno">Desayuno</option>
                                                        <option value="Almuerzo">Almuerzo</option>
                                                        <option value="Comida" selected>Comida</option>
                                                        <option value="Merienda">Merienda</option>
                                                        <option value="Cena">Cena</option>
                                                    </select>
                                                </div>                               
											</div>
                                            
                                            <div class="col-md-6 col-sm-6 ">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Tipo de receta</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <select id="unidad_medida" name="tipo_comida" class="form-control">
                                                        <option value="">Elige...</option>
                                                        <option value="Entrada">Entrada</option>
                                                        <option value="Principal">Principal</option>
                                                        <option value="Botanas">Botanas</option>
                                                        <option value="Bebidas">Bebidas</option>
                                                        <option value="Sopas y ensaladas">Sopas y ensaladas</option>
                                                        <option value="Postres" selected>Postres</option>
                                                        <option value="Aperitivos">Aperitivos</option>
                                                    </select>  
                                                </div>                               
											</div>
										</div>
                                        
                                        <div class="form-group row"></div>
                                        <div class="form-group row">
											<div class="col-md-6 col-sm-6 ">
                                                <label class="col-form-label col-md-3 col-sm-3 ">Producto final</label>
                                                <div class="col-md-9 col-sm-9 ">
                                                    <input type="file">
                                                </div>                               
											</div>
                                            
                                            <div class="col-md-6 col-sm-6 ">
                                                <label class="col-form-label col-md-3 col-sm-3 "></label>
                                                <div class="col-md-9 col-sm-9 "align="right">
                                                    <button type="button" class="btn btn-success" >Actualizar receta</button>                                                    
                                                </div>                               
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
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

	<!-- jQuery -->
	<script src="../../gentelella-master/vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../../gentelella-master/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="../../gentelella-master/vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="../../gentelella-master/vendors/nprogress/nprogress.js"></script>
    <!-- Dropzone.js -->
    <script src="../../gentelella-master/vendors/dropzone/dist/min/dropzone.min.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="../../gentelella-master/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="../../gentelella-master/vendors/iCheck/icheck.min.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="../../gentelella-master/vendors/moment/min/moment.min.js"></script>
	<script src="../../gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="../../gentelella-master/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	<script src="../../gentelella-master/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	<script src="../../gentelella-master/vendors/google-code-prettify/src/prettify.js"></script>
	<!-- jQuery Tags Input -->
	<script src="../../gentelella-master/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- Switchery -->
	<script src="../../gentelella-master/vendors/switchery/dist/switchery.min.js"></script>
	<!-- Select2 -->
	<script src="../../gentelella-master/vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- Parsley -->
	<script src="../../gentelella-master/vendors/parsleyjs/dist/parsley.min.js"></script>
	<!-- Autosize -->
	<script src="../../gentelella-master/vendors/autosize/dist/autosize.min.js"></script>
	<!-- jQuery autocomplete -->
	<script src="../../gentelella-master/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- starrr -->
	<script src="../../gentelella-master/vendors/starrr/dist/starrr.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="../../gentelella-master/build/js/custom.min.js"></script>

</body></html>
