<div>
    <ul><?php if ($condition) { ?> <?php foreach($myArray as $i) { ?> 
        <li>
            <span class="li">
            <?php switch($myVar) { 
case 1: ?> <?php echo $i ;?> <?php ;break;
case 2: ?> <?php echo $i*2 ;?> <?php ;break; } ?>
            
            </span>
        </li>
     <?php } ?> <?php }  ?></ul>
</div>

<div include="hello" params="['test'=>'other']">
    
</div>