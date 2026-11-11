document.addEventListener('DOMContentLoaded', () => {
    // Contador de Caracteres na Descrição
    const descArea = document.getElementById('descricao');
    const contadorChars = document.getElementById('contador-chars');

    if (descArea && contadorChars) {
        descArea.addEventListener('input', () => {
            const atual = descArea.value.length;
            contadorChars.textContent = `${atual} / 500 caracteres`;
        });
    }

    // Validação dos formulários de cadastro e edição
    const formCadastro = document.getElementById('form-cadastro');
    if (formCadastro) {
        // Mostra (ou limpa) a mensagem de erro de um campo
        const mostrarErro = (campo, spanErro, mensagem) => {
            if (spanErro) spanErro.textContent = mensagem;
            if (campo) campo.classList.toggle('input-invalido', mensagem !== '');
            return mensagem === '';
        };

        formCadastro.addEventListener('submit', (event) => {
            const tituloInput = document.getElementById('titulo');
            const prioridadeSelect = document.getElementById('prioridade');
            const prazoInput = document.getElementById('prazo');

            const tituloOk = mostrarErro(tituloInput, document.getElementById('erro-titulo'),
                tituloInput.value.trim() ? '' : 'O título é obrigatório.');
            const prioridadeOk = mostrarErro(prioridadeSelect, document.getElementById('erro-prioridade'),
                prioridadeSelect.value ? '' : 'Selecione uma prioridade.');
            const prazoOk = mostrarErro(prazoInput, document.getElementById('erro-prazo'),
                prazoInput.value ? '' : 'Informe o prazo da tarefa.');

            if (!(tituloOk && prioridadeOk && prazoOk)) {
                event.preventDefault();
            }
        });
    }

    // Filtro Dinâmico Client-Side na Tabela
    const campoBusca = document.getElementById('filtro-busca');
    const selectStatus = document.getElementById('filtro-status');
    const selectPrioridade = document.getElementById('filtro-prioridade');
    const tabelaTarefas = document.getElementById('tabela-tarefas');

    if (campoBusca && tabelaTarefas) {
        const filtrarTabela = () => {
            const termoBusca = campoBusca.value.toLowerCase();
            const statusFiltro = selectStatus.value.toLowerCase();
            const prioridadeFiltro = selectPrioridade.value.toLowerCase();

            const linhas = tabelaTarefas.querySelectorAll('tbody tr');

            linhas.forEach(linha => {
                // Pula a linha de estado vazio
                if (linha.querySelector('.sem-registros')) return;

                const textoTitulo = linha.children[0]?.textContent.toLowerCase() || '';
                const textoPrioridade = linha.children[1]?.textContent.toLowerCase() || '';
                const textoStatus = linha.children[2]?.textContent.toLowerCase() || '';

                const bateBusca = textoTitulo.includes(termoBusca);
                const bateStatus = !statusFiltro || textoStatus.includes(statusFiltro);
                const batePrioridade = !prioridadeFiltro || textoPrioridade.includes(prioridadeFiltro);

                if (bateBusca && bateStatus && batePrioridade) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        };

        campoBusca.addEventListener('input', filtrarTabela);
    }

    // Confirmação de Exclusão
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-excluir')) {
            const confirmacao = confirm('Tem certeza de que deseja excluir esta tarefa?');
            if (!confirmacao) {
                event.preventDefault();
            }
        }
    });
});