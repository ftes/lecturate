<h1>
	<?=$heading ?>
</h1>
<table style="vertical-align: top;">
	<tr>
		<td>
			<table style="vertical-align: top;">
				<?php 
				foreach($content as $key=>$value){
					echo "<tr>";
					echo "<th>$key</th>";
					echo "<td>$value</td>";
					echo "</tr>";
				}
				?>
			</table> <img src="<?=$evaluation ?>">


		</td>

		<td valign="top" width="500">
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
		</td>
	</tr>
</table>
