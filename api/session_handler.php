<?php
// Database-based session handler for Vercel serverless PHP
// This ensures sessions persist across serverless function invocations

class DatabaseSessionHandler implements SessionHandlerInterface {
    private $conn;
    
    public function __construct($connection) {
        $this->conn = $connection;
        // Create sessions table if it doesn't exist
        $this->conn->query("
            CREATE TABLE IF NOT EXISTS sessions (
                id VARCHAR(128) PRIMARY KEY,
                data TEXT,
                last_activity INT UNSIGNED NOT NULL,
                INDEX(last_activity)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }
    
    public function open($save_path, $session_name): bool {
        return true;
    }
    
    public function close(): bool {
        return true;
    }
    
    #[\ReturnTypeWillChange]
    public function read($session_id) {
        $stmt = $this->conn->prepare("SELECT data FROM sessions WHERE id = ?");
        $stmt->bind_param("s", $session_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // Clean up old sessions (older than 24 hours)
            $this->gc(86400);
            return $row['data'];
        }
        
        return '';
    }
    
    public function write($session_id, $session_data): bool {
        $stmt = $this->conn->prepare("
            INSERT INTO sessions (id, data, last_activity) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE data = ?, last_activity = ?
        ");
        $time = time();
        $stmt->bind_param("ssisi", $session_id, $session_data, $time, $session_data, $time);
        return $stmt->execute();
    }
    
    public function destroy($session_id): bool {
        $stmt = $this->conn->prepare("DELETE FROM sessions WHERE id = ?");
        $stmt->bind_param("s", $session_id);
        return $stmt->execute();
    }
    
    #[\ReturnTypeWillChange]
    public function gc($maxlifetime) {
        $old = time() - $maxlifetime;
        $stmt = $this->conn->prepare("DELETE FROM sessions WHERE last_activity < ?");
        $stmt->bind_param("i", $old);
        if ($stmt->execute()) {
            return $stmt->affected_rows;
        }
        return false;
    }
}

