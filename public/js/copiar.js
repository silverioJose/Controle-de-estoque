const btnCopiar = document.getElementById('btn-copiar-lista');
const listaEl = document.getElementById('texto-lista');

if (btnCopiar && listaEl) {
    btnCopiar.addEventListener('click', async () => {
        const linhas = Array.from(listaEl.querySelectorAll('li')).map((li) => {
            return '- ' + li.innerText.replace(/\s+/g, ' ').trim();
        });

        const textoFinal = linhas.join('\n');

        try {
            await navigator.clipboard.writeText(textoFinal);
            btnCopiar.textContent = 'Copiado!';
            setTimeout(() => {
                btnCopiar.textContent = 'Copiar';
            }, 1500);
        } catch (err) {
            console.error('Erro ao copiar:', err);
        }
    });
}