<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Projeto de Transferência Simplificada entre Usuários</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
           <h1>Projeto de Transferência Simplificada entre Usuários</h1>

           <p>Este projeto é uma API REST desenvolvida em Laravel 11 para facilitar a transferência simplificada entre usuários, utilizando rotas CRUD para gerenciar usuários e carteiras (wallets).</p>

<h2>Pré-requisitos</h2>

<ul>
    <li><strong>Docker</strong>: Caso não tenha o Docker instalado, siga as instruções abaixo.</li>
</ul>

<h3>Instalando o Docker</h3>

<ol>
    <li><strong>Ubuntu</strong>:

        <p>Atualize os pacotes existentes:</p>
        <pre><code>sudo apt update
sudo apt install apt-transport-https ca-certificates curl software-properties-common
        </code></pre>

        <p>Adicione o repositório oficial Docker:</p>
        <pre><code>curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
sudo apt update
        </code></pre>

        <p>Instale o Docker:</p>
        <pre><code>sudo apt install docker-ce
sudo systemctl status docker
        </code></pre>
    </li>

    <li><strong>Windows / Mac</strong>:

        <p>Baixe e instale o Docker Desktop a partir do site oficial:</p>
        <p><a href="https://www.docker.com/products/docker-desktop">https://www.docker.com/products/docker-desktop</a></p>
    </li>
</ol>

<h2>Como instalar e rodar o projeto</h2>

<h3>1. Clonar o Repositório</h3>

<p>Clone o repositório em sua máquina local:</p>

<pre><code>git clone https://github.com/anacnogueira/challenge-transferencia-simplificada.git
cd challenge-transferencia-simplificada
</code></pre>

<h3>2. Construir o Container do Projeto</h3>

<p>Dentro da pasta do projeto, execute o seguinte comando no terminal para subir as imagens do projeto:</p>

<pre><code>docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php83-composer:latest \
composer install --ignore-platform-reqs
</code></pre>

<h3>3. Testar a Aplicação</h3>

<p>Rode o seguinte comando para executar o projeto:</p>

<pre><code>./vendor/bin/sail up -d
</code></pre>

<h3>4. Configure um alias de Shell para o Sail</h3>

<p>O projeto vem com um container em Docker próprio do Laravel, chamado Sail, que facilita a instalação do projeto, rodar comandos do artisan e composer, entre outras comodidades, sem a necessidade de instalar o PHP, MySQL e extensões em sua máquina.</p>

<p>Por padrão, os comandos Sail são invocados usando o script:</p>

<blockquote>vendor/bin/sail</blockquote>

<p>que está incluído em todas as novas aplicações Laravel:</p>

<blockquote>./vendor/bin/sail up</blockquote>

<p>No entanto, em vez de digitar repetidamente vendor/bin/sail para executar comandos do Sail, você pode configurar um alias de shell:</p>

<pre><code>alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
</code></pre>

<p>Adicione-o ao arquivo de configuração do shell em seu diretório inicial, como <code>~/.zshrc</code> ou <code>~/.bashrc</code>, e reinicie o shell.</p>

<p>Agora, você poderá executar comandos Sail digitando apenas:</p>

<blockquote>sail up -d</blockquote>

<h3>5. Rodar as Migrações</h3>

<p>Execute as migrações do banco de dados:</p>

<pre><code>sail artisan migrate
</code></pre>

<h2>Endpoints da API</h2>

<h3>1. Usuários</h3>

<h4>Criar Usuário</h4>

<p><strong>Endpoint:</strong> POST /api/users</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>name (string, obrigatório): Nome do usuário.</li>
    <li>email (string, obrigatório): E-mail do usuário.</li>
    <li>password (string, obrigatório): Senha do usuário.</li>
    <li>cpf_cnpj (string, obrigatório): CPF ou CNPJ do usuário.</li>
</ul>

<p><strong>Exemplo de Request:</strong></p>

<pre><code>{
    "name": "João Silva",
    "email": "joao@example.com",
    "password": "123456",
    "cpf_cnpj": "123.456.789-00"
}
</code></pre>

<h4>Visualizar Usuário</h4>

