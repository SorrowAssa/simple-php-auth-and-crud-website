<?php
    session_start();
    require_once 'event.php';
    require_once '../includes/functions.php';

    if (isset($_POST['edit_event_title'])) {

        // AntiForgery token check
        $tokencalc = hash_hmac('sha256', 'edit.php', $_SESSION['form_token']);
        if (hash_equals($tokencalc, $_POST['token'])) {

            $edit_event_title = $edit_event_creator = $edit_event_description = "";

            $state = [
                "edit_event_title" => "",
                "edit_event_creator" => "",
                "edit_event_description" => ""
            ];

            // Validate creator
            if(!ValfNullOrEmpty($_POST["edit_event_creator"])){
                $state["edit_event_creator"] = "Creator must be defined, please login before editing an event.";
            }
            else {
                $edit_event_creator = trim($_POST["edit_event_creator"]);
            }

            // Validate title
            if(!ValfNullOrEmpty($_POST["edit_event_title"])){
                $state["edit_event_title"] = "Please enter a title.";     
            }
            else {
                $edit_event_title = trim($_POST["edit_event_title"]);
            }
            
            // Validate title
            if(!ValfNullOrEmpty($_POST["edit_event_description"])){
                $state["edit_event_description"] = "Please enter a description.";     
            }
            else {
                $edit_event_description = trim($_POST["edit_event_description"]);
            }

            // Check input errors
            if(empty($state["edit_event_creator"]) && empty($state["edit_event_title"]) && empty($state["edit_event_description"])){
                
                if (EditEvent(intval($_POST['edit_event_id']), $edit_event_title, $edit_event_creator, $edit_event_description)) {
                    $state['_redirect'] = 'list.php';
                }
                else {
                    $state["edit_event_result"] = 'Error while editing event';
                }
            }
        }
        else {
            // CSRF possible attack ! Log it
            $state["edit_event_result"] = 'nope ! you bad guy ! ;p';
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

<form class="form-horizontal" action="edit.php" role="form" style="display: block;" method="post">

    <input type="hidden" name="token" value="<?php 
    if (empty($_SESSION['form_token'])) {
        $_SESSION['form_token'] = bin2hex(random_bytes(32));
    }
    echo hash_hmac('sha256', 'edit.php', $_SESSION['form_token']); 
    ?>" />

    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">EDIT EVENT</h4>
    </div>
    <div class="modal-login">
        <div class="modal-body">
            <div name="edit_event_result"></div>
                
            <input type="hidden" name="edit_event_id" value="<?php echo $event->id; ?>" />

            <div class="form-group">
                <label>Creator *</label>
                <input type="text" class="form-control"  name="edit_event_creator" readonly="readonly" value="<?php echo $event->creator; ?>" />
            </div>
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" class="form-control" name="edit_event_title" value="<?php echo $event->title; ?>">
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="edit_event_description" class="form-control" rows="5"><?php echo $event->description; ?></textarea>
            </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" name="edit_event">Edit</button>
        </div>
    </div>
</form>

<script>
    PostForms();    // reload PostForms for modal
</script>