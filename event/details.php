<?php
    session_start();
    require_once 'event.php';

    if(!$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
        header("HTTP/1.0 400 Bad Request");
        exit;
    }
    
    if (!$event = GetEvent($id)) {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
?>

<div class="modal-header">
    <h4 class="modal-title" id="myModalLabel">EVENT DETAILS</h4>
</div>
<div class="modal-login">
    <div class="modal-body">
    <div class="container col-xs-12">
        <dl class="dl-horizontal">
            <dt>Title</dt>
            <dd><?php echo htmlentities($event->title) ?></dd>
            <dt>Creator</dt>
            <dd><?php echo htmlentities($event->creator) ?></dd>
            <dt>Description</dt>
            <dd><?php echo htmlentities($event->description) ?></dd>
        </dl>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <a href="edit.php?id=<?php echo $event->id; ?>" class="btn btn-success modal-partial">Edit</a>
    </div>
</div>
        
<script>
    ModalPartial();    // reload PostForms for modal
</script>