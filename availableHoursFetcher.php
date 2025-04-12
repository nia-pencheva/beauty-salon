<?php

include "config.php"; 

header('Content-Type: application/json');

$procedureId = $_GET['procedure_id'];
$date = $_GET['date'];

$stmt = $conn->prepare("SELECT duration_minutes FROM procedures WHERE id = ?");
$stmt->execute([$procedureId]);
$procedureDuration = $stmt->get_result()->fetch_assoc()["duration_minutes"];

$openingHour = 9;
$closingHour = 18;
$slotInterval = 15;

$conn->next_result();
$stmt = $conn->prepare("
                SELECT time, duration_minutes 
                FROM booked_procedures 
                LEFT JOIN procedures 
                ON booked_procedures.procedure_id = procedures.id 
                WHERE date = ?
            ");
$stmt->execute([$date]);
$bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$unavailable = [];
foreach($bookings as $booking) {
    $start = strtotime($date.$booking['time']);
    $end = $start + ($booking['duration_minutes'] * 60);
    $unavailable[] = ['start' => $start, 'end' => $end];
}

$slots = [];
$dayStart = strtotime("$date $openingHour:00:00");
$dayEnd = strtotime("$date $closingHour:00:00") - ($procedureDuration * 60);

for($time = $dayStart; $time <= $dayEnd; $time += $slotInterval * 60) {
    $slotStart = $time;
    $slotEnd = $slotStart + ($procedureDuration * 60);

    $conflict = false;
    foreach($unavailable as $block) {
        if($slotStart < $block['end'] && $slotEnd > $block['start']) {
            $conflict = true;
            break;
        }
    }

    $slots[] = [
        'time' => date('H:i', $slotStart),
        'available' => !$conflict
    ];
}

echo json_encode($slots);


