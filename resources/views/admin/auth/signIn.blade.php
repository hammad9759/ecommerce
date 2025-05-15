<!doctype html>
<html lang="en">
<x-admin-header></x-admin-header>
<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<img src="{{asset('assets/images/logo-img.png')}}" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign in</h3>
										<p>Don't have an account yet? <a href="authentication-signup.html">Sign up here</a>
										</p>
									</div>
									<div class="form-body">
										<form class="row g-3" id="formSubmit">
											@csrf
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email Address</label>
												<input type="email" name="email" class="form-control" id="inputEmailAddress" placeholder="Email Address" Required>
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Enter Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" value="" placeholder="Enter Password" Required>
													<a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div>
											<div class="col-md-6 text-end">	<a href="authentication-forgot-password.html">Forgot Password ?</a>
											</div>
											<div class="col-12">
												<div class="d-grid">
                                                    <span id="SubmitButton">
                                                        <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign in</button>
                                                    </span>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
    <x-admin-footer></x-admin-footer>

	<!-- parsley validation -->
	<script>
$("#formSubmit").submit(function(e) {
    let SubmitButton = '<input type="submit" class="btn btn-primary px-4" value="Save Changes">';
    let LoadingButton = '<button class="btn btn-primary" type="button" disabled> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</button>';

    e.preventDefault();

    if ($(this).parsley().validate()) {
        document.getElementById("SubmitButton").innerHTML = LoadingButton;
        var url = "{{ url('login_user') }}";

        $.ajax({
            url: url,
            data: $('#formSubmit').serialize(),
            type: 'post',
            success: function(result) {
                toastr.clear();
                if (result.status == 200) {
                    toastr.success(result.message || "Data Saved Successfully", "Success");
                    setTimeout(function() {
                        window.location.href = result.url;
                    }, 1500);
                } else {
                    toastr.error(result.message || "Something went wrong", "Error");
                }
                document.getElementById("SubmitButton").innerHTML = SubmitButton;
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);  // Log the error in the console

                if (xhr.status === 500) {
                    toastr.error("Server is down or not responding. Please try again later.", "Error");
                } else if (xhr.status === 0) {
                    toastr.error("Cannot connect to the server. Check your internet or server status.", "Error");
                } else {
                    toastr.error("An unexpected error occurred. Please try again.", "Error");
                }

                document.getElementById("SubmitButton").innerHTML = SubmitButton;
            }
        });
    } else {
        toastr.error("Form validation failed. Please check your inputs.", "Error");
        document.getElementById("SubmitButton").innerHTML = SubmitButton;
    }
});

	</script>

</body>
</html>


how to handle "http://127.0.0.1:8000/login_user 500 (Internal Server Error)"
