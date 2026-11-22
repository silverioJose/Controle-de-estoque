<?php

require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../dao/ProdutoDAO.php';
require_once __DIR__ . '/../database/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit;
}

$idsRecebidos = $_POST['ids'] ?? [];
$ids = [];

if (is_array($idsRecebidos)) {
    foreach ($idsRecebidos as $idRecebido) {
        if (!is_scalar($idRecebido)) {
            continue;
        }

        $id = filter_var($idRecebido, FILTER_VALIDATE_INT);
        if ($id !== false && $id > 0) {
            $ids[] = $id;
        }
    }
}

if ($ids === []) {
    header('Location: ../../index.php');
    exit;
}

$pdo = Database::getConexao();
$pDAO = new ProdutoDAO($pdo);
$pDAO->excluirVarios($ids);

header('Location: ../../index.php');
exit;
