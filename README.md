## Installation

* Download and install composer (https://getcomposer.org/download/)
* run below command in project directory
  > composer install
* copy .env.example to .env and fill in values for DB_DATABASE, DB_USERNAME, DB_PASSWORD (mysql)
* run below command in project directory and fill in output to .env variable APP_KEY
  > php -r "require 'vendor/autoload.php'; echo str_random(32).PHP_EOL;"
* run below command to start development server after which API should be live at address http://localhost:8200
  > php -S localhost:8200 -t public

## Routes

* [GET] article/id -> get article by specified ID
* [GET] articles -> get all articles
* [GET] media/id -> get media by specified ID
* [GET] media -> get all media
* [POST] article -> create new article
  * Payload:
    > content = string, html content of article

    > thumbnail = int, id of media which we use as article image thumbnail

    > title = string, title of article

    > subtitle = string, subtitle of article
* [POST] media/generic -> create new generic media
  * Payload:
    > type = string, type of media

    > content = string, content of our media, for example link to youtube video, twitter page etc.
* [POST] media/image -> create new image media
  * Payload:
    > file = uploaded image file
* [PATCH] article/id -> update article specified by ID
  * Payload:
    > content = string, html content of article

    > thumbnail = int, id of media which we use as article image thumbnail

    > title = string, title of article

    > subtitle = string, subtitle of article
* [DELETE] article/id -> delete article specified by ID

## Important files and folders

* database/migrations -> database migrations for articles and media
* app/Http/Controllers/Content/ArticleController -> controller for article CRUD operations
* app/Http/Controllers/Content/MediaController -> controller for uploading and creating media content
* app/Http/Resources -> API resources to transform model collections
* app/Models -> models for article and media
 