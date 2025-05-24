<?php
    function updateStatus($id, $mysqli) {
        $stmt = $mysqli->prepare("SELECT status FROM users WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($user = $res->fetch_assoc()) {
            $_SESSION['status'] = $user['status'];
            return true;
        }

        return false;
    }

    

