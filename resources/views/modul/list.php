<!-- Homepage content -->
<h2>Module</h2>

<table border="0">
	<tr>
		<th>ID</th>
		<th>Name</th>
	</tr>
	<?php foreach($module as $key => $modul): ?>
	<tr>
		<td><?=$modul['id']; ?></td>
		<td><?=$modul['name']; ?></td>
		<td><a href="modul.php?view&id=<?=$modul['id']; ?>">View</a></td>
		<td><a href="modul.php?edit&id=<?=$modul['id']; ?>">Edit</a></td>
		<td><a href="modul.php?delete&id=<?=$modul['id']; ?>">X</a></td>
	</tr>
	<?php endforeach; ?>
</table>