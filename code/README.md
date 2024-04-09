# Projeto de Gerenciamento de Produtos

## Introdução

Este é um projeto de API para gerenciamento de produtos, com o objetivo de dar suporte a equipe de nutricionistas da empresa Fitness Foods LC para que eles possam revisar de maneira rápida a informação nutricional dos alimentos que os usuários publicam pela aplicação móvel.

## Tecnologias Utilizadas

- Linguagem: PHP
- Framework: Laravel
- Biblioteca de Autenticação: Laravel Sanctum
- Banco de dados: MySql
- Cache: Redis

## Como Executar o Projeto

1. Clone o repositório para o seu ambiente local.
2. Acesse a pasta do Projeto: cd ./ProductParser-api/code/
3. Instale as dependências do Composer usando o comando: composer install
4. Instale as dependências NodeJs: npm install && npm run build
5. Abra o VS Code utilizando o comando: code .
6. Inicie o WSL: wsl
7. Configurar alias do Sail: alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
8. Iniciar o container com Laravel Sail: sail up -d
9. Execute as Migrations: sail artisan migrate
10. Faça a primeira importação dos produtos: sail artisan app:import-products
11. Acesse a página de cadastro para obter um token de API: http://localhost/register

## Configurar CRON para Importação de Produtos

Para que a importação ocorra diariamente às 02:00 (Hora escolhida para importação, devido baixo acesso de usuários), é necessário configurar um cron, exemplo abaixo:

CRON: * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

## Endpoints da API

#### GET /api/
- Retorna detalhes da API

#### GET /api/produtos/{code}
- Retorna detalhes de um produto específico com base no código.

#### PUT /api/produtos/{code}
- Atualiza as informações de um produto específico com base no código.

#### POST /api/produtos
- Cria um novo produto.

#### DELETE /api/produtos/{code}
- Remove um produto específico com base no código fornecido.

>  This is a challenge by [Coodesh](https://coodesh.com/)
