<?php

echo $this->Html->link(__('Crear nuevo usuario', true), array('controller' => 'users', 'action' => 'edit'));

echo '<table cellspacing="0" cellpadding="0">';

foreach ($users as $user) {

	extract($user);

	echo '<tr>';
		echo '<td>' . $this->Html->image('users/' . $User['id'] . ',fitCrop,60,60.jpg', array('width' => 60, 'height' => 60)) . '</td>';
		echo '<td>' . $User['name'] . '</td>';
		echo '<td>' . $this->Html->link(__('Editar', true), array('controller' => 'users', 'action' => 'edit', $User['id'])) . '</td>';
		echo '<td>' . $this->Html->link(__('Borrar', true), array('controller' => 'users', 'action' => 'delete', $User['id']), array(), __('¿Seguro?', true)) . '</td>';
	echo '</tr>';

}

echo '</table>';
