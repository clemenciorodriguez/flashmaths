<?php
header('Content-Type: application/json');

// Recibe el JSON enviado desde JavaScript
$inputData = json_decode(file_get_contents('php://input'), true);

// Verifica si se recibió el input correctamente
if (isset($inputData['anverso']) && isset($inputData['reverso']) && isset($inputData['feedback'])) {
    // Cargar los datos existentes
    $file = 'feedback.json';
    if (file_exists($file)) {
        $existingData = json_decode(file_get_contents($file), true);
    } else {
        $existingData = [];
    }

    // Agregar la nueva entrada
    $existingData[] = [
        'anverso' => $inputData['anverso'],
        'reverso' => $inputData['reverso'],
        'feedback' => $inputData['feedback'],
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Guardar el nuevo contenido en el archivo JSON
    file_put_contents($file, json_encode($existingData, JSON_PRETTY_PRINT));

    // Responder con éxito
    echo json_encode(['status' => 'success']);
} else {
    // Responder con error
    echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
}

