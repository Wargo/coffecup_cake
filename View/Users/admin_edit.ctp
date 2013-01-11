<?php

echo $this->Html->link(__('Volver', true), array('controller' => 'users', 'action' => 'index'));

echo $this->Form->create('User', array('type' => 'file'));

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
		'after' => __('Sólo si quieres darlo', true)
	),
	'birthday' => array(
		'label' => __('Fecha de nacimiento', true),
		'minYear' => date('Y') - 100,
		'maxYear' => date('Y')
	),
	'icomefrom' => array(
		'label' => __('¿De dónde vienes?', true),
		'after' => __('Ej: Valencia (España)', true)
	),
	'talkmeabout' => array(
		'label' => __('Háblame de ti', true),
		'after' => __('Brevemente qué cosas te gustan (profesional y personalmente). Ej: investigar, tecnología, móviles, los deportes, el porno, bailar, comer, dormir, etc...', true)
	),
	'file' => array(
		'label' => __('Foto', true),
		'type' => 'file'
	),
));

if ($id) {
	echo $this->Html->image('users/' . $id . '.jpg');
}

echo $this->Form->end(__('Guardar', true));

echo $this->Html->link(__('Cancelar', true), array('admin' => true, 'controller' => 'users', 'action' => 'index'));
