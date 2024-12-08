<script>
    if ($('#select-attribute') && $('#values-container') ) {
        $(document).ready(function () {
            // Attach a change event to the element with ID attributeValues
            $('#select-attribute').on('change', function () {
                // Get the selected value(s)
                const selectedValues = $(this).val();
                // Make sure a value is selected
                if (selectedValues) {
                    // Perform an AJAX GET request
                    $.ajax({
                        url: '{{route("products.ajax.getValues")}}', // Replace with your API endpoint or route URL
                        type: 'GET',
                        data: {'attributes_id': selectedValues }, // Send the selected values as query parameters
                        success: function (response) {
                            $('#values-container').(response.html).select2()
                        },
                        error: function (xhr, status, error) {
                            console.log(error);

                            toastr.error(error.responseJSON.message)
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            });
        });

    }
</script>