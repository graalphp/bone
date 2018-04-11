<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8" />
  <title>Bone</title>
  <link rel="stylesheet" href="css/styles.css?v=1.0" />
  <!--[if lt IE 9]>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
 </head>
 <body>
  <div>Hello
   <?php echo $name ; ?></div>
  <?php if($name=='John'){ ?>
  <?php } ?>
  <?php if($name == 'ohn'){ ?>
  <ul>
   <?php for($i = 0 ; $i < 10 ; $i++) { ?>
   <li>item n
    <?php echo $i ; ?></li>
   <?php } ?>
  </ul>
  <?php }elseif($name === 'John') { ?>
  <h3>
   hello john
  </h3>
  <?php } ?>  
  <div id="content"></div>
  <script src="js/script.js"></script>
 </body>
</html>