<p><strong>Endpoint:</strong> GET /api/users/{id}</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>id (integer, obrigatório): ID do usuário a ser visualizado.</li>
</ul>

<h4>Listar Usuários</h4>

<p><strong>Endpoint:</strong> GET /api/users</p>
<p><strong>Parâmetros:</strong> Nenhum</p>

<h4>Atualizar Usuário</h4>

<p><strong>Endpoint:</strong> PUT /api/users/{id}</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>id (integer, obrigatório): ID do usuário a ser atualizado.</li>
    <li>name (string, obrigatório): Nome do usuário.</li>
    <li>email (string, obrigatório): E-mail do usuário.</li>
    <li>password (string, obrigatório): Senha do usuário.</li>
    <li>cpf_cnpj (string, obrigatório): CPF ou CNPJ do usuário.</li>
</ul>

<p><strong>Exemplo de Request:</strong></p>

<pre><code>{
    "name": "João Silva",
    "email": "joao@example.com",
    "password": "123456",
    "cpf_cnpj": "123.456.789-00"
}
</code></pre>

<h4>Deletar Usuário</h4>

<p><strong>Endpoint:</strong> DELETE /api/users/{id}</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>id (integer, obrigatório): ID do usuário a ser excluído.</li>
</ul>

<h3>2. Wallets (Carteiras)</h3>

<h4>Criar Uma Carteira</h4>

<p><strong>Endpoint:</strong> POST /api/wallets</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>user_id (integer, obrigatório): ID do usuário que possui a wallet.</li>
    <li>amount (float, obrigatório): Saldo inicial da carteira.</li>
</ul>

<p><strong>Exemplo de Request:</strong></p>

<pre><code>{
    "user_id": "João Silva",
    "amount": 100.00
}
</code></pre>

<h4>Visualizar Carteira</h4>

<p><strong>Endpoint:</strong> GET /api/wallets/{id}</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>id (integer, obrigatório): ID da carteira a ser visualizada.</li>
</ul>

<h4>Adicionar Fundos à Carteira</h4>

<p><strong>Endpoint:</strong> PUT /api/wallets/add/{id}</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>id (integer, obrigatório): ID da carteira que receberá saldo.</li>
    <li>amount (float, obrigatório): Valor a ser inserido na carteira.</li>
</ul>

<p><strong>Exemplo de Request:</strong></p>

<pre><code>{
    "amount": 100.00
}
</code></pre>

<h4>Fazer Transferência entre Carteiras</h4>

<p><strong>Endpoint:</strong> POST /api/wallets/transfer/{id}</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>value (float, obrigatório): Valor a ser adicionado na Carteira.</li>
    <li>payer (integer, obrigatório): ID do usuário que está fazendo a transferência.</li>
    <li>payee (integer, obrigatório): ID do usuário que está recebendo a transferência.</li>
</ul>

<p><strong>Obs:</strong> Somente usuários comuns (com CPF cadastrado) podem realizar transferências.</p>

<p><strong>Exemplo de Request:</strong></p>

<pre><code>{
    "value": 100.00,
    "payer": 1,
    "payee": 2
}
</code></pre>
        </div>

        <h4>Listar Carteiras</h4>

<p><strong>Endpoint:</strong> GET /api/wallets</p>
<p><strong>Parâmetros:</strong> Nenhum</p>

<h4>Deletar Carteira</h4>

<p><strong>Endpoint:</strong> PUT /api/wallets/{id}</p>
<p><strong>Parâmetros:</strong></p>

<ul>
    <li>id (integer, obrigatório): ID da carteira a ser excluída.</li>
</ul>

<h2>Contribuição</h2>

<p>Sinta-se à vontade para abrir issues ou pull requests. Feedbacks e contribuições são sempre bem-vindos!</p>

<h2>Licença</h2>

<p>Este projeto está sob a licença MIT.</p>

<p>Este arquivo cobre os passos para instalar o Docker, configurar o projeto, rodar as migrações e interagir com a API via seus endpoints principais. A seção de endpoints pode ser expandida conforme necessário para incluir mais rotas e parâmetros.</p>

    </body>
</html>
