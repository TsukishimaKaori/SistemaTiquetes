<html>
<head>
  <meta charset="UTF-8">      
        <?php require ("../control/ArchivosDeCabecera.php"); ?>  
 <script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);
});


$(document).ready(function() {   
    setTimeout(function() {
        $(".content2").fadeIn(1500);
    },3000);
});


 
 
 </script>

</head>
<body>
    
   <div> hola<imput type="text" placeholder ="hola"></imput></div>
	<div class="content" style = "width:800px;	margin:0 auto;	height:150px;	padding:10px;	background-color: #0099CC;">Hola, voy a desaparecer en 3 segundos!</div>
	<div class="content2" style="display:none;width:800px;	margin:0 auto;	height:350px;	padding:10px;	background-color:#CCCCCC;">Hola, soy un nuevo div!</div>

</body>
</html>
