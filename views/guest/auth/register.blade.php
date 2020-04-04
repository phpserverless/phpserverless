@extends('guest.layout', ['webpage_title' => 'Register'])

@section('content')
<!-- START: Message Area -->
<div class="container">
    <div id="alert-area" class="col-sm-12" style="margin-left: 0px;"></div>
</div>
<!-- END: Message Area -->

<!-- START: Content -->
<div class="container">
    <br />
    <br />

    <div class="row">
        <div class="col-md-4" style="margin:0 auto;">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title" data-i18n="Auth.Login.HeadingSignIn" style="margin:0px;">
                        Register
                    </h3>
                </div>
                <div class="card-body form_login">
                    <!-- START: Message Area -->
                    <div class="form-group">
                        <div class="alert alert-success" style="display:none;">
                            <a class="close" data-dismiss='alert'>×</a>
                            <strong>Success</strong>
                            <span class="successMessage">&nbsp;</span>
                        </div>
                        <div class="alert alert-danger" style="display:none;">
                            <a class="close" data-dismiss='alert'>×</a>
                            <strong>Error</strong>
                            <span class="errorMessage">&nbsp;</span>
                        </div>
                    </div>
                    <!-- END: Message Area -->

                    <!-- START: Email -->
                    <div class="form-group">
                        <input class="form-control" placeholder="E-mail" name="email" type="text"
                            data-i18n="Auth.Register.InputEmail" />
                    </div>
                    <!-- END: Email -->

                    <!-- START: First Name -->
                    <div class="form-group">
                        <input class="form-control" placeholder="First Name" name="first_name" type="text"
                            data-i18n="Auth.Register.InputFirstName" />
                    </div>
                    <!-- END: First Name -->

                    <!-- START: Last Name -->
                    <div class="form-group">
                        <input class="form-control" placeholder="Last Name" name="last_name" type="text"
                            data-i18n="Auth.Register.InputLastName" />
                    </div>
                    <!-- END: Last Name -->

                    <input type="hidden" name="sid" value="" />

                    <!-- START: Register -->
                    <button class="buttonRegister btn btn-lg btn-success btn-block"
                        onclick="return registrationFormValidate();" data-i18n="Auth.Register.ButtonLogin">
                        <span class="fas fa-check-circle"></span>
                        &nbsp;&nbsp;
                        Register
                        <i class="imgLoading fas fa-spinner fa-spin" style="display:none;"></i>
                    </button>
                    <!-- END: Register -->

                    <!-- START: Actions -->
                    <div style="margin-top:30px;">
                        <a href="/auth/login" onclick="$$.to('/auth/login')" class="btn btn-info float-left">
                            <span class="fas fa-book"></span>
                            &nbsp;&nbsp;
                            <span data-i18n="Auth.Register.ButtonLogin">
                                Login
                            </span>
                        </a>
                        <a href="/auth/password-restore" onclick="$$.to('/auth/password-restore')"
                            class="btn btn-warning float-right" onclick="router.to('auth/restore-password');">
                            <span data-i18n="Auth.Register.ButtonForgottenPasssword">
                                Forgotten Password?
                            </span>
                        </a>
                    </div>
                    <!-- END: Actions -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content -->
@endsection

@section('scripts')
<script>
$(function() {
    if ($$.getUser() === null || $$.getToken() === null) {
        $$.to('/');
    }
    if ($$.getUser().Status !== "Pending") {
        $$.to('/');
    }
});
</script>
<!-- START: Scripts -->
<script>
/**
 * Raises an error message
 * @param {String} error
 * @returns {Boolean}
 */
function registrationFormRaiseError(error) {
    $('div.alert-success').html('').hide();
    $('div.alert-danger').html(error).show();
    setTimeout(function() {
        $('div.alert-danger').html('').hide();
    }, 3000);
    return false;
}

function registrationFormRaiseSuccess(success) {
    $('div.alert-danger').html('').hide();
    $('div.alert-success').html(success).show();
    setTimeout(function() {
        $('div.alert-success').html('').hide();
    }, 3000);
    return false;
}

/**
 * Validate Login Form
 * @returns {Boolean}
 */
function registrationFormValidate() {
    var email = $.trim($('input[name=email]').val());
    var firstName = $.trim($('input[name=first_name]').val());
    var lastName = $.trim($('input[name=last_name]').val());

    if (email === '') {
        return registrationFormRaiseError('Email is required');
    }

    if (firstName === '') {
        return registrationFormRaiseError('First name is required');
    }

    if (lastName === '') {
        return registrationFormRaiseError('Last name is required');
    }

    $('.buttonRegister .imgLoading').show();

    var data = {
        "email": email,
        "first_name": firstName,
        "last_name": lastName
    };
    var p = $$.ws('auth/register', data);

    p.done(function(response) {
        $('.buttonRegister .imgLoading').hide();

        if (response.status !== "success") {
            return registrationFormRaiseError(response.message);
        }

        registrationFormRaiseSuccess(response.message);
        $('div.alert-danger').html('').hide();

        setTimeout(function() {
            $$.to('auth/login');
        }, 3000);
    });

    p.fail(function(error) {
        $('.buttonRegister .imgLoading').hide();
        return registrationFormRaiseError('There was an error. Try again later!');
    });
}
$(function() {
    $("#email").focus();
});
</script>
<!-- END: Scripts -->
@endsection