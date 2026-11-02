<?php
// Demo contact endpoint. Configure CONTACT_RECIPIENT on the server before use.
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');

function respond($status, $message, $field = null) {
    http_response_code($status);
    $result = array('response' => $status === 200 ? 'success' : 'error', 'message' => $message);
    if ($field !== null) {
        $result['empty'] = $field;
    }
    echo json_encode($result);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    respond(405, 'Only POST requests are supported.');
}

$recipient = getenv('CONTACT_RECIPIENT');
if (!$recipient || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
    respond(503, 'Contact form is not configured.');
}

$fields = array();
foreach (array('name', 'email', 'subject', 'phone', 'message') as $field) {
    $value = isset($_POST[$field]) && is_string($_POST[$field]) ? trim($_POST[$field]) : '';
    if (strlen($value) > 5000) {
        respond(400, 'Input is too long.');
    }
    $fields[$field] = $value;
}

foreach (array('name', 'email', 'message') as $required) {
    if ($fields[$required] === '') {
        respond(400, 'Please provide ' . $required . '.', $required);
    }
}
if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL) || preg_match('/[\r\n]/', $fields['email'])) {
    respond(400, 'Please provide a valid email address.');
}

$subject = preg_replace('/[\r\n]+/', ' ', $fields['subject']);
$subject = $subject !== '' ? $subject : 'Website contact form';
$templatePath = __DIR__ . '/email-templates/simple.html';
$template = is_file($templatePath) ? file_get_contents($templatePath) : false;
if ($template === false) {
    respond(503, 'Contact form template is unavailable.');
}

$tags = array();
foreach ($fields as $field => $value) {
    $safe = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $tags['{{' . $field . '}}'] = $field === 'message' ? nl2br($safe) : $safe;
}
$body = strtr($template, $tags);
$headers = "Reply-To: " . $fields['email'] . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if (!mail($recipient, $subject, $body, $headers)) {
    respond(503, 'Unable to send your message right now.');
}
respond(200, 'Thank you! Your message has been sent.');
