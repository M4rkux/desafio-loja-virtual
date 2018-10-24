import { ProdutoService } from './produto.service';

const produto = {
    nome: 'Carrão de rolimão',
    preco: '666.66',
    quantidade: 666,
    id: 1
};

ProdutoService.salvar(produto).then(response => {
    if (response.ok) {
        response.json().then(data => {
            console.log(data);
        })
    }
});

ProdutoService.listar().then(response => {
    if (response.ok) {
        response.json().then(data => {
            console.log(data);

            ProdutoService.deletar(data.length).then(response => {
                response.json().then(data => {
                    console.log('deletar', data);
                })
            });
        }).catch(error => {
            console.error(error);
        });
    }
});

ProdutoService.porId(1).then(response => {
    if (response.ok) {
        response.json().then(data => {
            console.log(data);
        }).catch(error => {
            console.error(error);
        });
    }
});