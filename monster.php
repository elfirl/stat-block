<?php

// Enqueue Scripts and Styles

function enqueuing_admin_scripts(){
 
    wp_enqueue_style( 'monsters_css', get_bloginfo('stylesheet_directory') . '/monsters/monster-styles.css', array(), '1.0', 'all' );
 
}
 
add_action( 'admin_enqueue_scripts', 'enqueuing_admin_scripts' );

// Register New Post Type
function stat_block_post_type() {
    $labels = array(
        'name'                  => __( 'Stat Blocks' ),
        'singular_name'         => __( 'Stat Block' ),
        'add_new'               => __( 'New Stat Block' ),
        'add_new_item'          => __( 'Add New Stat Block' ),
        'edit_item'             => __( 'Edit Stat Block' ),
        'new_item'              => __( 'New Stat Block' ),
        'view_item'             => __( 'View Stat Blocks' ),
        'search_items'          => __( 'Search Stat Blocks' ),
        'not_found'             =>  __( 'No Stat Blocks Found' ),
        'not_found_in_trash'    => __( 'No Stat Blocks found in Trash' ),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'stat-block' ),
        'show_in_rest' => true
    );

    register_post_type( 'Stat Block', $args );
}
add_action( 'init', 'stat_block_post_type' );

// Change Add Title string

function custom_enter_title( $input ) {
    if ( 'statblock' == get_post_type() ) {
        return __( 'Creature\'s Name', 'textdomain' );
    }

    return $input;
}
add_filter( 'enter_title_here', 'custom_enter_title' );

// Custom taxonomy for stat blocks

// Commented code below was for a taxonomy, but I'm going to make it a standard field instead. Keeping this for now, remove later.

// function register_statblock_taxonomy() {
 
//     $labels = array(
//         'name'              => _x( 'Creature Type', 'taxonomy general name', 'textdomain' ),
//         'singular_name'     => _x( 'Creature Type', 'taxonomy singular name', 'textdomain' ),
//         'search_items'      => __( 'Search Creature Types', 'textdomain' ),
//         'all_items'         => __( 'All Creature Types', 'textdomain' ),
//         'view_item'         => __( 'View Creature Types', 'textdomain' ),
//         'parent_item'       => __( 'Parent Creature Type', 'textdomain' ),
//         'parent_item_colon' => __( 'Parent Creature Type:', 'textdomain' ),
//         'edit_item'         => __( 'Edit Creature Type', 'textdomain' ),
//         'update_item'       => __( 'Update Creature Type', 'textdomain' ),
//         'add_new_item'      => __( 'Add New Creature Type', 'textdomain' ),
//         'new_item_name'     => __( 'New Creature Type Name', 'textdomain' ),
//         'not_found'         => __( 'No Creature Types Found', 'textdomain' ),
//         'back_to_items'     => __( 'Back to Creature Types', 'textdomain' ),
//         'menu_name'         => __( 'Creature Type', 'textdomain' ),
//     );
 
//     $args = array(
//         'labels'            => $labels,
//         'hierarchical'      => true,
//         'public'            => true,
//         'show_ui'           => true,
//         'show_admin_column' => true,
//         'query_var'         => true,
//         'rewrite'           => array( 'slug' => 'creature-type' ),
//         'show_in_rest'      => true,
//     );
 
 
//     register_taxonomy( 'creature_type', 'statblock', $args );
 
// }
// add_action( 'init', 'register_statblock_taxonomy', 0 );

// Filter Box for Taxonomy

// function filter_post_type_by_taxonomy() {
// 	global $typenow;
// 	$post_type = 'statblock'; 
// 	$taxonomy  = 'creature_type'; 
// 	if ( $typenow == $post_type ) {
// 		$selected      = isset( $_GET[$taxonomy] ) ? $_GET[$taxonomy] : '';
// 		$info_taxonomy = get_taxonomy( $taxonomy );
// 		wp_dropdown_categories( array(
// 			'show_option_all' => sprintf( __( 'Show all %s' . 's', 'textdomain' ), $info_taxonomy->label ),
// 			'taxonomy'        => $taxonomy,
// 			'name'            => $taxonomy,
// 			'orderby'         => 'name',
// 			'selected'        => $selected,
// 			'show_count'      => true,
// 			'hide_empty'      => true,
// 		));
// 	};
// }

