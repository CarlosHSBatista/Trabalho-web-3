
<?php
require_once "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Identificador inválido.");
}

$stmt = $pdo->prepare(
    "SELECT id, nome, email FROM clientes WHERE id = :id"
);
$stmt->execute([":id" => $id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    exit("Cliente não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nome !== "" &&
        filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $sql = "UPDATE clientes
                SET nome = :nome, email = :email
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":nome" => $nome,
            ":email" => $email,
            ":id" => $id
        ]);

        header("Location: index.php");
        exit;
    }

    $erro = "Informe um nome e um e-mail válido.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar cliente</title>
</head>
<body>
    <h1>Editar cliente</h1>

    <?php if (isset($erro)): ?>
        <p><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nome:
            <input
                type="text"
                name="nome"
                value="<?= htmlspecialchars(
                    $_POST["nome"] ?? $cliente["nome"]
                ) ?>"
                required
            >
        </label>

        <br><br>

        <label>E-mail:
            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars(
                    $_POST["email"] ?? $cliente["email"]
                ) ?>"
                required
            >
        </label>

        <br><br>

        <button type="submit">Salvar alterações</button>
    </form>
</body>
</html>
