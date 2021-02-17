<?php

// Register New Post Type
function stat_block_post_type() {
    $labels = array(
        'name' => __( 'Stat Blocks' ),
        'singular_name' => __( 'Stat Block' ),
        'add_new' => __( 'New Stat Block' ),
        'add_new_item' => __( 'Add New Stat Block' ),
        'edit_item' => __( 'Edit Stat Block' ),
        'new_item' => __( 'New Stat Block' ),
        'view_item' => __( 'View Stat Blocks' ),
        'search_items' => __( 'Search Stat Blocks' ),
        'not_found' =>  __( 'No Stat Blocks Found' ),
        'not_found_in_trash' => __( 'No Stat Blocks found in Trash' ),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            // 'editor',
            // 'excerpt',
            // 'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'taxonomies' => array('category'),
        'rewrite'   => array( 'slug' => 'stat-block' ),
        'show_in_rest' => true
    );

    register_post_type( 'Stat Block', $args );
}
add_action( 'init', 'stat_block_post_type' );

// Change Add Title string

function custom_enter_title( $input ) {
    if ( 'statblock' == get_post_type() ) {
        return __( 'Enter the creature\'s name here', 'textdomain' );
    }

    return $input;
}
add_filter( 'enter_title_here', 'custom_enter_title' );

// Meta Fields

function stat_block_meta_boxes_setup() {

    add_action( 'add_meta_boxes', 'stat_block_add_post_meta_boxes' );
    add_action( 'save_post', 'stat_block_meta', 10, 2 );
}

function stat_block_add_post_meta_boxes() {

    add_meta_box(
        'creature_stats',
        esc_html__( 'Creature Stats', 'textdomain'),
        'creature_stats_meta',
        'statblock'
    );

}

