<?php
class Events {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch events for FullCalendar
    public function displayData() {
        $stmt = $this->conn->prepare("SELECT * FROM events");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch events for the table
    public function displayDataForTable() {
        return $this->displayData();
    }

    // Store new event data
    public function storeData($data) {
        $stmt = $this->conn->prepare("INSERT INTO events (title, description, start, end) VALUES (:title, :description, :start, :end)");
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':start', $data['start_date']);
        $stmt->bindParam(':end', $data['end_date']);
        return $stmt->execute();
    }

    // Delete an event
    public function deleteEvent($id) {
        $stmt = $this->conn->prepare("DELETE FROM events WHERE event_id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
