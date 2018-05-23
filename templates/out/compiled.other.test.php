<div>
    <ul><?php if ($condition) { ?> <?php foreach($myArray as $i) { ?> 
        <li>
            <span class="li">
            <?php switch($myVar) { 
case 1: ?> g <?php ;break;
case 2: ?> <?php echo $escape($str_replace("ciao","onload=alert()",$i)) ;?> <?php ;break; } ?>
            
            </span>
        </li>
     <?php } ?> <?php }  ?></ul>
</div>

<div> hello <?php echo $name ;?></div>
<div><div>
    hello <br />
<font size="1"><table class="xdebug-error xe-notice" dir="ltr" border="1" cellspacing="0" cellpadding="1">
<tr><th align="left" bgcolor="#f57900" colspan="5"><span style="background-color: #cc0000; color: #fce94f; font-size: x-large;">( ! )</span> Notice: Undefined variable: name in C:\wamp64\www\graal\bone\templates\out\compiled.hello.test.php on line <i>2</i></th></tr>
<tr><th align="left" bgcolor="#e9b96e" colspan="5">Call Stack</th></tr>
<tr><th align="center" bgcolor="#eeeeec">#</th><th align="left" bgcolor="#eeeeec">Time</th><th align="left" bgcolor="#eeeeec">Memory</th><th align="left" bgcolor="#eeeeec">Function</th><th align="left" bgcolor="#eeeeec">Location</th></tr>
<tr><td bgcolor="#eeeeec" align="center">1</td><td bgcolor="#eeeeec" align="center">0.0003</td><td bgcolor="#eeeeec" align="right">365528</td><td bgcolor="#eeeeec">{main}(  )</td><td title="C:\wamp64\www\graal\bone\index.php" bgcolor="#eeeeec">...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor="#eeeeec" align="center">2</td><td bgcolor="#eeeeec" align="center">0.0029</td><td bgcolor="#eeeeec" align="right">534128</td><td bgcolor="#eeeeec">Graal\Bone\Engine\Skeleton->render(  )</td><td title="C:\wamp64\www\graal\bone\index.php" bgcolor="#eeeeec">...\index.php<b>:</b>14</td></tr>
<tr><td bgcolor="#eeeeec" align="center">3</td><td bgcolor="#eeeeec" align="center">0.0130</td><td bgcolor="#eeeeec" align="right">1278056</td><td bgcolor="#eeeeec">Graal\Bone\Engine\Skeleton->compile(  )</td><td title="C:\wamp64\www\graal\bone\src\Engine\Skeleton.php" bgcolor="#eeeeec">...\Skeleton.php<b>:</b>207</td></tr>
<tr><td bgcolor="#eeeeec" align="center">4</td><td bgcolor="#eeeeec" align="center">0.0389</td><td bgcolor="#eeeeec" align="right">1490608</td><td bgcolor="#eeeeec">Graal\Bone\Engine\Skeleton\Directive\IncludeDirective::transpile(  )</td><td title="C:\wamp64\www\graal\bone\src\Engine\Skeleton.php" bgcolor="#eeeeec">...\Skeleton.php<b>:</b>112</td></tr>
<tr><td bgcolor="#eeeeec" align="center">5</td><td bgcolor="#eeeeec" align="center">0.0391</td><td bgcolor="#eeeeec" align="right">1492328</td><td bgcolor="#eeeeec">Graal\Bone\Engine\Skeleton->render(  )</td><td title="C:\wamp64\www\graal\bone\src\Engine\Skeleton\Directive\IncludeDirective.php" bgcolor="#eeeeec">...\IncludeDirective.php<b>:</b>77</td></tr>
<tr><td bgcolor="#eeeeec" align="center">6</td><td bgcolor="#eeeeec" align="center">0.0444</td><td bgcolor="#eeeeec" align="right">1521216</td><td bgcolor="#eeeeec">include( <font color="#00bb00">'C:\wamp64\www\graal\bone\templates\out\compiled.hello.test.php'</font> )</td><td title="C:\wamp64\www\graal\bone\src\Engine\Skeleton.php" bgcolor="#eeeeec">...\Skeleton.php<b>:</b>225</td></tr>
</table></font>
</div>

</div>