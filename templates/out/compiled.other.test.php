<div>
    <ul><?php if ($condition) { ?> <?php foreach($myArray as $i) { ?> 
        <li>
            <span class="li">
            <?php switch($myVar) { 
case 1: ?> g <?php ;break;
case 2: ?> <?php echo $i ;?> <?php ;break; } ?>
            
            </span>
        </li>
     <?php } ?> <?php }  ?></ul>
</div>

<div> hello <?php echo $name ;?></div>
<div><div>
    hello yeah</div>

</div>