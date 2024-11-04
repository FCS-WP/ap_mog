<?php
add_action('wp_ajax_change_currency', 'change_currency_ajax');
add_action('wp_ajax_nopriv_change_currency', 'change_currency_ajax');
function change_currency_ajax()
{
  // Check if currency is set
  if (isset($_POST['currency'])) {
    $currency = sanitize_text_field($_POST['currency']);
    update_option('woocommerce_currency', $currency);

    $response_success = array(
      'status' => true,
      'message' => 'successfully',
    );
  
    wp_send_json_success($response_success);
  
    wp_die();
  }
  // Send error response if currency not set
  wp_send_json_error();
}



add_action('wp_footer', "active_currency");

function active_currency() {
?>
  <script>
    var currentCurrency = '<?php echo get_option("woocommerce_currency"); ?>';
    jQuery('.currency-active').find("a").eq(0).text(currentCurrency);
  </script>


<?php

}
