<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <h4 class="modal-title" id="myModalLabel">Register</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p class="text-grey">*All fields are required</p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <strong>Note:</strong> This modal can be edited at: <code><{$appPath}>
                                    /Templates/login_register.tpl</code>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="registerErrBlock" class="notice alert" style="display: none;">
                    <!-- error block -->
                </div>
                <form id="registerForm" class="container-fluid" action="/user/register">
                    <input type="hidden" name="csrf" value="<{$csrf}>" />
                    <div class="row-fluid">
                        <div class="col-md-6 col-xs-12">
                            <input type="text" name="fname" placeholder="First Name *" required/>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" name="lname" placeholder="Last Name *" required/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <input type="email" name="email" placeholder="Email Address *" required/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-6 col-xs-12">
                            <input id="password" type="password" name="password" placeholder="Password *" required/>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input id="password_confirm" type="password" name="password_confirm"
                                   placeholder="Confirm Password *" required/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-12 text-center">
                            <button id="registerBtn" data-loading-text="Registering..." type="button"
                                    class="btn btn-default btn-primary btn-fluid">REGISTER
                            </button>
                        </div>
                        <div class="col-sm-12 signin-wrap text-center">
                            <p>By clicking 'REGISTER' you agree to our <a href="/terms">Terms & Conditions</a></p>

                            <p>Already have an account? <a id="loginLink" href="#login">Sign in</a></p>
                        </div>
                    </div>
                </div>

                <{*<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>*}>
                <{*<button type="button" class="btn btn-primary">Save changes</button>*}>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <h4 class="modal-title" id="myModalLabel">Login</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p class="text-grey">*All fields are required</p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <strong>Note:</strong> This modal can be edited at: <code><{$appPath}>
                                    /Templates/login_register.tpl</code>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="loginErrBlock" class="notice alert" style="display: none;">
                    <!-- error block -->
                </div>
                <form id="loginForm" class="container-fluid" action="/user/login">
                    <input type="hidden" name="csrf" value="<{$csrf}>" />
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <input type="email" name="email" placeholder="Email Address *" required/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <input type="password" name="password" placeholder="Password *" required/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-12 text-center">
                            <button id="loginBtn" data-loading-text="Verifying..." type="button"
                                    class="btn btn-default btn-primary btn-fluid">LOGIN
                            </button>
                        </div>
                        <div class="col-sm-12 signin-wrap text-center">
                            <p>Do not have an account? <a id="registerLink" href="#register">Register now</a></p>
                        </div>
                    </div>
                </div>

                <{*<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>*}>
                <{*<button type="button" class="btn btn-primary">Save changes</button>*}>
            </div>
        </div>
        <div class="forgot-pass-wrap text-center">
            <a id="forgotpass" href="#forgotpass">Forgot your password?</a>
        </div>
    </div>
</div>

<!-- forgot password modal -->
<div class="modal fade" id="forgotPassModal" tabindex="-1" role="dialog" aria-labelledby="forgotPassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <h4 class="modal-title" id="forgotPassLabel">Forgot Password</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p class="text-grey">*All fields are required</p>
                        </div>
                    </div>
                </div>
                <div id="fpMsgBlock" class="notice alert" style="display: none;">
                    <!-- error block -->
                </div>
                <form id="forgotPassForm" class="container-fluid" action="/user/forgotpass">
                    <input type="hidden" name="csrf" value="<{$csrf}>" />
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <input type="email" name="email" placeholder="Email Address *" required />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-12 text-center">
                            <button id="forgotPassBtn" data-loading-text="Sending Email..." type="button" class="btn btn-default btn-gold btn-fluid" >RESET PASSWORD</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>