# tasks-app
Task management application

Create tables:
~~~
vendor/bin/doctrine orm:schema-tool:create
~~~

Update tables (not for production):
~~~
vendor/bin/doctrine orm:schema-tool:update  --force --dump-sql
~~~