// add_action( 'restrict_manage_posts', 'filter_post_type_by_taxonomy' );

// // Makes the filter box work

// function convert_taxonomy_id_to_term( $query ) {
// 	global $pagenow;
// 	$post_type = 'statblock'; 
// 	$taxonomy  = 'creature_type'; 
// 	$q_vars    = &$query->query_vars;
// 	if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && isset( $q_vars[$taxonomy] ) && is_numeric( $q_vars[$taxonomy] ) && $q_vars[$taxonomy] != 0 ) {
// 		$term = get_term_by( 'id', $q_vars[$taxonomy], $taxonomy );
// 		$q_vars[$taxonomy] = $term->slug;
// 	}
// }

// add_filter( 'parse_query', 'convert_taxonomy_id_to_term' );

// Add content to Admin Columns

function statblock_table_head( $defaults ) {
    unset( $defaults['date'] );
    $defaults['stat_block_type'] = 'Creature Type';
    $defaults['stat_block_sub_type'] = 'Sub-type / Tag';
    $defaults['stat_block_cr'] = 'Challenge Rating';
    $defaults['date'] = 'Date';
    return $defaults;
}
add_filter('manage_statblock_posts_columns', 'statblock_table_head');

// Add info to Admin Columns

function statblock_table_content( $column_name, $post_id ) {
    if( $column_name == 'stat_block_type' ) {
        $stat_block_type = get_post_meta( $post_id, 'stat_block_type', true );
        echo $stat_block_type;
    }

    if( $column_name == 'stat_block_sub_type' ) {
        $stat_block_sub_type = get_post_meta( $post_id, 'stat_block_sub_type', true );
        echo $stat_block_sub_type;
    }

    if( $column_name == 'stat_block_cr' ) {
        $stat_block_cr = get_post_meta( $post_id, 'stat_block_cr', true );
        echo $stat_block_cr;
    }
}
add_action( 'manage_statblock_posts_custom_column', 'statblock_table_content', 10, 2 );

// Specify which Admin Columns are sortable

function statblock_table_sorting( $columns ) {
    $columns['stat_block_type']  = 'stat_block_type';
    $columns['stat_block_sub_type']  = 'stat_block_sub_type';
    $columns['stat_block_cr']  = 'stat_block_cr';

    return $columns;
}
add_filter( 'manage_edit-statblock_sortable_columns', 'statblock_table_sorting' );

// Modifies the sort query for Admin Columns

function statblock_type_column_sort( $vars ) {
    if( isset( $vars['orderby'] ) && 'stat_block_type' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array (
            'meta_key' => 'stat_block_type',
            'orderby' => 'meta_value'
        ) );
    }

    return $vars;
}
add_filter( 'request', 'statblock_type_column_sort' );

function statblock_sub_type_column_sort( $vars ) {
    if( isset( $vars['orderby'] ) && 'stat_block_sub_type' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array (
            'meta_key' => 'stat_block_sub_type',
            'orderby' => 'meta_value'
        ) );
    }

    return $vars;
}
add_filter( 'request', 'statblock_sub_type_column_sort' );

function statblock_cr_sort( $vars ) {
    if( isset( $vars['orderby'] ) && 'stat_block_cr' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array (
            'meta_key' => 'stat_block_cr',
            'orderby' => 'meta_value'
        ) );
    }

    return $vars;
}
add_filter( 'request', 'statblock_cr_sort' );

// Admin page table filtering
// Todo - use the commented code above to create dropdown filters for type, tag, and cr

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
        'statblock',
        'advanced'
    );

    add_meta_box(
        'creature_shortcode',
        esc_html__( 'Creature Shortcode', 'textdomain'),
        'creature_shortcode_box',
        'statblock',
        'side'
    );

}

