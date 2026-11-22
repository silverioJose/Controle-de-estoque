# Controle de Despensa (PWA)

Aplicativo web em **PHP** com banco **MariaDB/MySQL** e suporte a **PWA** para acompanhar os itens da despensa e do estoque doméstico, comparando a quantidade atual com a quantidade mínima por departamento.

## Funcionalidades

- Cadastro, consulta e acompanhamento de produtos da despensa.
- Controle de **embalagem**, **unidade**, **quantidade atual**, **quantidade mínima** e **departamento** (ex.: Mercearia, Laticínios, Frios, Hortifruti, Bebidas).
- Lista/visão da despensa (`lista.php`) e suporte a instalação como Progressive Web App (`manifest.json` e `sw.js`).

## Estrutura do Projeto

- `index.php` — Página principal do aplicativo.
- `lista.php` — Visualização/lista de itens.
- `manifest.json` — Configuração do PWA (ícones, nome, modo de exibição).
- `sw.js` — Service Worker do PWA.
- `src/` — Camadas da aplicação (`controller`, `dao`, `database`, `model`, incluindo `ProdutoDAO.php`).
- `public/` — Arquivos estáticos (CSS, JS, ícones).

## Como Rodar Localmente

1. **Banco de dados:** Crie o banco e a tabela `produtos` no MariaDB/MySQL (com as colunas `id`, `nome`, `embalagem`, `unidade`, `quantidadeAtual`, `quantidadeMinima` e `departamento`).
2. **Configuração:** Ajuste as credenciais de conexão em `src/database/` (`Database.php`) com o host, nome do banco, usuário e senha.
3. **Servidor web:** Sirva a pasta do projeto em um ambiente com **PHP 8.2+** e Apache/Nginx (por exemplo, XAMPP/Laragon ou container Docker/CasaOS).
4. **Acesso:** Abra o endereço local no navegador (ex.: `http://localhost` ou o IP/porta do servidor).

> **Dica em sistemas Linux:** Atenção às letras maiúsculas e minúsculas nos nomes de arquivos ao fazer `include`/`require` (ex.: `ProdutoDAO.php`). Para instalação como PWA completo em dispositivos Android, prefira acesso via **HTTPS**.
## Instalar no Android

1. Sirva esta pasta por um servidor com PHP e o banco de dados configurado. Para instalar no Chrome do Android, acesse o site por **HTTPS**; `localhost` funciona para desenvolvimento no próprio aparelho.
2. Abra a tela principal no Chrome, aguarde carregar e escolha **Instalar app** ou **Adicionar à tela inicial** no menu.
3. O service worker mantém arquivos visuais e uma tela de aviso disponíveis sem rede. Estoque e lista ainda precisam do servidor PHP e do MySQL.

O PWA é instalado pelo navegador e não gera um APK. Um APK exigiria empacotar a aplicação num projeto Android separado.