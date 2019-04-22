<?php
require_once '../header.php';
require 'event.php';

$events = GetEvents(null);
?>

<div class="container">

    <div class="col-md-12">
        <p>
            <a href="../index.php">Back to index</a>
        </p>
        <hr>
        <caption>
            <h4>EVENT LIST CRUD</h4>
        </caption>
        <?php if(!isset($events)) { ?>
            <div class="alert alert-danger">Error while trying to get data</div>
        <?php } else { ?>
            <table id="eventSample" class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Creator</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach($events as $event) { ?>
                    <tr>
                        <td>
                            <?php echo htmlentities($event->title); ?>
                        </td>
                        <td>
                            <?php echo htmlentities($event->creator) ?>
                        </td>
                        <td>
                            <a class="modal-partial" href="details.php?id=<?php echo $event->id; ?>">details</a>  <a class="modal-partial" href="edit.php?id=<?php echo $event->id; ?>">edit</a>  <a class="modal-partial" href="delete.php?id=<?php echo $event->id; ?>">delete</a>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
            <hr>
            <p>
                <a class="modal-partial" href="create.php">Create an event</a>
            </p>
        <?php } ?>
    </div>
</div>
<?php require_once '../footer.php'; ?>
