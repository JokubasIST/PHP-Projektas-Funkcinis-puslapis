<?php
class Post {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createPost($userId, $title, $content, $ipAddress) {
        $stmt = $this->db->prepare("INSERT INTO posts (user_id, title, content, ip_address) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $title, $content, $ipAddress]);
    }

    public function getAllPosts() {
        $stmt = $this->db->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
        return $stmt->fetchAll();
    }

    public function deletePost($postId, $userId) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
        return $stmt->execute([$postId, $userId]);
    }

    public function getPostById($postId) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetch();
    }
}
?>