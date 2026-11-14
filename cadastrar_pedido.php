
<?php
require_once "conexao.php";

$stmt = $pdo->query(
    "SELECT id, nome FROM clientes ORDER BY nome"
);
$clientes = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clienteId = filter_input(
        INPUT_POST,
        "cliente_id",
        FILTER_VALIDATE_INT
    );

    $valorInformado = trim($_POST["valor"] ?? "");

    // Aceita valores como 125.50 ou 125,50.
    $valorInformado = str_replace(",", ".", $valorInformado);

    if (
        $clienteId &&
        $clienteId > 0 &&
        is_numeric($valorInformado) &&
        (float)$valorInformado > 0
    ) {
        $valor = (float)$valorInformado;

        $sql = "INSERT INTO pedidos
                    (cliente_id, valor, data_pedido)
                VALUES
                    (:cliente_id, :valor, NOW())";

        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ":cliente_id" => $clienteId,
                ":valor" => $valor
            ]);

            header("Location: pedidos.php");
            exit;

        } catch (PDOException $e) {
            $erro = "Não foi possível cadastrar o pedido.";
        }
    } else {
        $erro = "Selecione um cliente e informe um valor válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar pedido</title>
</head>
<body>
    <h1>Novo pedido</h1>

    <?php if (isset($erro)): ?>
        <p><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="cliente_id">Cliente:</label>

        <select id="cliente_id" name="cliente_id" required>
            <option value="">Selecione um cliente</option>

            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente["id"] ?>">
                    <?= htmlspecialchars($cliente["nome"]) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <label for="valor">Valor do pedido:</label>
        <input
            type="number"
            id="valor"
            name="valor"
            min="0.01"
            step="0.01"
            required
        >

        <br><br>

        <button type="submit">Cadastrar pedido</button>
    </form>
</body>
</html>
