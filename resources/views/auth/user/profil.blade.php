@extends('layouts.app')
@section('content')
<script src="{{asset('template/js/pages/features/forms/widgets/input-mask.js')}}"></script>
<div class="row">
    <div class="col-xxl-5 col-xl-6 col-md-6 col-sm-6">
        <div class="card card-custom gutter-b card-stretch">
            <div class="card-body pt-4">
                <div class="d-flex align-items-end py-2">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-shrink-0 mr-5">
                            <div class="symbol symbol-circle symbol-lg-75">
                                <img src="{{url('template/media/users/blank.png')}}" alt="image"/>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <a class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{$user->user_name}}</a>
                            <span class="text-muted font-weight-bold">{{$user->role}}</span>
                        </div>
                    </div>
                </div>
                <div class="py-2">
                    <div class="d-flex align-items-center mb-2">
                        <span class="flex-shrink-0 mr-2">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"></path>
                                    </g>
                                </svg>
                            </span>
                        </span>
                        <a class="text-muted text-hover-primary font-weight-bold">{{$user->email}}</a>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="flex-shrink-0 mr-2">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M7.13888889,4 L7.13888889,19 L16.8611111,19 L16.8611111,4 L7.13888889,4 Z M7.83333333,1 L16.1666667,1 C17.5729473,1 18.25,1.98121694 18.25,3.5 L18.25,20.5 C18.25,22.0187831 17.5729473,23 16.1666667,23 L7.83333333,23 C6.42705272,23 5.75,22.0187831 5.75,20.5 L5.75,3.5 C5.75,1.98121694 6.42705272,1 7.83333333,1 Z" fill="#000000" fill-rule="nonzero"/>
                                        <polygon fill="#000000" opacity="0.3" points="7 4 7 19 17 19 17 4"/>
                                        <circle fill="#000000" cx="12" cy="21" r="1"/>
                                    </g>
                                </svg>
                            </span>
                        </span>
                        <a class="text-muted text-hover-primary font-weight-bold">{{$user->contact}}</a>
                    </div>
                </div>
                <div class="pt-2">
                    <!--a onclick="formShow()" class="btn btn-light-primary font-weight-bolder">Modifier les informations</a-->
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-7 col-xl-6 col-md-6 col-sm-6 modif" id="profil_info">
        <div class="card card-custom gutter-b card-stretch">
            <form method="post" action="{{route('auth.user.profil.update',$user->id)}}">
                <div class="card-body pt-4">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Nom complet *</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="flaticon2-user icon-lg"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control @if($errors->has('user_name'))is-invalid @endif" id="user_name" name="user_name" value="{{$user->user_name}}"  placeholder="Nom et pr&eacute;nom(s)..." required/>
                                    @if($errors->has('user_name'))
                                        <p class="text-danger">{{ $errors->first('user_name') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>E-mail</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="flaticon-email icon-lg"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control @if($errors->has('email'))is-invalid @endif" id="email" name="email" value="{{$user->email}}"  placeholder="Kullan?c? E-posta..." required/>
                                    @if($errors->has('email'))
                                        <div class="text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Contact</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="flaticon-support icon-lg"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control @if($errors->has('contact'))is-invalid @endif" id="contact" name="contact" value="{{$user->contact}}"  placeholder="Contact..." required/>
                                    @if($errors->has('contact'))
                                        <div class="text-danger">{{ $errors->first('contact') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-lock icon-lg"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control @if($errors->has('password'))is-invalid @endif" id="password" name="password"/>
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>R&eacute;p&eacute;ter le mot de passe</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="flaticon-lock icon-lg"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control @if($errors->has('password_confirmation'))is-invalid @endif" id="password-confirm" name="password_confirmation"/>
                                @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                <div class="card-footer pt-4">
                    <button type="submit" class="btn btn-sm btn-success mr-2">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
 
    function formShow(){
        var isDnone = document.querySelector('.d-none');

        if (isDnone !== null) {
            $("#profil_info").removeClass('d-none');
        }else{
            $("#profil_info").addClass('d-none');
        }
    }

    $(function () {
        // phone number format
        $("#contact").inputmask("mask", {
            "mask": "99 99 99 99 99"
        });
    });
</script>
@endsection

