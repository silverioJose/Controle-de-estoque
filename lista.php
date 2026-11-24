<?php

$uriAtual = $_SERVER['REQUEST_URI'] ?? '';

include __DIR__ . "/src/database/Database.php";
include __DIR__ . "/src/dao/ProdutoDAO.php";

$pdo = Database::getConexao();
$pDAO = new ProdutoDAO($pdo);

$produtos = $pDAO->listarAbaixoDoMinimo();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despensa</title>
    <link rel="stylesheet" href="public/css/main.css">

    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="public/img/icon-192.png" type="image/png">
    <link rel="apple-touch-icon" href="public/img/icon-192.png">
    <meta name="theme-color" content="#ffbe88">
</head>
<body>
    <header class="header">
        <h2>Despensa</h2>
        <a></a>
    </header>

    <main>
        <section class="lista-compras">
            <div class="lista-topo">
                <h3>Lista de Compras</h3>
                <button type="button" id="btn-copiar-lista">Copiar</button>
            </div>

            <?php if (empty($produtos)) : ?>
                <p>Nenhum item abaixo do estoque mínimo.</p>
            <?php else : ?>
                <div id="texto-lista">
                    <?php
                    $produtosPorDepartamento = [];

                    foreach ($produtos as $produto) {
                        $departamento = trim($produto->getDepartamento()) ?: 'Outros';
                        $produtosPorDepartamento[$departamento][] = $produto;
                    }
                    ?>

                    <?php foreach ($produtosPorDepartamento as $departamento => $itens) : ?>
                        <section class="grupo-departamento">
                            <h4 class="departamento"><?= htmlspecialchars($departamento, ENT_QUOTES, 'UTF-8') ?></h4>

                            <ul class="lista-itens">
                                <?php foreach ($itens as $p) : ?>
                                    <?php
                                    $falta = max(
                                        1,
                                        (int) $p->getQuantidadeMinima() - (int) $p->getQuantidadeAtual()
                                    );
                                    ?>

                                    <li>
                                        <?= htmlspecialchars($p->getNome()) ?>
                                        ·
                                        <?= htmlspecialchars($p->getEmbalagem()) ?>
                                        <span>
                                            Comprar: +<?= $falta ?>
                                            <?= htmlspecialchars($p->getUnidade()) ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </section>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer class="footer">
        <div>
            <a href="index.php" 
                class="<?= str_contains($uriAtual, 'index.php') ? 'active' : '' ?>">ESTOQUE</a>
            <a href="lista.php"
                class="<?= str_contains($uriAtual, 'lista.php') ? 'active' : '' ?>">LISTA</a>
        </div>
    </footer>

    <script src="public/js/copiar.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw.js').catch((err) => {
                console.error('Erro ao registrar Service Worker:', err);
            });
            });
        }
    </script>
    </body>
</html>
