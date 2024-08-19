<?php
$redis = new Redis();

try {
    $redis->connect('redis', 6379);  // Substitua 'redis' pelo hostname do serviço Redis no docker-compose se for diferente
    echo "Conexão com Redis estabelecida com sucesso!";
} catch (Exception $e) {
    echo "Não foi possível se conectar ao Redis: ", $e->getMessage();
}
?>

