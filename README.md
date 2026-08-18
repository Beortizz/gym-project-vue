# Gerenciamento de Fichas de Treinamento para Academia

Este projeto é uma aplicação de gerenciamento de fichas de treinamento desenvolvida para academias. Ele permite o cadastro de alunos, exercícios e a criação e edição de fichas de treinamento para os alunos, incluindo informações sobre os exercícios e as repetições associadas.

## Tecnologias Utilizadas

- **Frontend:** Vue.js 3
- **Backend:** Laravel 10

## Funcionalidades Principais

- **Cadastro de Alunos:** Registre informações detalhadas sobre os alunos, incluindo nome, idade, peso, altura, entre outros.

- **Cadastro de Exercícios:** Adicione novos exercícios à base de dados, incluindo nome, descrição e qualquer informação relevante.

- **Criação/Edição de Fichas de Treinamento:** Desenvolva fichas de treinamento personalizadas para cada aluno, adicionando exercícios específicos, número de repetições e outras configurações.

## Como Rodar o Projeto

### Pré-requisitos

- Certifique-se de ter o [Node.js](https://nodejs.org/) instalado em sua máquina.
- Certifique-se de ter o [Composer](https://getcomposer.org/) instalado para gerenciar as dependências do Laravel.

### Passos para Execução

1. **Clone o Repositório:**
```bash

git clone https://github.com/seu-usuario/nome-do-repositorio.git

cd nome-do-repositorio

```
2. **Instale as Dependências**
```bash

composer install

npm install

```

3. **Crie a chave da aplicação**
```bash

php artisan key:generate

```

5. **Rode o servidor de front-end**
```bash

npm run dev

```

6. **Rode o servidor de back-end**
```bash

php artisan serve

```

## Rodando com Docker

Pré-requisito: [Docker](https://www.docker.com/) e Docker Compose.

1. Copie o `.env.example` para `.env`.
2. Suba os containers:
```bash
docker compose up -d
```
3. O container `app` roda `composer install`, `key:generate` e `migrate` automaticamente no start. O container `node` sobe o Vite em modo dev com HMR.
4. Acesse:
   - App: http://localhost:8003
   - Vite (dev server): http://localhost:5175
   - phpMyAdmin: http://localhost:8083
   - MySQL exposto em: `localhost:3309`

![Print do projeto](/printGymVueProject.PNG)


