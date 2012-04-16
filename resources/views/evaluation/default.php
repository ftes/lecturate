<h1><?=$heading ?></h1>
<table valign="top">
<tr><td>
<table valign="top">
<?php 
foreach($content as $key=>$value){
	echo "<tr>";
	echo "<th>$key</th>";
	echo "<td>$value</td>";
	echo "</tr>";
}
?>
</table>
<img src="<?=$evaluation ?>">


</td>
<td valign="top" width="500">
<table valign="top" >

<th>Bemerkungen</th>
<?php 
foreach($comments as $comment){
	echo "<tr>";
	echo "<td>$comment</td>";
	echo "</tr>";
}
?>

</table>
</td>
</tr>
</table>