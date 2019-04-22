<?php    
    require_once 'header.php';
?>

<div class="container">
    <div class="row">
        
        <?php if (!isset($_SESSION['username'])) { ?>
            <p>
                Oh no ! You are not connected :'(
            </p>
            <button type="button" class="btn btn-info w100" data-dismiss="modal" onclick="$('#ModalSignup').modal('show');">LOGIN/REGISTER</button>
        <?php } else { ?>
            <p>
                Hello <?php echo htmlentities($_SESSION['username']) ?> !
            </p>
            <form method="post" action="account/logout.php" role="form" class="w100">
                <button type="submit" class="btn btn-danger w100" name="logout">DISCONNECT</button>
            </form>
        <?php } ?>
    </div>
    
    <hr>
    <div class="row">
        <p>
            <a href="event/list.php">CRUD event</a>
        </p>
    </div>

    <!-- NOTE: the partial modal was created after the initial modal (login/register) but we could use it here too -->
    <!-- Login/Register modal -->
    <div class="modal fade" id="ModalSignup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Login -->
                <div class="login">
                    <form class="form-horizontal" action="account/login.php" role="form" style="display: block;" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">LOGIN</h4>
                        </div>
                        <div class="modal-login">
                            <div class="modal-body">
                                <div name="login_result">


                                </div>
                                <div class="form-group">
                                    <label for="login_username">Username</label>
                                    <input type="text" class="form-control" name="login_username">
                                </div>
                                <div class="form-group">
                                    <label for="login_password">Password</label>
                                    <input type="password" class="form-control" name="login_password">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="login">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Register -->
                <div class="signup">
                    <form class="form-horizontal" action="account/register.php" method="post" autocomplete="off">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">REGISTER</h4>
                        </div>
                        <div class="modal-sign">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="register_username">Username</label>
                                    <input type="text" class="form-control" name="register_username">
                                </div>
                                <div class="form-group">
                                    <label for="register_password">Password</label>
                                    <input type="password" class="form-control" name="register_password">
                                </div>
                                <div class="form-group">
                                    <label for="register_confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" name="register_confirm_password">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="register">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ Login/Register modal -->
</div>

<?php require_once 'footer.php'; ?>