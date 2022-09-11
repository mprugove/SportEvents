<?php

declare(strict_types = 1);

namespace App\Model;

use Core\Data\Database;

class Event extends AbstractModel
 {
    protected static $tableName = 'events';

    public static function getEventSport($id)
    {
        $ssql = "SELECT * FROM sports s
        INNER JOIN events e ON e.sport_id = s.id
        where e.id = $id";
        
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

    public static function getEventVenue($id)
    {
        $ssql = "SELECT * FROM venues v
        INNER JOIN events e ON e.venue_id = v.id
        where e.id = $id";
       
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

    public static function addVenueToEvent(string $venueId, string $eventId)
    {
        $ssql = "INSERT INTO event_venue(venue_id, event_id) VALUES ({$venueId}, {$eventId})";
        $db = Database::getInstance();
        
        $stmt = $db->prepare($ssql);
        $stmt->execute();
    }

    public static function addSportToEvent(string $sportId, string $eventId)
    {
        $ssql = "INSERT INTO event_sport(sport_id, event_id) VALUES ({$sportId}, {$eventId})";
        $db = Database::getInstance();

        $stmt = $db->prepare($ssql);
        $stmt->execute();   
    }
}