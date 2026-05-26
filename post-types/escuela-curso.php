<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
	register_post_type( 'nch_curso', [
		'labels' => [
			'name'               => 'Cursos',
			'singular_name'      => 'Curso',
			'add_new'            => 'Añadir Curso',
			'add_new_item'       => 'Añadir Nuevo Curso',
			'edit_item'          => 'Editar Curso',
			'view_item'          => 'Ver Curso',
			'all_items'          => 'Todos los Cursos',
			'search_items'       => 'Buscar Cursos',
			'not_found'          => 'No se encontraron cursos.',
			'not_found_in_trash' => 'No hay cursos en la papelera.',
		],
		'public'        => true,
		'has_archive'   => true,
		'show_in_rest'  => true,
		'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		'menu_icon'     => 'dashicons-welcome-learn-more',
		'rewrite'       => [ 'slug' => 'cursos' ],
	] );
} );
