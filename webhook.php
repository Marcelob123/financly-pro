<?php
// Configurações de segurança
$secret_chave = "finance123"; // A mesma senha que você colocou no GitHub

// Lê o que o GitHub enviou
$post_data = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// Valida se a requisição veio mesmo do GitHub (Segurança)
if ($signature) {
    $hash = "sha256=" . hash_hmac('sha256', $post_data, $secret_chave);
    if (hash_equals($hash, $signature)) {
        // --- SUCESSO! ---
        // Aqui dentro você coloca o comando para atualizar seu site
        // Exemplo simples de log para teste:
        file_put_contents('log_sincronizacao.txt', "Sincronizado em: " . date('H:i:s') . "\n", FILE_APPEND);
        
        echo "Sincronização realizada com sucesso!";
        http_response_code(200);
    } else {
        echo "Assinatura inválida!";
        http_response_code(403);
    }
} else {
    echo "Aguardando dados do GitHub...";
}
?>
