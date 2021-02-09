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

// Meta Fields

function stat_block_meta_boxes_setup() {

    add_action( 'add_meta_boxes', 'stat_block_add_post_meta_boxes' );
    add_action( 'save_post', 'stat_block_meta', 10, 2 );
}

function stat_block_add_post_meta_boxes() {

    add_meta_box(
        'stat-block-creature-name',
        esc_html__( 'Creature Name', 'textdomain'),
        'stat_block_meta_name',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-size',
        esc_html__( 'Creature Size', 'textdomain'),
        'stat_block_meta_size',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-type',
        esc_html__( 'Creature Type', 'textdomain'),
        'stat_block_meta_type',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-alignment',
        esc_html__( 'Creature Alignment', 'textdomain'),
        'stat_block_meta_alignment',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-ac',
        esc_html__( 'Creature Armor Class', 'textdomain'),
        'stat_block_meta_ac',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-hp',
        esc_html__( 'Creature Hit Points', 'textdomain'),
        'stat_block_meta_hp',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-speed',
        esc_html__( 'Creature Speed', 'textdomain'),
        'stat_block_meta_speed',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-str',
        esc_html__( 'Creature Strength', 'textdomain'),
        'stat_block_meta_str',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-dex',
        esc_html__( 'Creature Dexterity', 'textdomain'),
        'stat_block_meta_dex',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-con',
        esc_html__( 'Creature Constitution', 'textdomain'),
        'stat_block_meta_con',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-int',
        esc_html__( 'Creature Intelligence', 'textdomain'),
        'stat_block_meta_int',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-wis',
        esc_html__( 'Creature Wisdom', 'textdomain'),
        'stat_block_meta_wis',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-cha',
        esc_html__( 'Creature Charisma', 'textdomain'),
        'stat_block_meta_cha',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-saving-throws',
        esc_html__( 'Saving Throws', 'textdomain'),
        'stat_block_meta_saving_throws',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-skills',
        esc_html__( 'Creature Skills', 'textdomain'),
        'stat_block_meta_skills',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-damage-vulnerabilities',
        esc_html__( 'Creature Damage Vulnerabilities', 'textdomain'),
        'stat_block_meta_damage_vulnerabilities',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-damage-resistances',
        esc_html__( 'Damage Resistances', 'textdomain'),
        'stat_block_meta_damage_resistances',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-damage-immunities',
        esc_html__( 'Damage Immunities', 'textdomain'),
        'stat_block_meta_damage_immunities',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-condition-immunities',
        esc_html__( 'Condition Immunities', 'textdomain'),
        'stat_block_meta_condition_immunities',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-senses',
        esc_html__( 'Creature Senses', 'textdomain'),
        'stat_block_meta_senses',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-languages',
        esc_html__( 'Creature Languages', 'textdomain'),
        'stat_block_meta_languages',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-cr',
        esc_html__( 'Challenge Rating', 'textdomain'),
        'stat_block_meta_cr',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-special-traits',
        esc_html__( 'Special Traits', 'textdomain'),
        'stat_block_meta_special_traits',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-actions',
        esc_html__( 'Creature Actions', 'textdomain'),
        'stat_block_meta_actions',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-reactions',
        esc_html__( 'Creature Reactions', 'textdomain'),
        'stat_block_meta_reactions',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-legendary-actions',
        esc_html__( 'Creature Legendary Actions', 'textdomain'),
        'stat_block_meta_legendary_actions',
        'statblock',
        'advanced',
        'default'
    );

    add_meta_box(
        'stat-block-creature-lair-actions',
        esc_html__( 'Creature Lair Actions', 'textdomain'),
        'stat_block_meta_lair_actions',
        'statblock',
        'advanced',
        'default'
    );

}

