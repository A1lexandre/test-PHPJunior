# test-PHPJunior

Projeto PHP criado com o propósito de teste para vaga de Desenvolvedor.

Foi utilizado o framework Laravel 6 para o desenvolvimento do projeto.

# Configurando o Laravel

- Crie um banco de dados chamado "gerenciador_rotas"
- Abra o projeto Laravel no terminal
- Execute o comando "php artisan migrate" para a criação das tabelas no BD
- Em seguida, execute o comando "php artisan db:seed", para colocar o dados necessários para o cálculo das rotas no BD
- Os dados enviados a API devem ser passados via "Query parameters". No projeto angular disponibilizado, ele já faz isso automaticamente.


# Consumindo a API

- Um projeto Angular é disponibilizado neste diretório para avaliar o funcionamento da API
- Em localhost, a API deve rodar na porta 8000 para ser consumida corretamente pelo Angular
