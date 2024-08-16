## How to configure
#### configure .env file
- remember to change the database information
#### up db
    - docker compose up -d db
#### build app
    - docker compose build
#### up app
    - docker compose up
#### run migrations
    - docker exec laravelapp php artisan migrate
## obs
- add Accept application/json to the request header in Postman, insomnia, etc.

## Routes
- GET "api/posts" -- list all posts
- GET "api/posts/{post}" -- show a post
- GET "api/user" -- show the current user
- POST "api/register" -- register a new user
- POST "api/login" -- login a user
- POST "api/logout" -- logout a user
- POST "api/posts" -- create a new post
- PUT "api/posts/{post}" -- update a post
- DELETE "api/posts/{post}" -- delete a post