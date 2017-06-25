<?php
require './inc/config.php';
include VIEW_HEADER
?>
<div data-role="page">
    <div data-role="header">
        <h1>Home</h1>
    </div>
    <?php
    $notify = isset($_GET['notify']) ? $_GET['notify'] : '';
    if (htmlspecialchars($notify) == "success") {
        ?>
        <script>
            $(function () {
                setTimeout(function () {
                    $("#popupDialogSuccess").popup("open");
                }, 1000);
            });
        </script>
        <div data-role="popup" id="popupDialogSuccess" data-position-to="window" data-transition="turn">
            <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
            <p>Login Success. Please choose the product again.</p>
        </div>
    <?php } else if (htmlspecialchars($notify) == "error") { ?>
        <script>
            $(function () {
                setTimeout(function () {
                    $("#popupDialogError").popup("open");
                }, 1000);
            });
        </script>
        <div data-role="popup" id="popupDialogError" data-position-to="window" data-transition="turn">
            <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
            <p>Transaction Failed. Please try again.</p>
        </div>
    <?php } else if (htmlspecialchars($notify) == "register") { ?>
        <script>
            $(function () {
                setTimeout(function () {
                    $("#popupDialogRegister").popup("open");
                }, 1000);
            });
        </script>
        <div data-role="popup" id="popupDialogRegister" data-position-to="window" data-transition="turn">
            <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
            <p>Register Success. Please choose the product again.</p>
        </div>
    <?php } ?>
    <div data-role="popup" id="popupDialog" data-dismissible="false">
        <div data-role="header">
            <h1>Coming Soon!!!</h1>
        </div>
        <div role="main" class="ui-content">
            <p>Service not ready. We will contact you via email soon.</p>
            <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn" data-rel="back">Close</a>
        </div>
    </div>
    <div data-role="popup" id="popupDialogLogin" data-dismissible="false">
        <script>
            $(function () {
                $('form').validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true
                        }
                    },
                    messages: {
                        email: {
                            required: "Please enter your email."
                        },
                        password: {
                            required: "Please enter your password."
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.appendTo(element.parent().prev());
                    },
                    submitHandler: function (form) {
                        $.mobile.loading('show', {text: "Please wait...", textonly: false, textVisible: true});
                        var strData = $(form).serialize();
                        $.ajax({
                            type: "POST",
                            url: site + "function/login.php",
                            data: strData,
                            dataType: "json",
                            success: function (msg) {
                                if (JSON.parse(msg['success']) === 1) {
                                    setCookie('user', msg['data'][0]['customer_id'], 1);
                                    $.mobile.loading('hide');
                                    window.location = site + 'index.php?notify=success';
                                } else {
                                    $.mobile.loading('hide');
                                    window.location = site + 'index.php?notify=error';
                                }
                            }
                        });
                    }
                });
            });
        </script>
        <div data-role="header">
            <h1>Login</h1>
            <a href="#" class="ui-btn-right" data-rel="back">X</a>
        </div>
        <div role="main" class="ui-content">
            <form method="post">
                <input type="hidden" name="ajax" value="1">
                <label for="email">Email</label>
                <input type="text" data-clear-btn="true" name="email" id="email" value="">
                <label for="password">Password</label>
                <input type="password" data-clear-btn="true" name="password" id="password" value="">
                <button class="ui-shadow ui-btn ui-corner-all">Login</button>
            </form>
            <div style="width: 100%; height: 15px; border-bottom: 1px solid black; text-align: center">
                <span style="font-size: 20px; background-color: #FFFFFF; padding: 0 5px;">
                    or
                </span>
            </div>
            <a href="register.php" data-ajax="false" class="ui-btn">Register</a>
        </div>
    </div>
    <div data-role="main" class="ui-content">
        <div data-role="collapsible" data-collapsed="false">
            <h4>Power Plant</h4>
            <ul data-role="listview">
                <?php if (!isset($_COOKIE['user'])) { ?>
                    <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Enterprise Asset Management</a></li>
                    <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Efficiency</a></li>
                    <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Reliability</a></li>
                <?php } else { ?>
                    <li><a href="product/eam.php" data-ajax="false">Enterprise Asset Management</a></li>
                    <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Efficiency</a></li>
                    <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Reliability</a></li>
                <?php } ?>
            </ul>
            <h4></h4>
            <div data-role="collapsible" data-collapsed="true">
                <h4>Mechanical</h4>
                <ul data-role="listview">
                    <?php if (!isset($_COOKIE['user'])) { ?>
                        <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Steam Turbine</a></li>
                        <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Gas Turbine</a></li>
                    <?php } else { ?>
                        <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Steam Turbine</a></li>
                        <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Gas Turbine</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div data-role="collapsible" data-collapsed="true">
                <h4>Electrical</h4>
                <ul data-role="listview">
                    <?php if (!isset($_COOKIE['user'])) { ?>
                        <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Transformer</a></li>
                    <?php } else { ?>
                        <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Transformer</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div data-role="collapsible" data-collapsed="true">
                <h4>Instrumentation and Control</h4>
                <ul data-role="listview">
                    <?php if (!isset($_COOKIE['user'])) { ?>
                        <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Distributed Control System</a></li>
                        <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Human Machine Interface</a></li>
                    <?php } else { ?>
                        <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Distributed Control System</a></li>
                        <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Human Machine Interface</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div data-role="collapsible" data-collapsed="true">
            <h4>General</h4>
            <ul data-role="listview">
                <?php if (!isset($_COOKIE['user'])) { ?>
                    <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Mechanical</a></li>
                    <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Electrical</a></li>
                    <li><a href="#popupDialogLogin" data-rel="popup" data-position-to="window" data-transition="pop">Instrumentation and Control</a></li>
                <?php } else { ?>
                    <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Mechanical</a></li>
                    <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Electrical</a></li>
                    <li><a href="#popupDialog" data-rel="popup" data-position-to="window" data-transition="pop">Instrumentation and Control</a></li>
                <?php } ?>
            </ul>
        </div>
        <a href="help.php" class="ui-btn">Help</a>
    </div>
    <?php include VIEW_COPYRIGHT ?>
</div>
<?php include VIEW_FOOTER ?>
