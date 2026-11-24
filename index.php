<?php

$uriAtual = $_SERVER['REQUEST_URI'] ?? '';

include __DIR__ . "/src/database/Database.php";
include __DIR__ . "/src/dao/ProdutoDAO.php";

$pdo = Database::getConexao();
$pDAO = new ProdutoDAO($pdo);

$produtos = $pDAO->listarTodos();

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
        <?php if (!empty($produtos)) : ?>
            <button type="button" id="btn-modo-exclusao" class="modo-exclusao-toggle"
                aria-pressed="false" aria-label="Selecionar produtos para excluir">Selecionar</button>
        <?php endif; ?>
    </header>

    <main>
        <?php if (empty($produtos)) : ?>
            <h3>Nenhum produto cadastrado</h3>
        <?php else : ?>
            <div class="lista-topo">
                <h3>Estoque de produtos</h3>
            </div>

            <form id="form-exclusao" action="src/controller/excluirProdutoController.php" method="POST">
                <?php foreach ($produtos as $p) : ?>
                    <?php $nomeProduto = $p->getNome() . ($p->getEmbalagem() !== '' ? ' · ' . $p->getEmbalagem() : ''); ?>
                    <div class="produto">
                        <label class="produto-selecao" aria-label="Selecionar <?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>">
                            <input class="checkbox-produto" type="checkbox" name="ids[]" value="<?= (int) $p->getId() ?>"
                                data-nome="<?= htmlspecialchars($nomeProduto, ENT_QUOTES, 'UTF-8') ?>">
                        </label>
                        <div class="produto-info">
                            <h3><?= htmlspecialchars($nomeProduto) ?></h3>
                            <h4 class="caption">Atual: <?= $p->getQuantidadeAtual() ?> - Min: <?= $p->getQuantidadeMinima() ?></h4>
                        </div>
                        <div class="produto-acoes">
                            <a href="src/controller/alterarQuantidadeController.php?id=<?= (int) $p->getId() ?>&acao=mais" class="adicionar">+</a>
                            <a href="src/controller/alterarQuantidadeController.php?id=<?= (int) $p->getId() ?>&acao=menos" class="remover">-</a>
                        </div>
                    </div>
                <?php endforeach ; ?>
            </form>
        <?php endif ; ?>
    </main>

    <footer class="footer">
        <div>
            <a href="index.php" 
                class="<?= str_contains($uriAtual, 'index.php') ? 'active' : '' ?>">ESTOQUE</a>
            <a href="lista.php"
                class="<?= str_contains($uriAtual, 'lista.php') ? 'active' : '' ?>">LISTA</a>
        </div>
        <a href="#" class="criar">+</a>
    </footer>

    <div id="barra-exclusao" class="barra-exclusao" aria-label="Ações de exclusão">
        <button type="button" id="cancelar-selecao" class="btn-secundario">Cancelar</button>
        <button type="submit" id="abrir-confirmacao-exclusao" class="btn-excluir" form="form-exclusao" disabled>Excluir</button>
    </div>

    <div id="modal-confirmar-exclusao" class="modal-backdrop" aria-hidden="true">
        <section class="modal-box" role="alertdialog" aria-modal="true" aria-labelledby="titulo-confirmar-exclusao">
            <div class="modal-header">
                <h3 id="titulo-confirmar-exclusao">Confirmar exclusão</h3>
                <button type="button" id="fechar-confirmacao-exclusao" class="modal-fechar" aria-label="Fechar">✕</button>
            </div>
            <p id="resumo-exclusao"></p>
            <ul id="itens-exclusao" class="itens-exclusao"></ul>
            <p class="aviso-exclusao">Essa ação não pode ser desfeita.</p>
            <div class="modal-acoes">
                <button type="button" id="cancelar-confirmacao-exclusao" class="btn-secundario">Voltar</button>
                <button type="button" id="confirmar-exclusao" class="btn-excluir">Excluir definitivamente</button>
            </div>
        </section>
    </div>

    <div id="modal-insert" class="modal-backdrop" aria-hidden="true">
        <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="titulo-modal">
            <div class="modal-header">
                <h3 id="titulo-modal">Novo Produto</h3>
                <button type="button" id="fechar-modal" class="modal-fechar" aria-label="Fechar">✕</button>
            </div>

            <form action="src/controller/salvarProdutoController.php" method="POST" class="form-produto">
                <div class="campo">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" placeholder="Ex: Farinha de Trigo" required>
                </div>

                <div class="linha-dupla">
                    <div class="campo">
                        <label for="embalagem">Embalagem</label>
                        <input type="text" id="embalagem" name="embalagem" placeholder="Ex: 800g, 1L">
                    </div>

                    <div class="campo">
                        <label for="unidade">Unidade</label>
                        <select id="unidade" name="unidade" required>
                            <option value="pct">pacote</option>
                            <option value="un">unidade</option>
                            <option value="cx">caixa</option>
                            <option value="gf">garrafa</option>
                        </select>
                    </div>
                </div>

                <div class="linha-dupla">
                    <div class="campo">
                        <label for="quantidadeAtual">Qtd. Atual</label>
                        <input type="number" id="quantidadeAtual" name="quantidadeAtual" min="0" value="0" required>
                    </div>

                    <div class="campo">
                        <label for="quantidadeMinima">Qtd. Mínima</label>
                        <input type="number" id="quantidadeMinima" name="quantidadeMinima" min="0" value="1" required>
                    </div>
                </div>

                <div class="campo">
                    <label for="departamento">Departamento</label>
                    <select id="departamento" name="departamento" required>
                        <option value="Mercearia">Mercearia</option>
                        <option value="Frios">Frios</option>
                        <option value="Hortifruti">Hortifruti</option>
                        <option value="Laticínios">Laticínios</option>
                        <option value="Bebidas">Bebidas</option>
                    </select>
                </div>

                <div class="modal-acoes">
                    <button type="button" id="cancelar-modal" class="btn-secundario">Cancelar</button>
                    <button type="submit" class="btn-primario">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="public/js/form.js"></script>
    <script src="public/js/excluir.js"></script>
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
