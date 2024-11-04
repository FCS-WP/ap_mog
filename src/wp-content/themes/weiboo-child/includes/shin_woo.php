<?php

function change_currency_ajax()
{
  // Check if currency is set
  if (isset($_POST['currency'])) {
    $currency = sanitize_text_field($_POST['currency']);
    update_option('woocommerce_currency', $currency);

    // Send success response
    wp_send_json_success();
  }
  // Send error response if currency not set
  wp_send_json_error();
}
add_action('wp_ajax_change_currency', 'change_currency_ajax');
add_action('wp_ajax_nopriv_change_currency', 'change_currency_ajax');
