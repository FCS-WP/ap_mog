jQuery(document).ready(function ($) {
  $(".currency-item").on("click", function (event) {
    event.preventDefault();

    // Get the title attribute from the <a> tag within the clicked item
    var title = $(this).find("a").attr("title");
    console.log(title); // Output the title to the console

    // Send AJAX request to change currency
    $.ajax({
      url: '/wp-admin/admin-ajax.php',
      method: "POST",
      dataType: "json",
      data: {
        action: "change_currency",
        currency: title, // Use the title for the currency
      },
      success: function (data) {
        if (data.success) {
          location.reload(); // Reload the page to show updated prices
        }
      },
    });
  });
  // Set the initial active currency based on the current currency
});

