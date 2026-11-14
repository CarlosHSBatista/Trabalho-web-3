
<?php
require_once "conexao.php";

$sql = "SELECT
            pedidos.id,
            clientes.nome AS nome_cliente,
            pedidos.valor,
            pedidos.data_pedido
        FROM pedidos
        INNER JOIN clientes
            ON pedidos.cliente_id = clientes.id
        ORDER BY pedidos.id DESC";

$stmt = $pdo->query($sql);
$pedidos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
</head>
<body>
    <h1>Pedidos cadastrados</h1>
    <p>
        <a href="cadastrar_pedido.php">Cadastrar novo pedido</a>
    </p>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID do pedido</th>
                <th>Cliente</th>
                <th>Valor</th>
                <th>Data do pedido</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido["id"] ?></td>
                    <td><?= htmlspecialchars($pedido["nome_cliente"]) ?></td>
                    <td>
                        <?= number_format(
                            (float)$pedido["valor"],
                            2,
                            ",",
                            "."
                        ) ?>
                    </td>
                    <td><?= htmlspecialchars($pedido["data_pedido"]) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
