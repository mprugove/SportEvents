<?php

declare(strict_types = 1);

namespace App\Model;

use Core\Data\Database;

class Event extends AbstractModel
 {
    protected static $tableName = 'events';

    public static function getEventSport($id)
    {
        $ssql = "SELECT s.id, s.sport, e.event, e.description FROM events e INNER JOIN sports s ON e.sport_id = s.id; WHERE e.id = $id ";
        
        $db = Database::getInstance();

        $stmt = $db->prepare($ssql);
        $stmt->execute();

        $models = [];
        while($row = $stmt->fetch())
        {
            $models[] = static::createObject($row);
        }
        return $models;
    }

    public static function addSportToEvent(string $sportId, string $eventId)
    {
        $ssql = "INSERT INTO event_sport(sport_id, event_id) VALUES ({$sportId}, {$eventId})";
        $db = Database::getInstance();

        $stmt = $db->prepare($ssql);
        $stmt->execute();
    }

    public static function addVenuetoEvent(string $venueId, string $eventId)
    {
        $ssql = "INSERT INTO event_venue(venue_id, event_id) VALUES ({$venueId}, {$eventId})";
        $db = Database::getInstance();
        
        $stmt = $db->prepare($ssql);
        $stmt->execute();
    }
}