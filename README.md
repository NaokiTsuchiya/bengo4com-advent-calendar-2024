# naoki-tsuchiya/jwt-session

## Install dependencies

    composer install

## Serve redis

    docker-compose up -d

## Run

    php -S localhost:8080 -t public


Open http://localhost:8080 for getting session cookie, and access http://localhost:8080/session-required.php for checking session cookie.
