<?php
class LoginLog {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function log($username, $success, $ipAddress) {
        $stmt = $this->db->prepare("INSERT INTO login_logs (username, success, ip_address) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $success, $ipAddress]);
    }
}
?>