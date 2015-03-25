<?PHP
//funciones de plantilla
function printHead($actual){
	?>
	<html lang="es">
	<head>
	    <meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="estilo.css">
		<link rel="shortcut icon" href="imagenes/favicon.ico" />
	    <title>Libros- Comparte el conocimiento</title>
	</head>
	<body>
		<header >
		<table width="100%"   >
		<tr>
		    <td width="50%"  >
			<h1>
		    	<img  src="imagenes/logo.png" width="40%">
			</h1>
		    </td>
		    <td width="50%">
		  	<form action="buscador.php">
				<input type="search" name="buscado" placeholder="Busqueda" />
				<input type="submit" name="enviar" value="Buscar"/>
			</form>	
		  </td>
		  </tr>
		  </table>
		    <nav>
		        <a href="index.php" 		
			<?PHP marcado($actual,"index.php");?>
			>Inicio</a>
		        <a href="mislibros.php" <?PHP marcado($actual,"mislibros.php");?> >Mis Libros</a>
		        <a href="compartidos.php" <?PHP marcado($actual,"compartidos.php");?>>Compartidos</a>
		        <a href="requisitos.php" <?PHP marcado($actual,"requisitos.php");?>>Requisitos</a>
		    </nav>
		</header>
		<!-- Cuerpo de la pagina -->
		<article>

	<?PHP
}
function printfoot(){
	?>
		</article>
	<footer>
		  <table width="100%">
		   <tr>
		   	<td>
		        <a href="http://facebook.com"><img title="facebook" alt="facebook" class="imgsocial" width=50px src="imagenes/facebook.png"/></a>
				<a href="http://twitter.com"><img title="twitter" alt="twitter" width=50px src="imagenes/twitter.png"/></a>
	       			<a href="http://google.com"><img title="google" alt="google" width=45px src="imagenes/google.png"/></a>
	    		</td>
		    <td align="right">
	      			<a href="requisitos.php">Terminos de uso</a> | <a href="privacidad.php">Privacidad</a> | <a href="contactanos.php">Contactenos</a>
	     		</td>
		   </tr>
		  </table>
		</footer>
	</body>
	</html>
	<?PHP
}
function marcado($actual,$comparado){
	if($actual==$comparado){
		echo "class='itemActual'";
	}else{

		echo "class='itemmenu'";
	}




}
?>
