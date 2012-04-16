<h1><?=$heading ?></h1>

<img src="<?=$evaluation ?>">

<table>
<?php 
foreach($content as $key=>$value){
	echo "<tr>";
	echo "<th>$key</th>";
	echo "<td>$value</td>";
	echo "</tr>";
}
?>
</table>