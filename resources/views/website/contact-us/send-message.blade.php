
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
            
                toastr.success(response.message,'@lang("home.Success")');
                
                $('{{$formName}}')[0].reset();

            },
            error:function(mes){
                for (let key in mes.responseJSON.errors) {
                    toastr.error(mes.responseJSON.errors[key],'@lang("home.an error occurred")');
                    
                }
            }
        });
    
    });

});

</script>