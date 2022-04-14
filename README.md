![Library logo](public/img/readme.jpg)

API providing restrited access to the Bilemo catalog to authenticated clients.

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/39b60b23ae034749a45159231ca31b7d)](https://www.codacy.com/gl/phil-all/bilemo-api/dashboard?utm_source=gitlab.com&utm_medium=referral&utm_content=phil-all/bilemo-api&utm_campaign=Badge_Grade)

## Table of contents

- [Prerequisites](#prerequisites)
   - [Installation](#installation)
   - [Configuration](#configuration)
   - [Usage](#usage)
      - [API use](#api-use)
      - [API documentation](#api-documentation)
- [Further documentation](#further-documentation)
   - [Build with](#build-with)
   - [Third party dependencies and bundles](#third-party-dependencies-and-bundles)
   - [Docker stack](#Dockerstack)

* * *

## Geting started

### Prerequisites

To be installed, ans used, this project requires:

-   git
-   composer
-   docker-compose

### Installation

```bash
git clone git@gitlab.com:phil-all/bilemo-api.git

composer install
```

Launch dockerized environment, from project root working directory

```bash
docker-compose build

docker-compose up -d
```

**Development bash** is now accessible with following custom command

```bash
composer dev-bash
```

### Configuration

**Set environment variables** in a `.env.local file`, as indicated in `.env` file.

```code
# ##> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=change_me_in_.env.local
# ##< symfony/framework-bundle ###

# ##> doctrine/doctrine-bundle ###
DATABASE_URL=change_me_in_.env.local
# ##< doctrine/doctrine-bundle ###

# ##> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=change_me_in_.env.local
JWT_TTL=change_me_in_.env.local
# ##< lexik/jwt-authentication-bundle ###
```

**Set postgres database** named bilemoapi.

```code
DATABASE_URL="postgresql://user:pass@dbpostgres:5432/bilemoapi?sslmode=disable"
```

**Create database** and **set demo datas**, as follow in development bash.

```bash
composer set-db
```

### Usage

#### API use

To test API endpoints, use tool as [Postman](https://learning.postman.com/docs/getting-started/introduction/) or [Insomnia](https://insomnia.rest/download).

To login, send to following address: `127.0.0.1/api/v1/login`, in body request as JSON format, the demo user:

```json
{
  "email": "user.test.bilemo@gmail.com",
  "password": "pass1234"
}
```

It will return a JWT token.

![Library logo](public/img/insomnia.jpg)

Use this token in header further request to be auhtenticate, during one hour.

#### API documentation

accessible to follwing address: `127.0.0.1/swagger/index.html`

![Library logo](public/img/api-doc.jpg)

Regenerate API documentation :

```bash
./vendor/bin/openapi --format json --output ./public/swagger/bilemo-api-documentation.json src
```

* * *

## Further documentation

### Build with

-   Symfony 5.4
-   Docker environment: details in [docker stack](#docker-stack) section.

### Third party dependencies and bundles

**Code quality**

-   phpro/grumphp with:
    -   phpstan
    -   phpcs
    -   phpmd

**Demo datas**

-   fakerphp/faker

**Test**

-   phpunit
-   liip/functional-test-bundle
-   liip/test-fixtures-bundle

**API Authentication**

_specific to version 1_

-   lexik/jwt-authentication-bundle

_specific to version 2_

-   knpuniversity/oauth2-client-bundle
-   league/oauth2-google

**API documentation**

-   zircote/swagger-php

### Docker stack

| service  | version | ports     |
| :------- | :------ | :-------- |
| nginx    | latest  | 8100:80   |
| php      | 8.0     |           |
| postgres | latest  | 5432:5432 |
| pgadmin  | 4       | 8200:80   |
| varnish  | 4.1     | 80:80     |
| redis    | 6.0.5   | 6379:6379 |
