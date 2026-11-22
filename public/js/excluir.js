const btnModoExclusao = document.getElementById('btn-modo-exclusao');
const barraExclusao = document.getElementById('barra-exclusao');
const btnCancelarSelecao = document.getElementById('cancelar-selecao');
const btnAbrirConfirmacao = document.getElementById('abrir-confirmacao-exclusao');
const formExclusao = document.getElementById('form-exclusao');
const modalExclusao = document.getElementById('modal-confirmar-exclusao');
const resumoExclusao = document.getElementById('resumo-exclusao');
const itensExclusao = document.getElementById('itens-exclusao');
const btnFecharConfirmacao = document.getElementById('fechar-confirmacao-exclusao');
const btnCancelarConfirmacao = document.getElementById('cancelar-confirmacao-exclusao');
const btnConfirmarExclusao = document.getElementById('confirmar-exclusao');

if (btnModoExclusao && formExclusao && barraExclusao && modalExclusao) {
    const checkboxes = Array.from(formExclusao.querySelectorAll('.checkbox-produto'));

    function atualizarExclusao() {
        const selecionados = checkboxes.filter((checkbox) => checkbox.checked);
        btnAbrirConfirmacao.disabled = selecionados.length === 0;

        formExclusao.querySelectorAll('.produto').forEach((produto) => {
            const checkbox = produto.querySelector('.checkbox-produto');
            produto.classList.toggle('selecionado', checkbox.checked);
        });
    }

    function fecharConfirmacao() {
        modalExclusao.classList.remove('ativo');
        modalExclusao.setAttribute('aria-hidden', 'true');
        btnAbrirConfirmacao.focus();
    }

    function cancelarSelecao() {
        checkboxes.forEach((checkbox) => { checkbox.checked = false; });
        atualizarExclusao();
        document.body.classList.remove('modo-exclusao');
        btnModoExclusao.setAttribute('aria-pressed', 'false');
        btnModoExclusao.textContent = 'Selecionar';
        barraExclusao.classList.remove('ativa');
        btnModoExclusao.focus();
    }

    btnModoExclusao.addEventListener('click', () => {
        const ativo = document.body.classList.toggle('modo-exclusao');
        btnModoExclusao.setAttribute('aria-pressed', String(ativo));
        btnModoExclusao.textContent = ativo ? 'Selecionando' : 'Selecionar';
        barraExclusao.classList.toggle('ativa', ativo);
        if (!ativo) {
            checkboxes.forEach((checkbox) => { checkbox.checked = false; });
            atualizarExclusao();
        }
    });

    checkboxes.forEach((checkbox) => checkbox.addEventListener('change', atualizarExclusao));
    btnCancelarSelecao.addEventListener('click', cancelarSelecao);

    formExclusao.addEventListener('submit', (event) => {
        const selecionados = checkboxes.filter((checkbox) => checkbox.checked);
        if (selecionados.length === 0) {
            event.preventDefault();
            return;
        }

        event.preventDefault();
        resumoExclusao.textContent = selecionados.length === 1
            ? 'Você selecionou 1 produto para excluir:'
            : `Você selecionou ${selecionados.length} produtos para excluir:`;
        itensExclusao.replaceChildren(...selecionados.map((checkbox) => {
            const item = document.createElement('li');
            item.textContent = checkbox.dataset.nome || 'Produto';
            return item;
        }));
        modalExclusao.classList.add('ativo');
        modalExclusao.setAttribute('aria-hidden', 'false');
        btnCancelarConfirmacao.focus();
    });

    btnFecharConfirmacao.addEventListener('click', fecharConfirmacao);
    btnCancelarConfirmacao.addEventListener('click', fecharConfirmacao);

    modalExclusao.addEventListener('click', (event) => {
        if (event.target === modalExclusao) fecharConfirmacao();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modalExclusao.classList.contains('ativo')) {
            fecharConfirmacao();
        }
    });

    btnConfirmarExclusao.addEventListener('click', () => formExclusao.submit());
    atualizarExclusao();
}
