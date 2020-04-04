<!-- START: Top Menu -->
<style scoped="scoped">
.navbar .navbar-brand {
    font-weight: 900;
}

#ModalNavigationMenu ul {
    padding: 0px;
}

#ModalNavigationMenu li {
    padding: 0px;
}

#ModalNavigationMenu li a {
    display: block;
    padding: 10px;
    text-decoration: underline;
    color: blue;
}

#ModalNavigationMenu li a:hover {
    background: #FAF834;
}

#ModalNavigationMenu button.close {
    background: crimson;
    color: white;
    font-size: 18px;
    padding: 8px;
    border-radius: 40px;
    opacity: 1;
    width: 40px;
    height: 40px;
}

/* FULL SCREEN MODAL STYLES
-------------------------------------------------- */
.fullscreen .modal-dialog {
    margin: 0 0 0 0;
    width: 100%;
    min-width: 100%;
    height: 100%;
    min-height: 100%;
    padding: 0;
    color: #333;
}

.fullscreen .modal-content {
    height: 100%;
    min-height: 100%;
    border-radius: 0;
    color: #333;
    background: rgba(255, 255, 255, 0.97);
    overflow: auto;
}

.fullscreen .modal-body ul {
    padding: 100px 0 0 0;
}

.fullscreen .modal-body li {
    padding: 10px 0 10px 0;
}

.fullscreen .modal-body a {
    color: #333;
    font-size: 200%;
}

@media (max-width: 480px) {
    .fullscreen .modal-body ul {
        padding: 30px 0 0 0;
        overflow: auto;
    }

    .fullscreen .modal-body li {
        padding: 4px 0 4px 0;
    }

    .fullscreen .modal-body a {
        color: #333;
        font-size: 200%;
        text-transform: uppercase;
        font-weight: 700;
    }
}
</style>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <table style="width:100%">
            <tr>
                <td align="left" valign="middle" style="width:100px;">
                    <a class="navbar-brand" href="/" title="Home - PHP Serverless">
                        PHP Serverless
                    </a>
                </td>
                <td align="center" valign="middle">
                    &nbsp;
                </td>
                <td align="right" valign="middle" style="width:200px;">
                    <button class="btn btn-md btn-box-tool" style="color:#333;background: white;" data-toggle="modal"
                        data-target="#ModalNavigationMenu">
                        &#9776; menu
                    </button>
                    <a href="<?php echo \App\Helpers\Links::authPasswordlessUrl(); ?>" class="btn btn-md btn-box-tool"
                        style="color:#333;background: white;">
                        <img title="Logout" data-icon="ionicons ios-log-out"
                            style="width:16px;height:16px;color:red;" />
                        logout
                    </a>
                </td>
            </tr>
        </table>
        <!-- START: Modal Navigation Menu -->
        <div id="ModalNavigationMenu" class="modal fullscreen" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="display:block;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:0px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title text-left">Navigation</h4>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a class="nav-link" href="<?php echo \App\Helpers\Links::guestHome(); ?>">
                                    Home
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a class="nav-link" href="<?php echo \App\Helpers\Links::authPasswordlessUrl(); ?>">
                                    Login
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width:100%;">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Modal Navigation Menu -->
    </div>
</nav>
<!-- END: Top Menu -->