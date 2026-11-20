<?php

require_once __DIR__ . '/../model/Produto.php';

class ProdutoDAO {
    private PDO $pdo;
    //Recebe e guarda a conexão com banco, assim permitindo que 
    //todos metodos da classe reutilizarem a mesma conexao PDO
    public function __construct($pdo) {
        //Pega conexao do arquivo de conexao e guarda na variavel local
        $this->pdo = $pdo;
    }

    public function getParametros(Produto $produto): array {
        return [
            ':nome' => $produto->getNome(),
            ':embalagem' => $produto->getEmbalagem(),
            ':unidade' => $produto->getUnidade(),
            ':quantidadeAtual' => $produto->getQuantidadeAtual(),
            ':quantidadeMinima' => $produto->getQuantidadeMinima(),
            ':departamento' => $produto->getDepartamento()
        ];
    }

    public function listarTodos(): array {
        $sql = "SELECT * FROM produtos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $linhas = $stmt->fetchAll();
        $produtos = [];

        foreach($linhas as $linha) {
            $produtos[] = Produto::fromArray($linha);
        }
        return $produtos;
    }

    public function inserir(Produto $produto): bool {
        $sql = "INSERT INTO produtos (
                nome, embalagem, unidade, quantidadeAtual, quantidadeMinima, departamento
            ) VALUES ( 
                :nome, :embalagem, :unidade, :quantidadeAtual, :quantidadeMinima, :departamento
            )";

            $stmt = $this->pdo->prepare($sql);

            $sucesso = $stmt->execute($this->getParametros($produto));

            if($sucesso) {
                $produto->setId((int) $this->pdo->lastInsertId());
            }

            return $sucesso;
    }

    public function excluir($id): bool {
        $sql = "DELETE FROM produtos WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function alterarQuantidade(int $id, int $delta): bool {
        $sql = "UPDATE produtos SET quantidadeAtual = GREATEST(0, quantidadeAtual + :delta) WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':delta' => $delta,
            ':id' =>$id,
        ]);
    }

    public function listarAbaixoDoMinimo(): array {
    $sql = "SELECT * FROM produtos
            WHERE quantidadeAtual < quantidadeMinima
            ORDER BY nome ASC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $produtos = [];

    foreach ($linhas as $linha) {
        $produtos[] = Produto::fromArray($linha);
    }

    return $produtos;
}
}

?>