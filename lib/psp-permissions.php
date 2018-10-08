<?php
function psp_lite_check_for_access( $post_id = null ) {

    $post_id = ( $post_id == null ? get_the_ID() : $post_id );

    if( 'psp_projects' != get_post_type($post_id) ) {
        return true;
    }

    if( current_user_can('edit_others_psp_projects') ) {
        return true;
    }

    if( is_post_type_archive('psp_projects') && is_user_logged_in() ) {
        return true;
    }

    $access_restricted = get_post_meta( $post_id, 'restrict_access_to_specific_users', true );

    if( !$access_restricted ) {
        return true;
    }

    // This contains an array of user_ids
    $users = psp_lite_parse_users( get_post_meta( $post_id, '_pano_users', true ) );
    $user  = wp_get_current_user();

    if( is_user_logged_in() && !empty($users) && in_array( $user->ID, $users ) ) {
        return true;
    }

    return false;

}

function psp_lite_parse_users( $users = null ) {

    if( $users == null ) {
        return false;
    }

    $users = str_replace( "'", '', $users );
    $users = str_replace( ' ', '', $users );
    $users = array_map( 'intval', explode( ',', $users ) );

    return $users;

}

function psp_lite_comb_projects( $projects = null ) {

    if( $projects == null || !$projects->have_posts() ) {
        return $false;
    }

    $user           = wp_get_current_user();
    $combed_posts   = array();

    while( $projects->have_posts() ) { $projects->the_post();

        global $post;

        if( psp_lite_check_for_access( $post->ID ) ) {
            $combed_posts[] = $post;
        }

    }

    $projects->posts = $combed_posts;

    return $projects;

}
