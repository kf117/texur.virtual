<!DOCTYPE html>
<?php 
      		include_once(dirname(__FILE__)."/functions/inc/mydb.inc.php");
      		$db=new mydb();
      		$categorias=$db->consulta("SELECT * FROM categoria_producto WHERE idioma_id=1 AND catp_eliminado=0 AND catp_publicado=1");
      	?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Texur</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="global/css/bootstrap.min.css" rel="stylesheet">
<!--		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="global/css/styles.css" rel="stylesheet">
	</head>
	<body>
<nav class="navbar navbar-fixed-top" style="background-color:#0A376E;color:#b2aa00;">
   <div class="container">
    <div class="navbar-header">
        <a class="navbar-brand " href="index.html" > <b>Home</b> 
      </a>
    </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">  
          <li><a href="#">Cursos/Tutoriales</a></li>
          <li><a href="#">Manuales</a></li>
          <li class=" dropdown active"><a href="productos.html" class="dropdown-toggle" data-toggle="dropdown">Productos</a>
          	<ul class="dropdown-menu" style="padding:12px;">
	                
					<?php
						foreach ($categorias as $categoria) {
							echo "<li><a href='index.php?p=".$categoria["catp_id"]."'>".$categoria["catp_nombre"]."</a></li>";
						}

					?>

	             </ul>

          </li>
  
          <li><a href="contacto.html">Contacto</a></li>
         

        </ul>
        <ul class="nav navbar-right navbar-nav">

            <li class="dropdown">
            	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span ><img src="global/img/es.jpg"> </span></a>
            	<ul class="dropdown-menu" style="padding:12px;">
	                
					<li>
					<a href="cambiar_idioma.php?id=2"><img src="global/img/en.jpg"> </a>
					</li><li>
					<a href="cambiar_idioma.php?id=3"><img src="global/img/pt.jpg"> </a>
					</li>

	             </ul>
            </li>  

         	<li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-search"></i></a>
	            <ul class="dropdown-menu" style="padding:12px;">
	                <form class="form-inline">
	     				<button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-search"></i></button><input type="text" class="form-control pull-left" placeholder="Search">
	                </form>
	             </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-chevron-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#">Login</a></li>
              <li><a href="#">Profile</a></li>
              <li class="divider"></li>
              <li><a href="#">About</a></li>
             </ul>
          </li>     
        </ul>
      </div>
    </div>
</nav><!-- /.navbar -->


<!-- Begin Body -->
<div class="container">

<div class="row">
      <div class="col-md-12">
                              <h2 class="img-responsive">
                        <img class="img-responsive img-rounded" src="global/img/barra.jpg" alt="">
                    </h2>
        <!--<h1><a href="#" title="Scroll down for your viewing pleasure">Texur</a>
          <p class="lead">SERVICE & EQUIPMENT</p></h1> -->
      </div>
    </div>
	<div class="no-gutter row">

      			

      		
      		<!-- right content column-->
      		<div class="col-md-12" id="content">
            	<div class="panel">
    			<div class="panel-heading" style="background-color:#0A376E;color:#fff;">Principal</div>   
              	<div class="panel-body">

                   
       
                  <div class=" text-left"> 
                  <?php 
                  	if(isset($_GET["p"])){
                  		$categoria=$db->consulta("SELECT * FROM categoria_producto WHERE catp_eliminado=0 AND idioma_id=1 AND catp_id=".$_GET["p"]);
                  		echo '<h1 class="text-center">'.$categoria[0]["catp_nombre"].'</h1>';
                  		$productos=$db->consulta("SELECT * FROM producto WHERE catp_id=".$_GET["p"]."  AND prod_eliminado=0 AND prod_publicado=1 ");
                  	}else{
                  	echo '<h1 class="text-center">Productos</h1>';
                  	$productos=$db->consulta("SELECT * FROM producto WHERE idioma_id=1  AND prod_eliminado=0 AND prod_publicado=1 ");
                  }
                  ?>
                    
                    
                    <!-- Separador de categorias -->
                    
                    <br>Categoria 1<br>
                    <table class="table table-hover">
                        <thead>
                            <td>#</td>
                            <td>Objeto</td>
                            <td>Disponibilidad</td>
                            <td>Info extra</td>
                        </thead> 
                        <tr>
                            <th scope="row">1</th>
                            <td>Objeto</td>
                            <td>Disponible</td>
                            <td>info extra</td>
                        </tr>                     
                        <tr>
                            <th scope="row">2</th>
                            <td>Objeto</td>
                            <td>Disponible</td>
                            <td>info extra</td>
                        </tr>                          
                    </table>
                    
                    <!-- Separador de categorias -->
                    <br>Categoria 2<br>
                    <table class="table table-hover">
                        <thead>
                            <td>#</td>
                            <td>Objeto</td>
                            <td>Disponibilidad</td>
                            <td>Info extra</td>
                        </thead> 
                        <tr>
                            <th scope="row">1</th>
                            <td>Objeto</td>
                            <td>Disponible</td>
                            <td>info extra</td>
                        </tr>                     
                        <tr>
                            <th scope="row">2</th>
                            <td>Objeto</td>
                            <td>Disponible</td>
                            <td>info extra</td>
                        </tr>                          
                    </table>
                  </div>


                 
                  </div><!--/panel-body-->
                </div><!--/panel-->
              	<!--/end right column-->
      	</div> 
  	</div>
</div>
<footer>
  <div class="container">
  	<div class="row">
      <div class="col-md-12 text-right"><h5>©Company 2015</h5></div>
    </div>
  </div>
</footer>


	<!-- script references -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="global/js/bootstrap.min.js"></script>
		<script src="global/js/scripts.js"></script>
	</body>
</html>