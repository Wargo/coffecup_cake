<?php
if (!count($users)) {
	echo json_encode(array('status' => 'ko', 'message' => __('Error')));
} else {

	$return = array();

	foreach ($users as $user) {

		extract($user);

		$return[] = array(
			'id' => $User['id'],
			'name' => $User['name'],
			'charge' => $User['charge'],
			'email' => $User['email'],
			'mobile' => $User['mobile'],
			'birthday' => $User['birthday'],
			'talkmeabout' => $User['talkmeabout'],
			'icomefrom' => $User['icomefrom'],
			'img_p' => $this->Html->url(array('full_base' => true, 'controller' => false, 'action' => 'img')) .  '/users/' . $User['id'] . ',fitCrop,200,320.jpg',
			'img_b' => $this->Html->url(array('full_base' => true, 'controller' => false, 'action' => 'img')) .  '/users/' . $User['id'] . ',fitCrop,' . ($w * 2) . ',' . ($h * 2) . '.jpg',
		);

	}

	echo json_encode(array('status' => 'ok', 'data' => $return));

}
