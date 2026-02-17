<?php
include 'connect.php'; 


$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['complaint_id']) && isset($data['response'])) {
    $complaint_id = $data['complaint_id'];
    $response = $data['response'];
    $current_date = date('Y-m-d'); 

    try {
        
        $stmt = $conn->prepare("UPDATE Complaints 
                                SET ATR = :response, 
                                    status = 'Resolved', 
                                    date_resolved = :date_resolved 
                                WHERE complaint_id = :complaint_id");
        $stmt->bindParam(':response', $response);
        $stmt->bindParam(':date_resolved', $current_date);
        $stmt->bindParam(':complaint_id', $complaint_id);

       
        if ($stmt->execute()) {
            echo json_encode(["message" => "Complaint updated successfully!"]);
        } else {
            echo json_encode(["message" => "Failed to update the complaint."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
