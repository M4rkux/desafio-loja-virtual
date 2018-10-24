const URL_API = 'http://localhost:8100/produto/';
export class ProdutoService {
  static salvar (produto) {
    const headers = new Headers();
    headers.set('Accept', 'application/json');
    headers.set('Content-Type', 'application/json');

    if (produto.id) {
      return fetch(URL_API + produto.id, {
        method: 'PUT',
        headers: headers,
        body: JSON.stringify(produto)
      });
    } else {
      return fetch(URL_API, {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(produto)
      });
    }
  }

  static listar () {
    return fetch (URL_API);
  }

  static porId(id) {
    return fetch(URL_API + id);
  }

  static deletar(id) {
    return fetch(URL_API + id, {
      method: 'DELETE'
    });
  }
}