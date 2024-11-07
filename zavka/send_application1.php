<?php
// айди адм
$chat_ids = [
    '6218262975',
    '7306595049',
];

// Функция для отправки сообщения всем пользователям
function sendMessageToAll($message) {
    global $chat_ids;
    $token = '7644567522:AAFW5Mjp_18bh4jG3IzS1Nrqzb5UYPBri04'; // Ваш токен бота

    foreach ($chat_ids as $chat_id) {
        // URL для отправки сообщения
        $url = "https://api.telegram.org/bot$token/sendMessage";

        // Параметры для отправки
        $data = [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML' // Опционально, для форматирования текста
        ];

        // Инициализируем cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Проверяем ответ от API
        $response_data = json_decode($response, true);
        if (!$response_data['ok']) {
            echo "Ошибка при отправке сообщения пользователю с chat_id $chat_id: " . $response_data['description'] . "<br>";
        }
    }
}

// Обработка POST-запроса для отправки сообщения
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $age = htmlspecialchars($_POST['age']);
    $contact = htmlspecialchars($_POST['contact']);
    $position = htmlspecialchars($_POST['position']);
    $about = htmlspecialchars($_POST['about']);

    // Формируем сообщение для отправки в Telegram
    $message = "Новая заявка на должность: {$position}! 📺\n";
    $message .= "Имя кандидата: {$name}. 👤\n";
    $message .= "Возраст: {$age}. ⏳\n";
    $message .= "Контакт: {$contact}. 📱\n";
    $message .= "Должность: {$position}. 💼\n";
    $message .= "Информация о себе: {$about}. ✍️\n";

    // Отправляем сообщение всем пользователям
    sendMessageToAll($message);
    echo "Заявка успешно отправлена!";
} else {
    echo "Метод запроса не поддерживается.";
}
?>
