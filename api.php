<?php
// Configurações do Banco de Dados (Padrão TFS)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'aethrium_war'; // Substitua pelo nome do seu banco

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $action = $_GET['action'] ?? 'status';
    $response = [];

    if ($action == 'status') {
        // Exemplo: Buscar players online
        $stmt = $pdo->query("SELECT COUNT(*) as online FROM players WHERE online > 0");
        $response['online_players'] = $stmt->fetch(PDO::FETCH_ASSOC)['online'];
        
        // Exemplo: Score das Facções (Se você tiver uma tabela de factions ou usar storage)
        // Aqui estamos simulando, mas você pode adaptar para sua lógica de storage
        $response['factions'] = [
            ['name' => 'Antica', 'score' => 142, 'color' => '#d4af37'],
            ['name' => 'Amera', 'score' => 128, 'color' => '#8a0303']
        ];
    } 
    
    if ($action == 'top_fraggers') {
        // Buscar Top 5 Fraggers (Baseado na tabela de players do TFS)
        // Nota: Adapte o nome da coluna de frags se você usar um sistema customizado
        $stmt = $pdo->query("SELECT name, kills_count as frags FROM players ORDER BY kills_count DESC LIMIT 5");
        $response['top_fraggers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
?>
