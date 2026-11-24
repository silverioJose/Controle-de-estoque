const btnCopiar = document.getElementById('btn-copiar-lista');
const listaEl = document.getElementById('texto-lista');

if (btnCopiar && listaEl) {
    btnCopiar.addEventListener('click', async () => {
        const grupos = Array.from(listaEl.querySelectorAll('.grupo-departamento')).map((grupo) => {
            const departamento = grupo.querySelector('h4')?.innerText.trim();
            const itens = Array.from(grupo.querySelectorAll('li')).map((li) => {
                return '- ' + li.innerText.replace(/\s+/g, ' ').trim();
            });

            return [departamento, ...itens].filter(Boolean).join('\n');
        }).filter(Boolean);

        // Mantém compatibilidade caso a lista ainda esteja sem grupos por departamento.
        const linhasAvulsas = Array.from(listaEl.querySelectorAll('li')).map((li) => {
            return '- ' + li.innerText.replace(/\s+/g, ' ').trim();
        });

        const textoFinal = (grupos.length ? grupos : linhasAvulsas).join('\n\n');

        if (!textoFinal) return;

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
