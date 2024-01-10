<?php
// Obtener los datos del pedido desde la solicitud POST
$cliente = $_POST['cliente'];
$productosAgregados = $_POST['productos'];

// Generar el contenido del PDF (como se mostró en el ejemplo anterior)
$contenidoPDF = '<h1>Tu Pedido</h1>';
$contenidoPDF .= '<p>Cliente: ' . $cliente . '</p>';
$contenidoPDF .= '<table border="1">';
// ... Completa aquí la generación del contenido del PDF ...
$contenidoPDF .= '</table>';
$contenidoPDF .= '<p>Total Pedido: ' . $totalPedido . '</p>';

// Crear el archivo PDF
require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->writeHTML($contenidoPDF, true, false, true, false, '');
$nombreArchivoPDF = 'pedido.pdf';
$pdf->Output($nombreArchivoPDF, 'F');

// Enviar el PDF por correo electrónico
require_once('phpmailer/PHPMailerAutoload.php');
$correoDestino = 'ejemplo@hotmail.com';
$asuntoCorreo = 'Mi Pedido';
$mensajeCorreo = 'Adjunto se encuentra tu pedido.';
$nombreRemitente = 'Natural Mix';
$correoRemitente = 'ejemplo@hotmail.com';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.example.com';
$mail->SMTPAuth = true;
$mail->Username = 'tunegocio@example.com';
$mail->Password = 'contraseña';
$mail->Port = 587;

$mail->setFrom($correoRemitente, $nombreRemitente);
$mail->addAddress($correoDestino);
$mail->addAttachment($nombreArchivoPDF); // Adjuntar el PDF al correo
$mail->Subject = $asuntoCorreo;
$mail->Body = $mensajeCorreo;

if (!$mail->send()) {
    echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
} else {
    // Devolver la URL del PDF generado al cliente para usarla en el enlace de WhatsApp
    echo 'pedido.pdf';
}

// Eliminar el archivo PDF del servidor
unlink($nombreArchivoPDF);
?>
