<?php
// realizare panou admin


/**
* adding custom box to show custom fields in product create/edit page
*/
function add_custom_meta_box() {
    add_meta_box(
        '_sb_sticky_num', // $id
        'Numar de produse Sticky', // $title
        'show_custom_meta_box', // $callback
        'product', // $page  ( or content type)
        'normal', // $context
        'high');// $priority
}

/*
* call back functio to render fields in meta box
*/
function show_custom_meta_box() {
    global $post;
    $meta = get_post_meta($post->ID, $field['id'], true);
    echo '<input type="text" name="_sb_sticky_num" id="field-od" value="' . $meta[0] . '" size="30" />
                            <br /><span class="description">Numar de produse Sticky</span>';
}


add_action('add_meta_boxes',  'add_custom_meta_box' );