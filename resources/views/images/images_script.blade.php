<script>
    $(document).ready(function() {
        $('#fileInputs').on('change', function(event) {
            $('#image-preview').empty(); // Clear any previous images
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) { // Check if the file is an image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $('<img>').attr('src', e.target.result).css('width', '100%').css('overflow','hidden');
                        const div = $('<div>').addClass('d-flex flex-column p-2');
                        const imgDiv = $('<div>').addClass('d-flex flex-column justify-content-center ').css('width', '100px').css('height','100px').append(img);
                        const btnDelete = $('<button>').addClass('btn btn-danger').text('Delete').attr('onclick','this.parentNode.remove()');
                        const btnSave = $('<button>').addClass('btn btn-success save-image').text('Save');
                         btnSave.on('click', (function(file, elem) {
                        return function() {
                            saveImg(file, elem);
                        }
                    })(files[i], btnSave));
                        $(div).append(imgDiv);
                        $(div).append(btnSave);
                        $(div).append(btnDelete);
                        $('#image-preview').append(div);
                    }

                    reader.readAsDataURL(file); // Read the file as a data URL
                }
            }
        });
    });

     function saveImg(image, elem) {
            let formData = new FormData();
            let group_container = document.getElementById('add-new-group');
            formData.append('image', image);
            $.ajax({
                type: "POST",
                url: "{{ $saveImageUrl }}",
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from overriding the content type

                success: function(response) {
                     const file = response.image
                    $(elem).parent().remove();
                    const dev = $('<div>').addClass('d-flex flex-column m-2').css({'width': '100px','height':'max-content'});
                    const img = $('<img>').attr('src', '{{ url("uploads/$folder/source") }}/'+file.image)
                    const closeBtn = $('<button>').addClass('badge badge-danger delete-image')
                        .html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg>');
                    dev.append(closeBtn);
                    dev.append(img);
                    closeBtn.on('click', (function(id, elem) {
                        return function() {
                            removePdfFromDB(id,elem)
                        }
                    })(file.id, closeBtn));
                    $('#image-uploaded').append(dev);
                    group_container.innerHTML=response.html_stock
                                document.querySelectorAll('[data-dynamic-select]').forEach(select => new DynamicSelect(select));
                                $(group_container).find('.select2').select2();
                },
                error: function(response) {
                    console.log(formData);
                    toastr.error(response.responseJSON.message);
                }
            });
        }

            function saveAllImages() {
                $('.save-image').each(function(index, element) {
                    element.click();
                });
            }
            function deleteAllImages() {
                $('.delete-image').each(function(index, element) {
                    element.click();
                });
            }

            function removePdfFromDB(id,elem) {
                let group_container = document.getElementById('add-new-group');
            $.ajax({
                type: "delete",
                url: "{{ $deleteImageUrl }}/"+id,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from overriding the content type

                success: function(response) {
                    $(elem).parent().remove();
                    group_container.innerHTML=response.html_stock
                                document.querySelectorAll('[data-dynamic-select]').forEach(select => new DynamicSelect(select));
                                $(group_container).find('.select2').select2();
                },
                error: function(response) {
                    toastr.error(response.responseJSON.message);
                }
            });
        }

    </script>
