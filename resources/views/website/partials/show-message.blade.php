<style>
    /* Customize the opacity of the Toastr container */
    .succBackground {
        background-color: #5cb85c ;
    }
    .errBackground{
        background-color: #d9534f ;
    }

</style>
<script>
    $(document).ready(function() {
    $('{{$formName}}').submit(function(event) {
        event.preventDefault(); // Prevent form submission
        var formData = $(this).serialize();
        $.ajax({
        type: "post",
        url: "{{$urlForm}}",
        data: formData,
        success: function (response) {
          
                toastr.options = {
                    "closeButton": true,  // Show close button
                    "progressBar": true,  // Show progress bar
                    "positionClass": "toast-top-right",  // Position of the toastr message
                    "showDuration": "300",  // Duration for which the toastr is displayed without user interaction
                    "hideDuration": "1000",  // Duration for which the toastr is hidden after user interaction
                    "timeOut": "5000",  // Duration before the toastr automatically closes
                    "extendedTimeOut": "1000",  // Extra duration if the user hovers over the toastr
                    "showEasing": "swing",  // Easing animation for showing the toastr
                    "hideEasing": "linear",  // Easing animation for hiding the toastr
                    "showMethod": "fadeIn",  // Method for showing the toastr
                    "hideMethod": "fadeOut",  // Method for hiding the toastr
                    "textColor": "#ffffff",  // Text color for success messages
                    "iconClass": "toast-success-icon",  // Icon class for success messages (can be customized with CSS)
                    "icon": "success",  // Icon for success messages (can be "success", "info", "warning", "error")
                    "toastClass": "succBackground" // Set your custom class here
                };

                toastr.success( {{$message??'response.message'}});
                $('{{$formName}}')[0].reset();

        },
        error:function(mes){
            toastr.options = {
                "closeButton": true,  // Show close button
                "progressBar": true,  // Show progress bar
                "positionClass": "toast-top-right",  // Position of the toastr message
                "showDuration": "300",  // Duration for which the toastr is displayed without user interaction
                "hideDuration": "1000",  // Duration for which the toastr is hidden after user interaction
                "timeOut": "5000",  // Duration before the toastr automatically closes
                "extendedTimeOut": "1000",  // Extra duration if the user hovers over the toastr
                "showEasing": "swing",  // Easing animation for showing the toastr
                "hideEasing": "linear",  // Easing animation for hiding the toastr
                "showMethod": "fadeIn",  // Method for showing the toastr
                "hideMethod": "fadeOut",  // Method for hiding the toastr
                "textColor": "#ffffff",  // Text color for error messages
                "iconClass": "toast-error-icon",  // Icon class for error messages (can be customized with CSS)
                "icon": "error" ,// Icon for error messages (can be "success", "info", "warning", "error")
                "toastClass": "errBackground" // Set your custom class here
            };
            for (let key in mes.responseJSON.errors) {
                toastr.error(mes.responseJSON.errors[key]);
                
            }
        }
    });
    
    });

});

</script>