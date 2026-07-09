<?php
/**
 * Render image from path, id or attachment object
 */
function grif_image( $image, string $class = '', string $alt = '', $width = '', $height = '' ) {
    if ( !$image ) 
        return false;

    if ( is_string( $image ) ) {
        $image_src          = esc_url($image);
        $image_srcset       = '';
        $image_alt          = $alt;

    } elseif ( is_numeric( $image ) ) {
        $image_srcset       = wp_get_attachment_image_srcset( $image );

        // if there are several sizes present, we're requesting mobile size by default
        $image_size         = ( empty($image_srcset) ) ? 'full' : 'medium';
        $image_src          = wp_get_attachment_image_url( $image, $image_size );

        $attachment         = get_post( $image );
        $image_alt          = $alt ?? get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ?? '';
        $image_mime_type    = $attachment->post_mime_type;

        $image_src_array    = wp_get_attachment_image_src($image, $image_size);
        
        if ( isset( $image_src_array[1]) && isset($image_src_array[2]) ) {
            $width = $image_src_array[1];
            $height = $image_src_array[2];
        }

        if ( strpos($image_mime_type, 'image') === false ) 
            return false;

    } elseif ( $image instanceof \WP_Post ) {
        $image_srcset       = wp_get_attachment_image_srcset( $image->ID );
        
        $image_size         = ( empty($image_srcset) ) ?  'full' : 'medium';
        $image_src          = wp_get_attachment_image_url( $image->ID, $image_size );
        $image_alt          = $alt ?? get_post_meta( $image->ID, '_wp_attachment_image_alt', true ) ?? '';
        $image_mime_type    = $image->post_mime_type;

        $image_src_array    = wp_get_attachment_image_src( $image->ID, $image_size );

        if ( isset( $image_src_array[1]) && isset($image_src_array[2]) ) {
            $width = $image_src_array[1];
            $height = $image_src_array[2];
        }

        if ( strpos($image_mime_type, 'image') === false ) 
            return false;

    } else {
        return false;
    }

    return "<picture><img src=\"$image_src\" class=\"$class\" srcset=\"$image_srcset\" alt=\"$image_alt\" width=\"$width\" height=\"$height\" loading=\"lazy\"/></picture>";
}