function creature_stats_meta( $post ) {

    wp_nonce_field( basename(__FILE__), 'creature_stat_block' ); ?>

    <div class="stat-block-flex">
        <div class="stat-block-item stat-block-flex-quarter">
            <label for="stat_block_size"><?php _e( "Size", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_size" id="stat_block_size" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_size', true ) ); ?>" />
        </div>
        <div class="stat-block-item stat-block-flex-quarter">
            <label for="stat_block_type"><?php _e( "Type", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_type" id="stat_block_type" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_type', true ) ); ?>" />
        </div>
        <div class="stat-block-item stat-block-flex-quarter">
            <label for="stat_block_sub_type"><?php _e( "Sub Type / Tag", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_sub_type" id="stat_block_sub_type" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_sub_type', true ) ); ?>" />
        </div>
        <div class="stat-block-item stat-block-flex-quarter">
            <label for="stat_block_alignment"><?php _e( "Alignment", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_alignment" id="stat_block_alignment" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_alignment', true ) ); ?>" />
        </div>
    </div>
    <hr class="stat-block-hr" />
    <div class="stat-block-flex"> 
        <div class="stat-block-item">
            <label for="stat_block_ac"><?php _e( "Armor Class", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_ac" id="stat_block_ac" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_ac', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_hp"><?php _e( "Hit Points", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_hp" id="stat_block_hp" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_hp', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_speed"><?php _e( "Speed", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_speed" id="stat_block_speed" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_speed', true ) ); ?>"  />
        </div>
    </div>
    <hr class="stat-block-hr" />
    <div class="stat-block-flex">
        <div class="stat-block-item stat-block-item-attr">
            <label for="stat_block_str"><?php _e( "STR", "textdomain" ); ?></label><br />
            <input type="number" name="stat_block_str" id="stat_block_str" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_str', true ) ); ?>" />
        </div>
        <div class="stat-block-item stat-block-item-attr">
            <label for="stat_block_dex"><?php _e( "DEX", "textdomain" ); ?></label><br />
            <input type="number" name="stat_block_dex" id="stat_block_dex" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_dex', true ) ); ?>" />
        </div>
        <div class="stat-block-item stat-block-item-attr">
            <label for="stat_block_con"><?php _e( "CON", "textdomain" ); ?></label><br />
            <input type="number" name="stat_block_con" id="stat_block_con" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_con', true ) ); ?>" />
        </div>
        <div class="stat-block-item stat-block-item-attr">
            <label for="stat_block_int"><?php _e( "INT", "textdomain" ); ?></label><br />
            <input type="number" name="stat_block_int" id="stat_block_int" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_int', true ) ); ?>" />
        </div>
        <div class="stat-block-item stat-block-item-attr">
            <label for="stat_block_wis"><?php _e( "WIS", "textdomain" ); ?></label><br />
            <input type="number" name="stat_block_wis" id="stat_block_wis" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_wis', true ) ); ?>" />
        </div>
        <div class="stat-block-item stat-block-item-attr">
            <label for="stat_block_cha"><?php _e( "CHA", "textdomain" ); ?></label><br />
            <input type="number" name="stat_block_cha" id="stat_block_cha" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_cha', true ) ); ?>" />
        </div>
    </div>
    <hr class="stat-block-hr" />
    <div class="stat-block-flex">
        <div class="stat-block-item">
            <label for="stat_block_saving_throws"><?php _e( "Saving Throw Proficiencies", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_saving_throws" id="stat_block_saving_throws" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_saving_throws', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_skills"><?php _e( "Skills", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_skills" id="stat_block_skills" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_skills', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_damage_vulnerabilities"><?php _e( "Damage Vulnerabilities", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_damage_vulnerabilities" id="stat_block_damage_vulnerabilities" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_damage_vulnerabilities', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_damage_resistances"><?php _e( "Damage Resistances", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_damage_resistances" id="stat_block_damage_resistances" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_damage_resistances', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_damage_immunities"><?php _e( "Damage Immunities", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_damage_immunities" id="stat_block_damage_immunities" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_damage_immunities', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_condition_immunities"><?php _e( "Condition Immunities", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_condition_immunities" id="stat_block_condition_immunities" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_condition_immunities', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_senses"><?php _e( "Senses", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_senses" id="stat_block_senses" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_senses', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_languages"><?php _e( "Languages", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_languages" id="stat_block_languages" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_languages', true ) ); ?>" />
        </div>
        <div class="stat-block-item">
            <label for="stat_block_cr"><?php _e( "Challenge Rating", "textdomain" ); ?></label><br />
            <input type="text" name="stat_block_cr" id="stat_block_cr" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_cr', true ) ); ?>" />
        </div>
    </div>
    <hr class="stat-block-hr" />
    <div class="stat-block-flex-wysiwyg">
        <div class="stat-block-item-wysiwyg">
            <label for="stat_block_special_traits"><?php _e( "Special Traits Description", "textdomain" ); ?></label><br />
            <?php wp_editor( get_post_meta( $post->ID, 'stat_block_special_traits', true ), 'stat_block_special_traits', array( 'textarea_rows' => '10', 'media_buttons' => false, 'quicktags' => false ) ); ?>
        </div>
        <div class="stat-block-item-wysiwyg">
            <label for="stat_block_actions"><?php _e( "Actions Description", "textdomain" ); ?></label><br />
            <?php wp_editor( get_post_meta( $post->ID, 'stat_block_actions', true ), 'stat_block_actions', array( 'textarea_rows' => '10', 'media_buttons' => false, 'quicktags' => false ) ); ?>
        </div>
        <div class="stat-block-item-wysiwyg">
            <label for="stat_block_reactions"><?php _e( "Reactions Description", "textdomain" ); ?></label><br />
            <?php wp_editor( get_post_meta( $post->ID, 'stat_block_reactions', true ), 'stat_block_reactions', array( 'textarea_rows' => '10', 'media_buttons' => false, 'quicktags' => false ) ); ?>
        </div>
        <div class="stat-block-item-wysiwyg">
            <label for="stat_block_lair_actions"><?php _e( "Lair Actions Description", "textdomain" ); ?></label><br />
            <?php wp_editor( get_post_meta( $post->ID, 'stat_block_lair_actions', true ), 'stat_block_lair_actions', array( 'textarea_rows' => '10', 'media_buttons' => false, 'quicktags' => false ) ); ?>
        </div>
        <div class="stat-block-item-wysiwyg">
            <label for="stat_block_legendary_actions"><?php _e( "Legendary Actions", "textdomain" ); ?></label><br />
            <?php wp_editor( get_post_meta( $post->ID, 'stat_block_legendary_actions', true ), 'stat_block_legendary_actions', array( 'textarea_rows' => '10', 'media_buttons' => false, 'quicktags' => false ) ); ?>
        </div><div class="stat-block-item-wysiwyg">
            <label for="stat_block_mythic_actions"><?php _e( "Mythic Actions", "textdomain" ); ?></label><br />
            <?php wp_editor( get_post_meta( $post->ID, 'stat_block_mythic_actions', true ), 'stat_block_mythic_actions', array( 'textarea_rows' => '10', 'media_buttons' => false, 'quicktags' => false ) ); ?>
        </div>
    </div>
<?php }

function creature_shortcode_box() {
    // Todo - Figure out the shortcode and params
    // Todo - Dynamically get the PostID via shortcode param, using get_page_by_path
    // Todo - Store the shortcode as metadata for the post
    // Todo - Display the shortcode in the Admin Columns
    ?>
        <div>Eventual output for a creatures shortcode</div>
        <div>[statblock monster="<?php _e( basename( get_permalink() ) ) ?>"]</div>
        <div>PostID: <?php $this_post = get_page_by_path( 'zombie', '', 'statblock' ); echo $this_post->ID; ?></div>
    <?php
}

function stat_block_meta( $post_id, $post ) {

    $input_fields = array(
        'stat_block_size',
        'stat_block_type',
        'stat_block_sub_type',
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
        'stat_block_lair_actions',
        'stat_block_mythic_actions'
    );


        if ( !isset ( $_POST['creature_stat_block'] ) || !wp_verify_nonce( $_POST['creature_stat_block'], basename( __FILE__ ) ) )
        return $post_id;


    $post_type = get_post_type_object( $post->post_type );

    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    foreach ($input_fields as $field) {
        stat_block_sanitize_save_meta( $field );
    }

}

function stat_block_sanitize_save_meta( $field ) {

    global $post_id;

    if( $field == 'stat_block_special_traits' || $field == 'stat_block_actions' || $field == 'stat_block_reactions' || $field == 'stat_block_legendary_actions' || $field == 'stat_block_lair_actions' || $field == 'stat_block_mythic_actions' ) {
        $new_meta_value = ( isset( $_POST[$field] ) ? $_POST[$field] : '' );
    } else {
        $new_meta_value = ( isset( $_POST[$field] ) ? esc_attr( $_POST[$field] ) : '' );
    }
    
    $meta_key = $field;

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