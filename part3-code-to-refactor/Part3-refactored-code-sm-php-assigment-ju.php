<?php
function sanitize($field) {
    $cleanField = filter_var($field, FILTER_VALIDATE_EMAIL);

    if ($cleanField != $field){
        return false;
    }
    return $cleanField;
}

$masterEmail = $_REQUEST['email'] ?? $_REQUEST['masterEmail'] ?? 'unknown';

echo 'The master email is ' . $masterEmail . '\n';

$validEmail = sanitize($masterEmail);

if ($validEmail) {

    $conn = mysqli_connect('localhost', 'root', 'sldjfpoweifns', 'my_database');

    if ($conn) {
        $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $validEmail);

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo $row['username'] . "\n";
        }
    }
}
