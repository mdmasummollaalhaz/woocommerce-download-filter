// Woocommerce Download filter
add_filter( 'woocommerce_available_download_link', 'filter_wc_downloads_so_16142748', 10, 2 );

function filter_wc_downloads_so_16142748( $link, $download )
{
    // Create a WC_Order object and get the file URLs for this product
    $order = new WC_Order( $download['order_id'] );
    $download_file_urls = $order->get_downloadable_file_urls( 
        $download['product_id'], 
        null, 
        $download['download_id'] 
    );

    // Check each download URL and compare with the current URL 
    // $key contains the real file URL and $value is the encoded URL
    foreach( $download_file_urls as $key => $value )
    {
        if( $value == $download['download_url'] )
        {
            $url_parts = explode( '/', parse_url( $key, PHP_URL_PATH ) );
            $file_name = end( $url_parts );
            $link = '<a href="' 
                . esc_url( $download['download_url'] ) 
                . '">' 
                . $download['download_name'] 
                . '</a> <small>( ' 
                . $file_name 
                . ' )</small>';
        }               
    }
    return $link;
}
