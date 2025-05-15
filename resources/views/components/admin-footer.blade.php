	<!-- Bootstrap JS -->
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
	<script src="{{asset('assets/plugins/chartjs/js/Chart.min.js')}}"></script>
	<script src="{{asset('assets/plugins/chartjs/js/Chart.extension.js')}}"></script>
	<script src="{{asset('assets/js/index.js')}}"></script>
	<!--app JS-->
	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="{{asset('assets/js/parsley.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- images upload --}}
    <script src="{{asset('assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js')}}"></script>
	<script>
        $(document).ready(function () {
            $('#image-uploadify').imageuploadify();
		})
    </script>
    {{-- images upload --}}

    {{-- datatable --}}
    <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable( {
                lengthChange: false,
                buttons: [ 'copy', 'excel', 'pdf', 'print']
            } );

            table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
        } );
    </script>
    {{-- datatable --}}

	<script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();

            // Get the associated image element for this file input
            var img = input.nextElementSibling; // This assumes the image comes immediately after the input field

            reader.onload = function() {
                img.src = reader.result;  // Set the image source to the result of the reader
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
    </script>
    <script>

        $(document).ready(function () {
            $(".ButtonPressJquery").each(function () {
                let form = $(this);
                let initialFormData = form.serialize();
                let formChanged = false;

                let SubmitButton = '<input type="submit" class="btn btn-primary px-4" value="Save Changes">';
                let LoadingButton = '<button class="btn btn-primary" type="button" disabled> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</button>';

                form.find(":input").on("input change", function () {
                    formChanged = form.serialize() !== initialFormData;
                });

                form.submit(function (e) {
                    e.preventDefault();

                    if (form.parsley().validate()) {
                        // Ensure we are updating the correct button inside the form
                        form.find('#SubmitButton').html(LoadingButton);

                        $.ajax({
                            type: "POST",
                            url: form.attr("action"),
                            data: new FormData(this),
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            success: function (result) {
                                console.log("Success:", result);
                                toastr.clear();

                                if (result.status === "Success") {
                                    toastr.success(result.message || "Data Saved Successfully", "Success");

                                    initialFormData = form.serialize();
                                    formChanged = false;

                                    setTimeout(function() {
                                        location.reload();
                                    }, 1500);

                                } else {
                                    toastr.error(result.message || "Something went wrong", "Error");
                                }
                                form.find('#SubmitButton').html(SubmitButton);
                            },
                            error: function (xhr) {
                                console.log(xhr.responseText);
                                toastr.error(JSON.parse(xhr.responseText).message, "Error");
                                form.find('#SubmitButton').html(SubmitButton);
                            }
                        });
                    }
                });
            });
        });

        // Toggle Status Without Page Reload
        $(".toggle-status").click(function (e) {
            e.preventDefault();
            let btn = $(this);
            let url = btn.attr("href");

            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    if (response.status === "Success") {
                        toastr.success(response.message, "Updated");
                        btn.find("span").toggleClass("bg-success bg-danger").text(response.newStatus);
                    } else {
                        toastr.error(response.message || "Could not update status", "Error");
                    }
                },
                error: function () {
                    toastr.error("An error occurred while updating status", "Error");
                }
            });
        });

    </script>



    