# tasks-app
Task management application

Create "/config/config.php" from "/config/config.php.dist" and edit.

URL-rewriting for Nginx:
~~~
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
~~~

Create tables:
~~~
vendor/bin/doctrine orm:schema-tool:create
~~~

Update tables (not for production):
~~~
vendor/bin/doctrine orm:schema-tool:update  --force --dump-sql
~~~
