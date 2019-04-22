<?php
    session_start();
    require_once 'event.php';
    require_once '../includes/functions.php';

    if (isset($_POST['create_event_title'])) {

        // AntiForgery token check
        $tokencalc = hash_hmac('sha256', 'create.php', $_SESSION['form_token']);
        if (hash_equals($tokencalc, $_POST['token'])) {

            $create_event_title = $create_event_creator = $create_event_description = "";

            $state = [
                "create_event_title" => "",
                "create_event_creator" => "",
                "create_event_description" => ""
            ];

            // Validate creator
            if(!ValfNullOrEmpty($_POST["create_event_creator"])){
                $state["create_event_creator"] = "Creator must be defined, please login before creating an event.";
            }
            else {
                $create_event_creator = trim($_POST["create_event_creator"]);
            }

            // Validate title
            if(!ValfNullOrEmpty($_POST["create_event_title"])){
                $state["create_event_title"] = "Please enter a title.";     
            }
            else {
                $create_event_title = trim($_POST["create_event_title"]);
            }
            
            // Validate title
            if(!ValfNullOrEmpty($_POST["create_event_description"])){
                $state["create_event_description"] = "Please enter a description.";     
            }
            else {
                $create_event_description = trim($_POST["create_event_description"]);
            }

            // Check input errors
            if(empty($state["create_event_creator"]) && empty($state["create_event_title"]) && empty($state["create_event_description"])){
                
                if (CreateEvent($create_event_title, $create_event_creator, $create_event_description)) {
                    $state['_redirect'] = 'list.php';
                }
                else {
                    $state["create_event_result"] = 'Error while creating event';
                }
            }
        }
        else {
            // CSRF possible attack ! Log it
            $state["create_event_result"] = 'nope ! you bad guy ! ;p';
        }
        // Return form validation state
        echo json_encode($state);
        exit();
    }
    
?>

<form class="form-horizontal" action="create.php" role="form" style="display: block;" method="post">

    <input type="hidden" name="token" value="<?php 
    if (empty($_SESSION['form_token'])) {
        $_SESSION['form_token'] = bin2hex(random_bytes(32));
    }
    echo hash_hmac('sha256', 'create.php', $_SESSION['form_token']); 
    ?>" />

    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">CREATE EVENT</h4>
    </div>
    <div class="modal-login">
        <div class="modal-body">
            <div name="create_event_result"></div>
            <div class="form-group">
                <label>Creator *</label>
                <input type="text" class="form-control"  name="create_event_creator" readonly="readonly" value="<?php if (isset($_SESSION['username'])) { echo htmlentities($_SESSION['username']); } ?>" />
            </div>
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" class="form-control" name="create_event_title">
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="create_event_description" class="form-control" rows="5"></textarea>
            </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" name="create_event">Create</button>
        </div>
    </div>
</form>

<script>
    PostForms();    // reload PostForms for modal
</script>