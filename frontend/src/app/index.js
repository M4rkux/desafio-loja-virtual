import '../style/main.scss';
import { ProdutoService } from './produto.service';

const body = document.querySelector('body');
const btnShowModal = document.querySelector('#btn-show-modal');
const btnHideModal = document.querySelector('.btn-hide-modal');
const sideModal = document.querySelector('.side-modal');
const confirmModal = document.querySelector('.confirm-modal');
const overlay = document.querySelector('.overlay');
const fields = Array.from(document.querySelectorAll('input'));
const tableProductsBody = document.querySelector('#table-products tbody');
const form = document.querySelector('form');
const btnSubmit = document.querySelector('button[type=submit]');
const spanProdutoExcluir = document.querySelector('#produto-excluir');
const btnConfirmModalCancelar = document.querySelector('.btn-confirm-modal.btn-cancelar');
const btnConfirmModalExcluir = document.querySelector('.btn-confirm-modal.btn-excluir');

let produtos = [];

fields.forEach(elem => {
    elem.addEventListener('keyup', function () {
      checkInput(this, true)
      btnSubmit.disabled = !fields.every(input => checkInput(input))
    })
    elem.addEventListener('change', function () {
      checkInput(this, true)
      btnSubmit.disabled = !fields.every(input => checkInput(input))
    })
  })

btnConfirmModalCancelar.addEventListener('click', esconderConfirmModal);
btnShowModal.addEventListener('click', mostrarModal);
document.addEventListener('keyup', (e) => {
    const evt = e || window.event;
    let isEscape = false;
    if ("key" in evt) {
        isEscape = (evt.key == "Escape" || evt.key == "Esc");
    } else {
        isEscape = (evt.keyCode == 27);
    }
    if (isEscape) {
        esconderModal();
        esconderConfirmModal();
    }
});
btnHideModal.addEventListener('click', esconderModal);
form.addEventListener('submit', function (e) {
    e.preventDefault();
    btnSubmit.disabled = true;
    btnSubmit.classList.add('loading');
  
    let produto = {}
    fields.forEach(field => {
        field.disabled = true;
        produto[field.name] = field.value;
    });

    produto.preco = converteMonetario(produto.preco);
  
    ProdutoService.salvar(produto).then(response => {
        fields.forEach(field => {
            field.disabled = false;
        });
        if (response.ok) {
            esconderModal();
            produto.preco = converteMonetario(produto.preco, true);
            if (produto.id) {
                produtos = produtos.map(produtoList => {
                    if (produtoList.id === produto.id) {
                        produtoList = Object.assign({}, produto);
                    }
                    return produtoList;
                });
                montarTabela(produtos);
            } else {
                response.json().then(data => {
                    produto.id = data;
                    produtos.unshift(produto);
                    montarTabela(produtos);
                });
            }
        }
    });
});


function converteMonetario (valor, toBr) {
    if (toBr) {
        valor = valor.replace(',', '');
        valor = valor.replace('.', ',');
        if (valor.indexOf(',') === -1) {
            valor += ',00';
        }
    } else {
        valor = valor.replace('.', '');
        valor = valor.replace(',', '.');
        if (valor.indexOf('.') === -1) {
            valor += '.00';
        }
    }
    return valor;
}

function mostrarModal() {
    body.style.overflow = 'hidden';
    sideModal.classList.add('show');
    overlay.classList.add('show');
}

function esconderModal() {
    body.style.overflow = '';
    sideModal.classList.remove('show');
    overlay.classList.remove('show');
    limparCampos();
}

function mostrarConfirmModal(produto) {
    body.style.overflow = 'hidden';
    spanProdutoExcluir.innerText = produto.nome;
    confirmModal.classList.add('show');
    overlay.classList.add('show');
}

function esconderConfirmModal() {
    body.style.overflow = '';
    spanProdutoExcluir.innerText = '';
    confirmModal.classList.remove('show');
    overlay.classList.remove('show');
}

function limparCampos() {
    fields.forEach(field => {
        field.value = '';
        field.classList.remove('success');
        field.classList.remove('error');
    });
}

buscarProdutos();

function editar(produto) {
    fields.forEach(field => {
        field.value = produto[field.name]
    });
    mostrarModal();
}

function excluir(produto) {
    mostrarConfirmModal(produto);
    btnConfirmModalExcluir.removeEventListener('click', new Event('click'));
    btnConfirmModalExcluir.addEventListener('click', function () {
        ProdutoService.deletar(produto.id).then(response => {
            esconderConfirmModal();
            if (response.ok) {
                produtos = produtos.filter(produtoList => produtoList.id !== produto.id);
                montarTabela(produtos);
            }
        });
    });
}

function montarTabela(produtos) {
    tableProductsBody.innerHTML = '';
    if (produtos.length > 0) {
        produtos.forEach(produto => {
            const tr = document.createElement('tr');
            const tdId = document.createElement('td');
            const tdNome = document.createElement('td');
            const tdPreco = document.createElement('td');
            const tdQuantidade = document.createElement('td');
            const tdBotoes = document.createElement('td');
            const btnEditar = document.createElement('button');
            const btnExcluir = document.createElement('button');
    
            tdId.classList.add('ta-r');
            tdNome.classList.add('ta-l');
            tdPreco.classList.add('ta-r');
            tdQuantidade.classList.add('ta-r');
            tdBotoes.classList.add('td-botoes');
    
            btnEditar.title = 'Editar';
            btnEditar.type = 'button';
            btnEditar.classList.add('btn-acao','btn-editar');
            btnEditar.innerText = 'Editar';
            btnEditar.addEventListener('click', function () {
                editar(produto);
            }); 
            btnExcluir.title = 'Excluir';
            btnExcluir.type = 'button';
            btnExcluir.classList.add('btn-acao','btn-excluir');
            btnExcluir.innerText = 'Excluir';
            btnExcluir.addEventListener('click', function () { 
                excluir(produto); 
            });
            tdId.innerText = produto.id;
            tdNome.innerText = produto.nome;
            tdPreco.innerText = produto.preco;
            tdQuantidade.innerText = produto.quantidade;
    
            tdBotoes.appendChild(btnEditar);
            tdBotoes.appendChild(btnExcluir);
            tr.appendChild(tdId);
            tr.appendChild(tdNome);
            tr.appendChild(tdPreco);
            tr.appendChild(tdQuantidade);
            tr.appendChild(tdBotoes);
    
            tableProductsBody.appendChild(tr);
        });
    } else {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = 5;
        td.innerText = 'Nenhum produto cadastrado';
        td.classList.add('single-col');

        tr.appendChild(td);
        tableProductsBody.appendChild(tr);
    }
}


function buscarProdutos () {
    ProdutoService.listar().then(response => {
        response.json().then(lista => {
            produtos = lista.map(produto => {
                produto.preco = converteMonetario(produto.preco, true);
                return produto;
            });
            montarTabela(produtos);
        });
    }).catch(error => {
        console.error(error);
    });
}

function checkInput (elem, changeClass = false) {
    let valid = elem.checkValidity();

    if (changeClass) {
        toggleSuccessError(elem, valid);
    }
    return valid;
}
  
function toggleSuccessError (elem, isSuccess) {
    elem.classList.toggle('success', isSuccess);
    elem.classList.toggle('error', !isSuccess);
}