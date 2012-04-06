<table border="0">
	<form method="POST">
		<tr>
			<th>Token</th>
			<td><?=T::input($model->getAttribute("token")); ?></td>
		</tr>
		<tr>
			<th>Int</th>
			<td><?=T::input($model->getAttribute("inti")); ?></td>
		</tr>
		<tr>
			<th></th>
			<td><?=T::button(T::CANCEL) ?><?=T::button(T::SAVE) ?></td>
		</tr>
	</form>
</table>
