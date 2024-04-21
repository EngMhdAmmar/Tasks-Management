@extends('layouts.auth_url') @section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Brand logo-->
                    <a class="brand-logo" href="index.html">
                        <h2 class="brand-text text-primary ms-1">IxCoders</h2>
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="../../../app-assets/images/illustration/two-steps-verification-illustration.svg" alt="two steps verification" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- two steps verification v2-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <form id="checkCodeForm" class="mt-2" action="{{route('checkVerificationCode', Route::getRoutes()->match(Request::create(url()->previous()))->getName())}}" method="POST">
                                @csrf @method('POST')
                                <h6>Type your 6 digit security code</h6>
                                <div class="auth-input-wrapper d-flex align-items-center justify-content-between">
                                    <input id="code-box-1" oninput="goNext(this)" class="form-control auth-input height-50 text-center numeral-mask mx-25 mb-1  @error('verification_code.0') is-invalid @enderror" type="text" name="verification_code[]" maxlength="1" autofocus="" />
                                    <input id="code-box-2" oninput="goNext(this)" class="form-control auth-input height-50 text-center numeral-mask mx-25 mb-1  @error('verification_code.1') is-invalid @enderror" type="text" name="verification_code[]" maxlength="1" />
                                    <input id="code-box-3" oninput="goNext(this)" class="form-control auth-input height-50 text-center numeral-mask mx-25 mb-1  @error('verification_code.2') is-invalid @enderror" type="text" name="verification_code[]" maxlength="1" />
                                    <input id="code-box-4" oninput="goNext(this)" class="form-control auth-input height-50 text-center numeral-mask mx-25 mb-1  @error('verification_code.3') is-invalid @enderror" type="text" name="verification_code[]" maxlength="1" />
                                    <input id="code-box-5" oninput="goNext(this)" class="form-control auth-input height-50 text-center numeral-mask mx-25 mb-1  @error('verification_code.4') is-invalid @enderror" type="text" name="verification_code[]" maxlength="1" />
                                </div>
                                @if(session()->has('error'))
                                <div class="alert alert-danger"> {{ session('error') }} </div> @endif
                                <input type="submit" value="Verify my account" class="btn btn-primary w-100">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function goNext(elem) {
            if ($(elem).val().length == 0)
                return;
            id = elem.id.replace("code-box-", "");
            id = Number(id) + 1
            if (allInputsFilled()) {
                $("#checkCodeForm").submit();
            }
            $(`#code-box-${id}`).focus();
        }
        function allInputsFilled() {
            inputs = $(".numeral-mask");
            inputs = Object.values(inputs);
            let allFilled = true;
            inputs.forEach(element => {
                if (element.id && element.id.includes('code-box') && $(element).val().length == 0) {
                    console.log(element);
                    allFilled = false;
                    return false;
                }
            });
            return allFilled;
        }
</script>
@endsection