function stat_block_meta_name( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_name_nonce' ); ?>

    <p>
        <label for="stat_block_name"><?php _e( "What is the creature's name?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_name" id="stat_block_name" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_name', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_size( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_size_nonce' ); ?>

    <p>
        <label for="stat_block_size"><?php _e( "What is the creature's size?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_size" id="stat_block_size" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_size', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_type( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_type_nonce' ); ?>

    <p>
        <label for="stat_block_type"><?php _e( "What is the creature's type?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_type" id="stat_block_type" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_type', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_alignment( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_alignment_nonce' ); ?>

    <p>
        <label for="stat_block_alignment"><?php _e( "What is the creature's alignment?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_alignment" id="stat_block_alignment" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_alignment', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_ac( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_ac_nonce' ); ?>

    <p>
        <label for="stat_block_ac"><?php _e( "What is the creature's armor class?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_ac" id="stat_block_ac" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_ac', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_hp( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_hp_nonce' ); ?>

    <p>
        <label for="stat_block_hp"><?php _e( "What is the creature's hit points?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_hp" id="stat_block_hp" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_hp', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_speed( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_speed_nonce' ); ?>

    <p>
        <label for="stat_block_speed"><?php _e( "What is the creature's speed?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_speed" id="stat_block_speed" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_speed', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_str( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_str_nonce' ); ?>

    <p>
        <label for="stat_block_str"><?php _e( "What is the creature's strength?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_str" id="stat_block_str" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_str', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_dex( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_dex_nonce' ); ?>

    <p>
        <label for="stat_block_dex"><?php _e( "What is the creature's dexterity?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_dex" id="stat_block_dex" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_dex', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_con( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_con_nonce' ); ?>

    <p>
        <label for="stat_block_con"><?php _e( "What is the creature's constitution?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_con" id="stat_block_con" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_con', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_int( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_int_nonce' ); ?>

    <p>
        <label for="stat_block_int"><?php _e( "What is the creature's intelligence?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_int" id="stat_block_int" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_int', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_wis( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_wis_nonce' ); ?>

    <p>
        <label for="stat_block_wis"><?php _e( "What is the creature's wisdom?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_wis" id="stat_block_wis" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_wis', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_cha( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_cha_nonce' ); ?>

    <p>
        <label for="stat_block_cha"><?php _e( "What is the creature's charisma?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_cha" id="stat_block_cha" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_cha', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_saving_throws( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_saving_throws_nonce' ); ?>

    <p>
        <label for="stat_block_saving_throws"><?php _e( "What are the creature's saving throws?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_saving_throws" id="stat_block_saving_throws" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_saving_throws', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_skills( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_skills_nonce' ); ?>

    <p>
        <label for="stat_block_skills"><?php _e( "What are the creature's skills?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_skills" id="stat_block_skills" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_skills', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_damage_vulnerabilities( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_damage_vulnerabilities_nonce' ); ?>

    <p>
        <label for="stat_block_damage_vulnerabilities"><?php _e( "What are the creature's damage vulnerabilities?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_damage_vulnerabilities" id="stat_block_damage_vulnerabilities" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_damage_vulnerabilities', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_damage_resistances( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_damage_resistances_nonce' ); ?>

    <p>
        <label for="stat_block_damage_resistances"><?php _e( "What are the creature's damage resistances?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_damage_resistances" id="stat_block_damage_resistances" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_damage_resistances', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_damage_immunities( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_damage_immunities_nonce' ); ?>

    <p>
        <label for="stat_block_damage_immunities"><?php _e( "What are the creature's damage immunities?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_damage_immunities" id="stat_block_damage_immunities" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_damage_immunities', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_condition_immunities( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_condition_immunities_nonce' ); ?>

    <p>
        <label for="stat_block_condition_immunities"><?php _e( "What are the creature's condition immunities?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_condition_immunities" id="stat_block_condition_immunities" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_condition_immunities', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_senses( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_senses_nonce' ); ?>

    <p>
        <label for="stat_block_senses"><?php _e( "What are the creature's senses?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_senses" id="stat_block_senses" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_senses', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_languages( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_languages_nonce' ); ?>

    <p>
        <label for="stat_block_languages"><?php _e( "What are the creature's languages?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_languages" id="stat_block_languages" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_languages', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_cr( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_cr_nonce' ); ?>

    <p>
        <label for="stat_block_cr"><?php _e( "What is the creature's challenge rating?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_cr" id="stat_block_cr" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_cr', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_special_traits( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_special_traits_nonce' ); ?>

    <p>
        <label for="stat_block_special_traits"><?php _e( "What are the creature's special traits?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_special_traits" id="stat_block_special_traits" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_special_traits', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_actions( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_actions_nonce' ); ?>

    <p>
        <label for="stat_block_actions"><?php _e( "What are the creature's actions?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_actions" id="stat_block_actions" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_actions', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_reactions( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_reactions_nonce' ); ?>

    <p>
        <label for="stat_block_reactions"><?php _e( "What are the creature's reactions?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_reactions" id="stat_block_reactions" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_reactions', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_legendary_actions( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_legendary_actions_nonce' ); ?>

    <p>
        <label for="stat_block_legendary_actions"><?php _e( "What are the creature's legendary actions?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_legendary_actions" id="stat_block_legendary_actions" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_legendary_actions', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta_lair_actions( $post ) { 
    
    wp_nonce_field( basename(__FILE__), 'stat_block_lair_actions_nonce' ); ?>

    <p>
        <label for="stat_block_lair_actions"><?php _e( "What are the creature's lair actions?", "textdomain" ); ?></label>
        <br />
        <input class="widefat" type="text" name="stat_block_lair_actions" id="stat_block_lair_actions" value="<?php echo esc_attr( get_post_meta( $post->ID, 'stat_block_lair_actions', true ) ); ?>" size="30" />
    </p>

<?php }

function stat_block_meta( $post_id, $post ) {

    $input_fields = array(
        'stat_block_name',
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

    $new_meta_value = ( isset( $_POST[$nonce_field] ) ? esc_attr( $_POST[$nonce_field] ) : '' );

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