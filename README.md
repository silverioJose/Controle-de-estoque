# Controle de Despensa

Aplicação web para organizar os produtos da despensa, acompanhar o estoque mínimo e montar uma lista de compras. O projeto usa **PHP**, **MySQL** e pode ser instalado no Android como **PWA** pelo navegador.

<p align="center">
  <a href="https://oficinahotrods.com.br/15565/Mobile/">
    <img src="https://img.shields.io/badge/ACESSAR%20O%20PROJETO-ff8c42?style=for-the-badge" alt="Acessar o projeto">
  </a>
</p>

## O que o aplicativo faz

- Cadastra produtos com embalagem, unidade, quantidade atual, quantidade mínima e departamento.
- Exibe o estoque e permite aumentar ou diminuir a quantidade de cada produto.
- Monta uma lista com os produtos abaixo do estoque mínimo e a quantidade que falta comprar.
- Copia a lista de compras para a área de transferência.
- Pode ser instalado no Android pelo Chrome como um aplicativo PWA.
- Mantém os arquivos visuais disponíveis em cache e mostra uma página informativa se a conexão cair.

**Os dados do estoque não funcionam offline:** cadastro, consulta e alteração dependem do servidor PHP e do banco MySQL.

## Estrutura do projeto

| Caminho | Descrição |
| --- | --- |
| `index.php` | Tela do estoque e formulário para cadastrar produtos. |
| `lista.php` | Lista de compras para itens abaixo da quantidade mínima. |
| `manifest.json` | Nome, ícones, tela inicial e modo de exibição do PWA. |
| `sw.js` | Service worker, cache dos arquivos estáticos e alternativa offline. |
| `offline.html` | Página mostrada quando o servidor não pode ser acessado. |
| `src/controller/` | Ações para cadastrar, excluir e alterar quantidades. |
| `src/dao/` | Consultas e operações do banco de dados. |
| `src/database/` | Conexão PDO com MySQL. |
| `src/model/` | Modelo de dados do produto. |
| `public/css/` | Estilos das telas. |
| `public/js/` | Comportamentos do formulário e da lista de compras. |
| `public/img/` | Ícones usados pelo PWA. |

## Requisitos

- PHP 8.2 ou superior com PDO e o driver `pdo_mysql` habilitados.
- MySQL.
- Apache ou outro servidor web configurado para executar PHP. XAMPP e Laragon são opções para desenvolvimento local.
- Chrome no Android e endereço HTTPS para instalar o PWA em um aparelho. `localhost` é uma exceção segura para desenvolvimento no próprio dispositivo.

## Rodar localmente com XAMPP

1. Coloque a pasta do projeto dentro de `C:\xampp\htdocs\Mobile`.
2. Inicie **Apache** e **MySQL** no painel do XAMPP.
3. No phpMyAdmin, crie o banco `controle_estoque` e a tabela abaixo:

```sql
CREATE DATABASE IF NOT EXISTS controle_estoque
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE controle_estoque;

CREATE TABLE IF NOT EXISTS produtos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  embalagem VARCHAR(60) NOT NULL DEFAULT '',
  unidade VARCHAR(30) NOT NULL,
  quantidadeAtual INT UNSIGNED NOT NULL DEFAULT 0,
  quantidadeMinima INT UNSIGNED NOT NULL DEFAULT 0,
  departamento VARCHAR(80) NOT NULL
);