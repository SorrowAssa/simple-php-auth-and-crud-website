<?php

require_once '../includes/config.php';

class Event {
    public $id;
    public $title;
    public $creator;
    public $description;
}

/**
 * Get an event by Id
 *
 * @param integer $id    Id of the event
 * @return Event or null if error
 */
function GetEvent(int $id) {
    $event = GetEvents($id);
    return !$event ? $event : $event[0];
}

/**
 * Delete an event
 *
 * @param integer $id   Event id to delete
 * @return bool         True id deleted
 */
function DeleteEvent(int $id) {
    global $bdd;
    $query = $bdd->prepare('DELETE FROM  `events` WHERE `id` = :id');
    $query->bindValue(':id', intval($id), PDO::PARAM_INT);
    return $query->execute([
        'id' => $id,
    ]);
}

/**
 * Edit an event (no validation of the params, must be done before)
 *
 * @param string $id            Id of the event
 * @param string $title         Title of the event
 * @param string $creator       Creator of the event
 * @param string $description   Description of the event
 * @return Result               True if success
 */
function EditEvent(int $id, string $title, string $creator, string $description):bool {
    global $bdd;
    $query = $bdd->prepare('UPDATE `events` SET `title` = :title, `creator` = :creator, `description` = :description WHERE `id` = :id');
    $query->bindValue(':id', intval($id), PDO::PARAM_INT);
    $query->bindValue(':title', $title);
    $query->bindValue(':creator', $creator);
    $query->bindValue(':description', $description);
    return $query->execute();
}

/**
 * Get list of events
 *
 * @return Event[] or null if error
 */
function GetEvents($id) { // TODO optional params for filter by creator...
    try {
        global $bdd;
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        $sql = isset($id) ? 'SELECT * FROM events WHERE id = :id' : 'SELECT * FROM events';
        $query = $bdd->prepare($sql);
        if (isset($id)) {
            $query->bindValue(':id', intval($id), PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_CLASS, 'Event');
        }
        else {
            $query->execute();
            $events = $query->fetchAll(PDO::FETCH_CLASS, 'Event');
        }
        return $events;
    } catch (PDOException $e) {
        // $error = $e->getMessage();
        return null;
    }
}

/**
 * Create an event in db (no validation of the params, must be done before)
 *
 * @param string $title         Title of the event
 * @param string $creator       Creator of the event
 * @param string $description   Description of the event
 * @return Result               True if success
 */
function CreateEvent(string $title, string $creator, string $description):bool {
    global $bdd;
    $query = $bdd->prepare('INSERT INTO `events` (`title`, `creator`, `description`) VALUES (:title, :creator, :description)');
    return $query->execute([
        'title' => $title,
        'creator' => $creator,
        'description' => $description
    ]);
}