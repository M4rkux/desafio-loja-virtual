# Desafio loja virtual

## Pré-requisitos
Para subir o backend (PHP + MySql) você precisará somente do [Docker](https://docs.docker.com/) e [Docker-compose](https://docs.docker.com/compose/install/).
Para subir o frontend você precisará do [Node 8](https://nodejs.org) e do npm que será instalado junto com o node.

## Instalando / Iniciando o projeto

### Backend
Abra o terminal e navegue até a pasta *backend*
```shell
cd backend
```
Inicie o docker-compose para instalar as dependências e subir o servidores de PHP e de MySql.
```shell
sudo docker-compose up
```
Caso precise alterar as configurações do servidor, os arquivos são: Dockerfile, docker-compose.yml, mycustom.cnf

Obs.: Os servidores rodarão nos endereços:
PHP: http://localhost:8100
MySql: http://localhost:9600

### Frontend
Abra o terminal e navegue até a pasta *frontend*
```shell
cd frontend
```
Instale as dependências com o npm
```shell
npm install
```
Para iniciar o servidor utilize o comando:
```shell
npm start
```

Obs.: O servidor de frontend rodará no endereço: http://localhost:7700

### Tecnologias utilizadas
* [npm](https://www.npmjs.com/)
* [webpack](https://webpack.js.org/)
* [babel](https://babeljs.io/)
* [Sass](https://sass-lang.com/)
* [Docker](https://docs.docker.com/)
* [PHP](http://php.net/)
* [MySQL](https://www.mysql.com/)
