<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>Smart-Ordo | Connexion</title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
                <script src="{{asset('plugins/jQuery/query.min.js')}}"></script>
                <script src="{{asset('template/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="{{asset('template/css/pages/login/login-2.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{asset('template/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('template/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css"/>
		<link href="{{asset('template/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{asset('template/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('template/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('template/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('template/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{asset('template/media/logos/fav.png')}}" />
      
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body"  class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root" >
			<!--begin::Login-->
			<div style="background-image:url('{{asset('template/media/img/image-4.jpg')}}');" class="login login-2 login-signin-on d-flex flex-column flex-column-fluid bg-white position-relative overflow-hidden"  id="kt_login">
				<!--begin::Header-->
				<div class="login-header py-10 flex-column-auto">
					<div class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
						<!--begin::Logo-->
<!--						<a href="#" class="flex-column-auto py-5 py-md-0">
							<img src="{{url('template/media/logos/logo.png')}}" alt="logo" class="h-100px" />
						</a>-->
						<!--end::Logo-->
					</div>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="login-body d-flex flex-column-fluid align-items-stretch justify-content-center">
					<div class="container row">
						<div class="col-lg-12 d-flex align-items-center">
							<!--begin::Signin-->
							<div class="login-form login-signin">
								<!--begin::Form-->
								<form class="form w-xxl-550px rounded-lg p-20" method="post" action="{{ route('login') }}" novalidate="novalidate" id="kt_login_signin_form" style="background-color: #fff;">
                                        @csrf
									<!--begin::Title-->
									<div class="pb-13 pt-lg-0 pt-5">
										<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Smart-Ordo</h3>
									</div>
									<!--begin::Title-->
									<!--begin::Form group-->
									<div class="form-group">
										<label class="font-size-h6 font-weight-bolder text-dark">E-mail</label>
										<input class="form-control form-control-solid h-auto p-6 rounded-lg" type="email" value="{{ old('email') }}" name="email" required autocomplete="email" autofocus/>
										@error('email')
											<h4 style="color: red;">{{ $message }}</h4>
										@enderror
									</div>
									<!--end::Form group-->
									<!--begin::Form group-->
									<div class="form-group">
										<label class="font-size-h6 font-weight-bolder text-dark pt-5">Mot de passe</label>
										<input class="form-control form-control-solid h-auto p-6 rounded-lg" type="password" name="password" autocomplete="off" autocomplete="current-password" required/>
										@error('password')
											<h4 style="color: red;">{{ $message }}</h4>
										@enderror
                                    </div>
                                                                        <p style="text-align: right;">
                                                                            <a href="javascript:;" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Mot de passe oubli&eacute;?</a>
                                                                        </p>
									<!--end::Form group-->
									<!--begin::Action-->
									<div class="pb-lg-0 pb-5">
                                                                            <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Connexion</button>
									</div>
										<br/>
									<div class="font-size-h6 font-weight-bolder order-2 order-md-1 py-2 py-md-0">
							<span class="text-muted font-weight-bold mr-2">Copyright &copy; 2021</span>
							<a href="https://groupsmarty.com/" target="_blank" class="text-dark-50 text-hover-primary">GroupSmarty </a>, All rights reserved.
						</div>
									<!--end::Action-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Signin-->
						
							<!--begin::Forgot-->
							<div class="login-form login-forgot">
								<!--begin::Form-->
								<form class="form w-xxl-550px rounded-lg p-20" novalidate="novalidate" id="kt_login_forgot_form"  style="background-color: #fff;">
                                            @csrf
									<div class="pb-13 pt-lg-0 pt-5">
                                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Smart-Ordo</h3>
										<p class="text-muted font-weight-bold font-size-h4">Entrez votre adresse mail puis envoyer pour recevoir votre nouveau mot de passe</p>
									</div>
									<!--end::Title-->
									<!--begin::Form group-->
									<div class="form-group">
										<input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="email" placeholder="E-mail" name="email" required/>
									</div>
									<!--end::Form group-->
									<!--begin::Form group-->
									<div class="form-group d-flex flex-wrap pb-lg-0">
                                        <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Envoyer</button>
										<button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Annuler</button>
									</div>
									<div class="font-size-h6 font-weight-bolder order-2 order-md-1 py-2 py-md-0">
							<span class="text-muted font-weight-bold mr-2">Copyright &copy; 2021</span>
							<a href="https://groupsmarty.com/" target="_blank" class="text-dark-50 text-hover-primary">GroupSmarty </a>, All rights reserved.
						</div>
									<!--end::Form group-->
								</form>
								<!--end::Form-->
								
							</div>
							<!--end::Forgot-->
						</div>
					</div>
				</div>
				<!--end::Body-->
				<!--begin::Footer-->
				<div class="login-footer py-10 flex-column-auto">
					<div class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
						
					</div>
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<script>var HOST_URL = "https://preview.keenthemes.com/keen/theme/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3E97FF", "secondary": "#E5EAEE", "success": "#08D1AD", "info": "#844AFF", "warning": "#F5CE01", "danger": "#FF3D60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#DEEDFF", "secondary": "#EBEDF3", "success": "#D6FBF4", "info": "#6125E1", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{asset('template/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('template/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
		<script src="{{asset('template/js/scripts.bundle.js')}}"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="{{asset('template/js/pages/custom/login/login.js')}}"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>