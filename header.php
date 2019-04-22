<?php 
    require_once 'includes/config.php';
    session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Sign-Up/Login Form</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="<?php echo $baseurl; ?>js/site.js"></script>
        <style>
            body>.container {
                padding-top: 3em;
            }
            .w100 {
                width: 100%;
            }
        </style>
    </head>

<body>
    <!-- Partial modal -->
    <div id="modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div id="modalLoader" class="modal-content" style="display: none;">
                <div class="modal-body text-center">
                    <p>
                        Loading...
                    </p>
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <div id="modalError" class="modal-content" style="display: none;">
                <div class="modal-body text-center">
                    <p>
                        An error occurred while trying to get data, try later...
                    </p>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <input type="submit" name="Annuler" value="Annuler" class="btn y-btn-gray display-notajax" data-dismiss="modal"/>
                </div>
            </div>
            <div class="modal-content" id="modalContent">
            </div>
        </div>
    </div>
    <!-- ./ Partial modal -->