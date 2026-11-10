document.addEventListener('DOMContentLoaded', () => {
    // 1. Contador de Caracteres na Descrição
    const descArea = document.getElementById('descricao');
    const contadorChars = document.getElementById('contador-chars');

    if (descArea && contadorChars) {
        descArea.addEventListener('input', () => {
            const atual = descArea.value.length;
            contadorChars.textContent = `${atual} / 500 caracteres`;
        });
    }

    // 2. Validação do Formulário de Cadastro
    const formCadastro = document.getElementById('form-cadastro');
    if (formCadastro) {
        formCadastro.addEventListener('submit', (event) => {
            let valido = true;

            const tituloInput = document.getElementById('titulo');
            const prioridadeSelect = document.getElementById('prioridade');

            const erroTitulo = document.getElementById('erro-titulo');
            const erroPrioridade = document.getElementById('erro-prioridade');

            // Limpa erros anteriores
            erroTitulo.textContent = '';
            erroPrioridade.textContent = '';
            tituloInput.classList.remove('input-invalido');
            prioridadeSelect.classList.remove('input-invalido');

            // Valida Título
            if (!tituloInput.value.trim()) {
                erroTitulo.textContent = 'O título é obrigatório.';
                tituloInput.classList.add('input-invalido');
                valido = false;
            }

            // Valida Prioridade
            if (!prioridadeSelect.value) {
                erroPrioridade.textContent = 'Selecione uma prioridade.';
                prioridadeSelect.classList.add('input-invalido');
                valido = false;
            }

            if (!valido) {
                event.preventDefault();
            }
        });
    }

    // 3. Filtro Dinâmico Client-Side na Tabela
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
        selectStatus.addEventListener('change', filtrarTabela);
        selectPrioridade.addEventListener('change', filtrarTabela);
    }

    // 4. Confirmação de Exclusão
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('btn-excluir')) {
            const confirmacao = confirm('Tem certeza de que deseja excluir esta tarefa?');
            if (!confirmacao) {
                event.preventDefault();
            }
        }
    });
});