<?php
function owls_item_func( $params, $content=null ) {
    extract( shortcode_atts( array(
        'padding' => '5'
    ), $params ) );

    $content = preg_replace( '/<br class="nc".\/>/', '', $content );
    $result =  '<div class="item">';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode( 'owls_item', 'owls_item_func' );
