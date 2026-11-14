
<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nome !== "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "INSERT INTO clientes (nome, email, data_cadastro)
                VALUES (:nome, :email, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":nome" => $nome,
            ":email" => $email
        ]);

        header("Location: index.php?sucesso=1");
        exit;
    }

    $erro = "Informe um nome e um e-mail válido.";
}

$sql = "SELECT id, nome, email, data_cadastro
        FROM clientes
        ORDER BY id DESC";

$stmt = $pdo->query($sql);
$clientes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>
<body>
    <h1>Cadastrar cliente</h1>

    <?php if (isset($_GET["sucesso"])): ?>
        <p>Cliente cadastrado com sucesso!</p>
    <?php endif; ?>

    <?php if (isset($erro)): ?>
        <p><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nome:
            <input type="text" name="nome" required>
        </label>

        <br><br>

        <label>E-mail:
            <input type="email" name="email" required>
        </label>

        <br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <h2>Clientes cadastrados</h2>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Data de cadastro</th>
                <th>Editar</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= $cliente["id"] ?></td>
                    <td><?= htmlspecialchars($cliente["nome"]) ?></td>
                    <td><?= htmlspecialchars($cliente["email"]) ?></td>
                    <td><?= htmlspecialchars($cliente["data_cadastro"]) ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?= $cliente["id"] ?>">
                            Editar
                        </a>
                    </td>
                    <td>
                        <form action="excluir_cliente.php" method="POST"
                            onsubmit="return confirm('Deseja excluir este cliente?')">
                            <input
                                type="hidden"
                                name="id"
                                value="<?= $cliente["id"] ?>"
                            >
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
