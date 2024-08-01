<h1 align="center">
    API RESTful de usuários
</h1>

## Índice

-   <a href="#boat-sobre-o-projeto">Sobre o projeto</a>
-   <a href="#hammer-tecnologias">Tecnologias</a>
-   <a href="#clipboard-pré-requisitos">Pré-requisitos</a>
-   <a href="#rocket-como-rodar-esse-projeto">Como rodar esse projeto</a>
-   <a href="#gear-principais-características-e-funcionalidades">Principais Características e Funcionalidades</a>
    
-   <a href="#bookmark_tabs-licença">Licença</a>
-   <a href="#wink-autores">Autores</a>

## :boat: Sobre o projeto

Este projeto é uma API RESTful para visualizar usuários cadastrados e documentada com Swagger.

## :hammer: Tecnologias:

-   **[PHP](https://www.typescriptlang.org)**
-   **[Laravel](https://nestjs.com/)**
-   **[MySQL](https://www.mysql.com/)**
-   **[Docker](https://www.postgresql.org/)**
-   **[Swagger](https://swagger.io/)**


## :clipboard: Pré-requisitos

-   Docker
-   Docker Compose

## :rocket: Como rodar esse projeto

Se você estiver usando Windows, vai precisar do WSL para rodar esse projeto de forma prática. Para isso, você pode instalá-lo seguindo o seguinte [tutorial](https://learn.microsoft.com/pt-br/windows/wsl/install). Também será necessário uma distribuição linux para utilizar o WSL. Recomendo o Ubuntu que pode ser baixando na própria Microsoft Store no [link](https://apps.microsoft.com/store/detail/ubuntu/9PDXGNCFSCZV).
Depois, vai precisar do Docker, o qual a versão de Windows pode ser encontrada [aqui](https://docs.docker.com/desktop/install/windows-install/).
Então, clone o projeto dentro do WSL, vá para pasta dele e execute o comando para instalar as dependências:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Após a instalação, basta executar o comando:

```
docker compose up -d
```

Agora precisamos configurar as variáveis ambientes. Crie o arquivo .env:

```
cp .env.example .env
```

Agora precisamos configurar as variáveis ambientes para realização de testes. Crie o arquivo .env.testing:

```
cp .env.example .env.testing
```

Altere o valor de "APP_ENV" para "testing" no arquivo ".env.testing".

Crie as chaves de segurança da aplicação:

    `sail artisan key:generate`

Execute as migrações:

    `./vendor/bin/sail artisan migrate`

Popule o banco de dados com contatos:

    `./vendor/bin/sail artisan db:seed`

A collection para o Postman se encontra no arquivo: teste-situacional-back-end.postman_collection.


## :handshake: Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir uma issue ou enviar um pull request.

## :bookmark_tabs: Licença

Este projeto esta sobe a licença MIT. Veja a [LICENÇA](https://opensource.org/licenses/MIT) para saber mais.

## :wink: Autores

Feito com ❤️ por:

-   [Ederson Ribeiro Silva](https://www.linkedin.com/in/edRibeiro/)

[Voltar ao topo](#índice)
