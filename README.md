# tasks-app
Task management application

Create "/config/config.php" from "/config/config.php.dist" and edit.

Create tables:
~~~
vendor/bin/doctrine orm:schema-tool:create
~~~

Update tables (not for production):
~~~
vendor/bin/doctrine orm:schema-tool:update  --force --dump-sql
~~~