function creature_stats_meta( $post ) {

    wp_nonce_field( basename(__FILE__), 'creature_stat_block' );

    echo '<div class="stat-block-flex">
            <div class="stat-block-col">
                <label for="stat_block_size">' . __( "What is the creature's size?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_size" id="stat_block_size" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_size', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_type">' . __( "What is the creature's type?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_type" id="stat_block_type" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_type', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_alignment">' . __( "What is the creature's alignment?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_alignment" id="stat_block_alignment" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_alignment', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_ac">' . __( "What is the creature's armor class?", "textdomain" ) . '</label><br />
                <input type="number" name="stat_block_ac" id="stat_block_ac" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_ac', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_hp">' . __( "What is the creature's hit points?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_hp" id="stat_block_hp" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_hp', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_speed">' . __( "What is the creature's speed?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_speed" id="stat_block_speed" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_speed', true ) ) . '"  />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_str">' . __( "What is the creature's strength?", "textdomain" ) . '</label><br />
                <input type="number" name="stat_block_str" id="stat_block_str" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_str', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_dex">' . __( "What is the creature's dexterity?", "textdomain" ) . '</label><br />
                <input type="number" name="stat_block_dex" id="stat_block_dex" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_dex', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_con">' . __( "What is the creature's constitution?", "textdomain" ) . '</label><br />
                <input type="number" name="stat_block_con" id="stat_block_con" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_con', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_int">' . __( "What is the creature's intelligence?", "textdomain" ) . '</label><br />
                <input type="number" name="stat_block_int" id="stat_block_int" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_int', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_wis">' . __( "What is the creature's wisdom?", "textdomain" ) . '</label><br />
                <input type="number" name="stat_block_wis" id="stat_block_wis" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_wis', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_cha">' . __( "What is the creature's charisma?", "textdomain" ) . '</label><br />
                <input type="number" name="stat_block_cha" id="stat_block_cha" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_cha', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_saving_throws">' . __( "What are the creature's saving throws?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_saving_throws" id="stat_block_saving_throws" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_saving_throws', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_skills">' . __( "What are the creature's skills?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_skills" id="stat_block_skills" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_skills', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_damage_vulnerabilities">' . __( "What are the creature's damage vulnerabilities?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_damage_vulnerabilities" id="stat_block_damage_vulnerabilities" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_damage_vulnerabilities', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_damage_resistances">' . __( "What are the creature's damage resistances?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_damage_resistances" id="stat_block_damage_resistances" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_damage_resistances', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_damage_immunities">' . __( "What are the creature's damage immunities?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_damage_immunities" id="stat_block_damage_immunities" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_damage_immunities', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_condition_immunities">'. __( "What are the creature's condition immunities?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_condition_immunities" id="stat_block_condition_immunities" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_condition_immunities', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_senses">' . __( "What are the creature's senses?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_senses" id="stat_block_senses" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_senses', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_languages">' . __( "What are the creature's languages?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_languages" id="stat_block_languages" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_languages', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_cr">' . __( "What is the creature's challenge rating?", "textdomain" ) . '</label><br />
                <input type="text" name="stat_block_cr" id="stat_block_cr" value="' . esc_attr( get_post_meta( $post->ID, 'stat_block_cr', true ) ) . '" />
            </div>
            <div class="stat-block-col">
                <label for="stat_block_special_traits">' . __( "What are the creature's special traits?", "textdomain" ) . '</label><br />
                ' . wp_editor( get_post_meta( $post->ID, 'stat_block_special_traits', true ), 'stat_block_special_traits', array( 'textarea_rows' => '5' ) ) . '
            </div>
            <div class="stat-block-col">
                <label for="stat_block_actions">' . __( "What are the creature's actions?", "textdomain" ) . '</label><br />
                ' . wp_editor( get_post_meta( $post->ID, 'stat_block_actions', true ), 'stat_block_actions', array( 'textarea_rows' => '5' ) ) . '
            </div>
            <div class="stat-block-col">
                <label for="stat_block_reactions">' . __( "What are the creature's reactions?", "textdomain" ) . '</label><br />
                ' . wp_editor( get_post_meta( $post->ID, 'stat_block_reactions', true ), 'stat_block_reactions', array( 'textarea_rows' => '5' ) ) . '
            </div>
            <div class="stat-block-col">
                <label for="stat_block_legendary_actions">' . __( "What are the creature's legendary actions?", "textdomain" ) . '</label><br />
                ' . wp_editor( get_post_meta( $post->ID, 'stat_block_legendary_actions', true ), 'stat_block_legendary_actions', array( 'textarea_rows' => '5' ) ) . '
            </div>
            <div class="stat-block-col">
                <label for="stat_block_lair_actions">' . __( "What are the creature's lair actions?", "textdomain" ) . '</label><br />
                ' . wp_editor( get_post_meta( $post->ID, 'stat_block_lair_actions', true ), 'stat_block_lair_actions', array( 'textarea_rows' => '5' ) ) . '
            </div>
    </div>';
}

function stat_block_meta( $post_id, $post ) {

    $input_fields = array(
        'stat_block_size',
        'stat_block_type',
        'stat_block_alignment',
        'stat_block_ac',
        'stat_block_hp',
        'stat_block_speed',
        'stat_block_str',
        'stat_block_dex',
        'stat_block_con',
        'stat_block_int',
        'stat_block_wis',
        'stat_block_cha',
        'stat_block_saving_throws',
        'stat_block_skills',
        'stat_block_damage_vulnerabilities',
        'stat_block_damage_resistances',
        'stat_block_damage_immunities',
        'stat_block_condition_immunities',
        'stat_block_senses',
        'stat_block_languages',
        'stat_block_cr',
        'stat_block_special_traits',
        'stat_block_actions',
        'stat_block_reactions',
        'stat_block_legendary_actions',
        'stat_block_lair_actions'
    );

    foreach ($input_fields as $field) {
        if ( !isset ( $_POST[$field . '_nonce'] ) || !wp_verify_nonce( $_POST[$field. '_nonce'], basename( __FILE__ ) ) )
        return $post_id;
    }

    $post_type = get_post_type_object( $post->post_type );

    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    foreach ($input_fields as $field) {
        stat_block_sanitize_save_meta( $field );
    }

}

function stat_block_sanitize_save_meta( $nonce_field ) {

    global $post_id;

    if( $nonce_field == 'stat_block_special_traits' || $nonce_field == 'stat_block_actions' || $nonce_field == 'stat_block_reactions' || $nonce_field == 'stat_block_legendary_actions' || $nonce_field == 'stat_block_lair_actions' ) {
        $new_meta_value = ( isset( $_POST[$nonce_field] ) ? $_POST[$nonce_field] : '' );
    } else {
        $new_meta_value = ( isset( $_POST[$nonce_field] ) ? esc_attr( $_POST[$nonce_field] ) : '' );
    }
    
    $meta_key = $nonce_field;

    $meta_value = get_post_meta( $post_id, $meta_key, true );

    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );

    elseif ( $new_meta_value && $new_meta_value != $meta_value )
        update_post_meta( $post_id, $meta_key, $new_meta_value );

    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, $meta_key, $meta_value );

}

add_action( 'load-post.php', 'stat_block_meta_boxes_setup' );
add_action( 'load-post-new.php', 'stat_block_meta_boxes_setup' );