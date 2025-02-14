<?php
class UserProfile {
    private $conn;
    private $id;
    private $name;
    private $position;
    private $email;
    private $phone;
    private $location;
    private $division;

    public function __construct($conn, $userId) {
        $this->conn = $conn;
        $this->id = $userId; // Assuming user ID is passed during construction
    }

    // Getter and Setter for id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter and Setter for name
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    // Getter and Setter for position
    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    // Getter and Setter for email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    // Getter and Setter for phone
    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    // Getter and Setter for location
    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    // Getter and Setter for division
    public function getDivision() {
        return $this->division;
    }

    public function setDivision($division) {
        $this->division = $division;
    }

    // Fetch user data from database
    public function fetchUserData() {
        $stmt = $this->conn->prepare("SELECT * FROM user_profiles WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $this->id]);
        $userData = $stmt->fetch();

        // Populate object properties with fetched data
        if ($userData) {
            $this->name = $userData['name'];
            $this->position = $userData['position'];
            $this->email = $userData['email'];
            $this->phone = $userData['phone'];
            $this->location = $userData['location'];
            $this->division = $userData['division'];
        }

        return $userData; // Return fetched data
    }

    // Update user data in the database
    public function updateUserData() {
        $query = "UPDATE user_profiles SET name = :name, position = :position, email = :email, phone = :phone, location = :location, division = :division WHERE user_id = :user_id";
        $params = [
            'name' => $this->name,
            'position' => $this->position,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'division' => $this->division,
            'user_id' => $this->id
        ];

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }

    // Handle profile picture upload
    public function uploadProfilePicture($file) {
        // Implement your file upload logic here
    }
}
?>
