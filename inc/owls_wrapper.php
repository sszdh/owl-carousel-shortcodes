<?php
function owls_wrapper_func( $params, $content = null ) {

    extract( shortcode_atts( array(
        'num' => '1',
        'centered' => 'false',
        'rtl' => 'true',
    ), $params ) );

    $content = preg_replace( '/<br class="nc".\/>/', '', $content );
    $result =  '<div class="owl-wrapper"><div class="owl-carousel owl-theme" data-num="'. $num .'" ' . ($centered == 'true' ? 'data-centered="true"' : '') . ' '. ($rtl == 'true' ? 'data-rtl="true"' : '') .'>';
    $result .= do_shortcode( $content );
    $result .= '</div></div>';
    return force_balance_tags( $result );
}
add_shortcode( 'owls_wrapper', 'owls_wrapper_func' );
