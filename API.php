<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagen = $_FILES['imagenInput']['tmp_name'];
    $cultivo = $_POST['cultivoSelect'];

    $api_url = 'https://api.plantix.net/v2/image_analysis';
    $datos = array(
        'image' => new CURLFile($imagen),
        'crop' => $cultivo
    );

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Agregar el encabezado de autenticación Bearer
    $token = '2b0080cfd58f564046a1104db36c9163091c2a07'; // Reemplaza '123' con tu token real
    $encabezados = array(
        'Accept: application/json'
        'Authorization: Bearer ' . $token,
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $encabezados);

    $respuesta = curl_exec($ch);
    curl_close($ch);

    $resultado = json_decode($respuesta, true);

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($resultado);
}
?>
