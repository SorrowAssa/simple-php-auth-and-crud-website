<?php
    session_start();
    require_once 'event.php';

    
    if (isset($_POST['delete_event_id'])) {
        $state = ['delete_event_result' => ""];

        // AntiForgery token check
        $tokencalc = hash_hmac('sha256', 'delete.php', $_SESSION['form_token']);
        if (hash_equals($tokencalc, $_POST['token'])) {

            // User must be logged
            if (!isset($_SESSION['username'])) {
                $state['delete_event_result'] = 'You must be logged to delete an event !';
            }

            if (empty($state['delete_event_result'])) {
                if(DeleteEvent(intval($_POST['delete_event_id']))) {
                    $state['_redirect'] = 'list.php';
                }
                else {
                    $state['delete_event_result'] = 'Error while trying to delete event';
                }
            }
        }
        else {
            // CSRF possible attack ! Log it
            $state['delete_event_result'] = 'nope ! you bad guy ! ;p';
        }

        // Return form validation state
        echo json_encode($state);
        exit();
    }
    else {
        if(!$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
            header("HTTP/1.0 400 Bad Request");
            exit;
        }
        
        if (!$event = GetEvent($id)) {
            header('HTTP/1.0 404 Not Found');
            exit;
        }
    }
?>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">DELETE EVENT ?</h4>
</div>
<div class="modal-login">
    <div class="modal-body">
    <div class="container col-xs-12">
        <div name="delete_event_result"></div>
        <dl class="dl-horizontal">
            <dt>Title</dt>
            <dd><?php echo htmlentities($event->title) ?></dd>
            <dt>Creator</dt>
            <dd><?php echo htmlentities($event->creator) ?></dd>
            <dt>Description</dt>
            <dd><?php echo htmlentities($event->description) ?></dd>
        </dl>
    </div>
    
    <form class="form-horizontal" action="delete.php" role="form" style="display: block;" method="post">

        <input type="hidden" name="token" value="<?php 
        if (empty($_SESSION['form_token'])) {
            $_SESSION['form_token'] = bin2hex(random_bytes(32));
        }
        echo hash_hmac('sha256', 'delete.php', $_SESSION['form_token']); 
        ?>" />

        <input type="hidden" name="delete_event_id" value="<?php echo $event->id; ?>" />

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" name="delete_event">Delete</button>
        </div>
    </form>
</div>

<script>
    PostForms();    // reload PostForms for modal
</script>