<nav class="nav-header"> 
<ul> 
<?php 
foreach(Model_Menu::go() as $bah => $curr) 
{ 
echo("<li><a href=\"$curr[link]\">$curr[title]</a></li>"); 
} 
?> 
</ul> 
</nav>