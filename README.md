# Projeto de Transferência Simplificada entre Usuários

Este projeto é uma API REST desenvolvida em Laravel 11 para facilitar a transferência simplificada entre usuários, utilizando rotas CRUD para gerenciar usuários e carteiras (wallets).

## Pré-requisitos

-   **Docker**: Caso não tenha o Docker instalado, siga as instruções abaixo.

### Instalando o Docker

1. **Ubuntu**:

    - Atualize os pacotes existentes:
        ```bash
        sudo apt update
        sudo apt install apt-transport-https ca-certificates curl software-properties-common
        ```
    - Adicione o repositório oficial Docker:
        ```bash
        curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
        sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
        sudo apt update
        ```
    - Instale o Docker:
        ```bash
        sudo apt install docker-ce
        sudo systemctl status docker
        ```

2. **Windows / Mac**:
    - Baixe e instale o Docker Desktop a partir do site oficial:
      https://www.docker.com/products/docker-desktop

## Como instalar e rodar o projeto

### 1. Clonar o Repositório

Clone o repositório em sua máquina local:

```bash
git clone https://github.com/anacnogueira/challenge-transferencia-simplificada.git
cd challenge-transferencia-simplificada
```

### 2. Construir o Container do Projeto

Dentro da pasta do projeto, execute o seguinte comando no terminal para subir as imagens do projeto

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### 3. Testar a Aplicação

Rode o seguinte comando para execuatr o projeto

```bash
./vendor/bin/sail up -d
```

### 4. Configure um alias de Shell para o Sail

O projeto vem com um container em Docker próprio do Laravel, chamado Sail, que facilita a instalção do projeto, rodar comandos do artisan e composer entre outros comodidades, sem a necessidade instalar o PHP, Mysql e extensões em sua máquina.

Por padrão, os comandos Sail são invocados usando o script

> vendor/bin/sail

que está incluído em todas as novas aplicações Laravel:

    ./vendor/bin/sail up

No entanto, em vez de digitar repetidamente vendor/bin/sail para executar comandos do Sail, você pode querer configurar um alias de shell que permita executar os comandos do Sail com mais facilidade:

      alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

Para garantir que isso esteja sempre disponível, você pode adicioná-lo ao arquivo de configuração do shell em seu diretório inicial, como ~/.zshrc ou ~/.bashrc, e então reiniciar o shell.

Depois que o alias do shell tiver sido configurado, você poderá executar comandos Sail simplesmente digitando ´´´sail´´´. A partir de agora você pode digitar o comando baixo para subir o container:

     sail up -d

### 5. Rodar as Migrações

Execute as migrações do banco de dados:

```bash
sail artisan migrate
```

## Endpoints da API

### 1. Usuários

#### Criar Usuário

-   <b>Endpoint:</b> POST /api/users
-   <b>Paramêtros:</b>

*   name (string, obrigatório): Nome do usuário.
*   email (string, obrigatório): E-mail do usuário.
*   password (string, obrigatório): Senha do usuário.
*   cpf_cnpj (string, obrigatorio): CPF ou CNPJ do usuário

-   <b>Exemplo de Request:</b>
    {
    "name": "João Silva",
    "email": "joao@example.com",
    "password": "123456",
    "cpf_cnpj": "123.456.789-00"
    }

#### Visualizar usuario

-   <b>Endpoint:</b> GET /api/users/{id}
-   <b>Paramêtros:</b>

*   id (integer, obrigatório): ID do usuário a ser visualizado.

#### Listar Usuários

-   <b>Endpoint:</b> GET /api/users
-   <b>Paramêtros:</b> Nenhum

#### Atualizar Usuário

-   <b>Endpoint:</b> PUT /api/users/{id}
-   <b>Paramêtros:</b>

*   id (integer, obrigatório): ID do usuário a ser atualizado.
*   name (string, obrigatório): Nome do usuário.
*   email (string, obrigatório): E-mail do usuário.
*   password (string, obrigatório): Senha do usuário.
*   cpf_cnpj (string, obrigatorio): CPF ou CNPJ do usuário

-   <b>Exemplo de Request:</b>
    {
    "name": "João Silva",
    "email": "joao@example.com",
    "password": "123456",
    "cpf_cnpj": "123.456.789-00"
    }

#### Deletar Usuário

-   <b>Endpoint:</b> PUT /api/users/{id}
-   <b>Paramêtros:</b>

*   id (integer, obrigatório): ID do usuário a ser excluído.

### 2. Wallets (Carteiras)

#### Criar Uma Carteria

-   <b>Endpoint:</b> POST /api/wallets
-   <b>Paramêtros:</b>

*   user_id (integer, obrigatório): ID do usuário que possui a wallet.
*   amount (float, obrigatório): Saldo Inicial da Carteira

-   <b>Exemplo de Request:</b>
    {
    "user_id": "João Silva",
    "amount": 100.00
    }

#### Visualizar Carteira

-   <b>Endpoint:</b> GET /api/wallets/{id}
-   <b>Paramêtros:</b>

*   id (integer, obrigatório): ID da carteira a ser visualizada.

#### Adicionar fundos a carteira

-   <b>Endpoint:</b> PUT /api/wallets/add/{id}
-   <b>Paramêtros:</b>

*   id (integer, obrigatório): ID da carteira que receberá saldo.
*   amount (float, obrigatório): Valor a ser inserido na carteira

-   <b>Exemplo de Request:</b>
    {
    "amount": 100.00
    }

#### Fazer Transferência entre carteiras

-   <b>Endpoint:</b> POST /api/add/{id}
-   <b>Paramêtros:</b>

*   value (float, obrigatório): Valor a ser adicionado na Carteira
*   payer (integer, obrigatório): ID do usuário que está fazendo a transferência.
*   payee (integer, obrigatório): ID do usuário que está fazendo a transferência.

<b>Obs:</b>Somente usuários comums (com CPF cadastrado) podem realizar transferências.

-   <b>Exemplo de Request:</b>
    {
    "value": 100.00,
    "payer": 1,
    "payee": 2
    }

#### Listar Carterias

-   <b>Endpoint:</b> GET /api/wallets
-   <b>Paramêtros:</b> Nenhum

#### Deletar Carteira

-   <b>Endpoint:</b> PUT /api/wallets/{id}
-   <b>Paramêtros:</b>

*   id (integer, obrigatório): ID da carteira a ser excluída.

## Contribuição

Sinta-se à vontade para abrir issues ou pull requests. Feedbacks e contribuições são sempre bem-vindos!

## Licença

Este projeto está sob a licença MIT.

Este arquivo `README.md` cobre os passos para instalar o Docker, configurar o projeto, rodar as migrações e interagir com a API via seus endpoints principais. A seção de endpoints pode ser expandida conforme necessário para incluir mais rotas e parâmetros.
