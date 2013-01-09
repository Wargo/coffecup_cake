<?php
echo $this->Form->create('User', array('type' => 'file', 'controller' => 'categories', 'action' => 'edit', $id));

echo $this->Form->inputs(array(
	'fieldset' => false,
	'name' => array(
		'label' => __('Nombre y apellidos', true),
	),
	'charge' => array(
		'label' => __('Cargo en la empresa', true),
	),
	'email' => array(
		'label' => __('Email', true),
	),
	'mobile' => array(
		'label' => __('Teléfono', true),
	),
	'birthday' => array(
		'label' => __('Fecha de nacimiento', true),
		'minYear' => date('Y') - 100,
		'maxYear' => date('Y')
	),
	'icomefrom' => array(
		'label' => __('¿De dónde vienes?', true),
	),
	'talkmeabout' => array(
		'label' => __('Háblame de ti', true),
	),
	'file' => array(
		'label' => __('Foto', true),
		'type' => 'file'
	),
));

echo $this->Form->end(__('Guardar', true));
echo $this->Html->link(__('Cancelar', true), array('admin' => true, 'controller' => 'users', 'action' => 'index'));
