const modal = document.getElementById('modal-insert');
const btnAbrir = document.querySelector('.criar');
const btnFechar = document.getElementById('fechar-modal');
const btnCancelar = document.getElementById('cancelar-modal');
const inputNome = document.getElementById('nome');

function abrirModal() {
    modal.classList.add('ativo');
    modal.setAttribute('aria-hidden', 'false');
    setTimeout(() => inputNome.focus(), 50);
}

function fecharModal() {
    modal.classList.remove('ativo');
    modal.setAttribute('aria-hidden', 'true');
}

if (btnAbrir) {
    btnAbrir.addEventListener('click', (e) => {
        e.preventDefault();
        abrirModal();
    });
}

btnFechar.addEventListener('click', fecharModal);
btnCancelar.addEventListener('click', fecharModal);

// Fecha se tocar no fundo escuro fora da caixa
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        fecharModal();
    }
});