<?php

require_once __DIR__ . '/../model/Produto.php';
require_once __DIR__ . '/../dao/ProdutoDAO.php';
require_once __DIR__ . '/../database/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$embalagem = trim($_POST['embalagem'] ?? '');
$unidade = trim($_POST['unidade'] ?? 'un');
$quantidadeAtual = max(0, (int) ($_POST['quantidadeAtual'] ?? 0));
$quantidadeMinima = max(0, (int) ($_POST['quantidadeMinima'] ?? 0));
$departamento = trim($_POST['departamento'] ?? 'Mercearia');

if ($nome === '') {
    header('Location: ../../index.php?erro=nome');
    exit;
}

$produto = new Produto(
    null,
    $nome,
    $embalagem,
    $unidade,
    $quantidadeAtual,
    $quantidadeMinima,
    $departamento
);

$pdo = Database::getConexao();
$pDAO = new ProdutoDAO($pdo);
$pDAO->inserir($produto);

header('Location: ../../index.php');
exit;