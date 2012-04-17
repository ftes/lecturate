<h1>
	<?=$heading ?>
</h1>
<div class="leftRight">
	<div class="left">
		<table style="vertical-align: top;">
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
	</div>


	<div class="right">
		<table style="vertical-align: top;">

			<tr>
				<th>Bemerkungen</th>
			</tr>

			<?php 
			foreach($comments as $comment){
				echo "<tr>";
				echo "<td>$comment</td>";
				echo "</tr>";
			}
			?>
		</table>
	</div>
</div>
