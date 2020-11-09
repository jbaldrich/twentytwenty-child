<?php

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles()
{

    $parent_style = 'twentytwenty-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [$parent_style],
        wp_get_theme()->get('Version')
    );
}

/**
 * Register Tutorial Custom Post Type.
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
function cpt_tutorials_register_cpt()
{
    $labels = [
        'name'                  => 'Tutoriales',
        'singular_name'         => 'Tutorial',
        'add_new'               => 'Añadir nuevo',
        'add_new_item'          => 'Añadir nuevo Tutorial',
        'edit_item'             => 'Editar Tutorial',
        'view_item'             => 'Ver Tutoriales',
        'all_items'             => 'Todos los Tutoriales',
        'search_items'          => 'Buscar Tutoriales',
        'not_found'             => 'No se han encontrado tutoriales.',
        'not_found_in_trash'    => 'No hay tutoriales en la papelera.',
        'attributes'            => 'Atributos de tutorial',
        'insert_into_item'      => 'Insertar en el tutorial',
        'uploaded_to_this_item' => 'Subido a este tutorial',
        'featured_image'        => 'Imagen destacada',
        'set_featured_image'    => 'Establecer imagen destacada',
        'remove_featured_image' => 'Borrar imagen destacada',
        'use_featured_image'    => 'Usar como imagen destacada',
        'filter_items_list'     => 'Lista de tutoriales filtrados',
        'items_list_navigation' => 'Navegación por el listado de tutoriales',
        'items_list'            => 'Lista de tutoriales',
    ];

    $args = [
        'labels'            => $labels,
        'description'       => 'Módulo de tutoriales',
        'public'            => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'menu_position'     => 2,
        'menu_icon'         => 'dashicons-video-alt',
        'query_var'         => true,
        'has_archive'       => true,
        'hierarchical'      => true,
        'taxonomies'        => ['category'],
        'show_admin_column' => true,
        'supports'          => [
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'custom-fields',
            'revisions',
            'page-attributes',
        ],
    ];

    register_post_type('tutorials', $args);
}

add_action('init', 'cpt_tutorials_register_cpt');

function jbr_add_custom_types(WP_Query $query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (empty($query->query_vars['suppress_filters']) && is_category()) {
        $query->set('post_type', ['post', 'tutorials']);
    }
}

add_filter('pre_get_posts', 'jbr_add_custom_types');
