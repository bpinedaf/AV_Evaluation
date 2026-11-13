<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use POST.']);
    exit;
}

$token = getenv('PLANTIX_API_TOKEN');
$apiUrl = getenv('PLANTIX_API_URL') ?: 'https://api.plantix.net/v2/image_analysis';

if (!$token) {
    http_response_code(500);
    echo json_encode(['error' => 'PLANTIX_API_TOKEN is not configured on the server.']);
    exit;
}

if (
    !isset($_FILES['imagenInput']) ||
    $_FILES['imagenInput']['error'] !== UPLOAD_ERR_OK ||
    !isset($_POST['cultivoSelect'])
) {
    http_response_code(400);
    echo json_encode(['error' => 'An image and crop selection are required.']);
    exit;
}

$imagePath = $_FILES['imagenInput']['tmp_name'];
$crop = trim((string) $_POST['cultivoSelect']);

$payload = [
    'image' => new CURLFile($imagePath),
    'crop' => $crop,
];

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
    ],
]);

$response = curl_exec($ch);
$status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => 'Upstream API request failed.', 'detail' => $error]);
    exit;
}

http_response_code($status >= 200 && $status < 600 ? $status : 502);
echo $response;
