<?php

require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../dao/ProdutoDAO.php';
require_once __DIR__ . '/../database/Database.php';

$pdo = Database::getConexao();

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id) {
    header('Location: ../../index.php');
    exit;
}

$pDAO = new ProdutoDAO($pdo);

$pDAO->excluir((int) $id);

header('Location: ../../index.php');
exit;