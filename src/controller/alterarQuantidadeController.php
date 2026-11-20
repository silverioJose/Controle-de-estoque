<?php

require_once __DIR__ . '/../dao/ProdutoDAO.php';
require_once __DIR__ . '/../database/Database.php';

$id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

if ($id > 0 && ($acao === 'mais' || $acao === 'menos')) {
    $delta = $acao === 'mais' ? 1 : -1;
    $pdo = Database::getConexao();
    $pDAO = new ProdutoDAO($pdo);
    $pDAO->alterarQuantidade($id, $delta);
}

header('Location: ../../index.php');
exit;