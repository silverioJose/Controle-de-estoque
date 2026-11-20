<?php

class Produto {
    public ?int $id;
    public string $nome;
    public string $embalagem; // 800g, 1L, 500ml
    public string $unidade; // pct, un, cx
    public int $quantidadeAtual;
    public int $quantidadeMinima;
    public string $departamento;

    public function __construct(
        ?int $id = null,
        string $nome = '',
        string $embalagem = '',
        string $unidade = '',
        int $quantidadeAtual = 0,
        int $quantidadeMinima = 0,
        string $departamento = ''
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->embalagem = $embalagem;
        $this->unidade = $unidade;
        $this->quantidadeAtual = $quantidadeAtual;
        $this->quantidadeMinima = $quantidadeMinima;
        $this->departamento = $departamento;
    }
    public static function fromArray(array $dados): self {
        $p = new self();
        $p->id = $dados['id'] ?? null;
        $p->nome = $dados['nome'] ?? '';
        $p->embalagem = $dados['embalagem'] ?? '';
        $p->unidade = $dados['unidade'] ?? '';
        $p->quantidadeAtual = $dados['quantidadeAtual'] ?? 0;
        $p->quantidadeMinima = $dados['quantidadeMinima'] ?? 0;
        $p->departamento = $dados['departamento'] ?? '';

        return $p;
    }

    public function getId() : int {
        return $this->id;
    }

    public function setId(?int $id) : void {
        $this->id = $id;
    }

    public function getNome() : string {
        return $this->nome;
    }

    public function getEmbalagem() : string {
        return $this->embalagem;
    }

    public function getUnidade() : string {
        return $this->unidade;
    }

    public function getQuantidadeAtual() : int{
        return $this->quantidadeAtual;
    }

    public function getQuantidadeMinima() : int {
        return $this->quantidadeMinima;
    }

    public function getDepartamento() : string {
        return $this->departamento;
    }
}

?>