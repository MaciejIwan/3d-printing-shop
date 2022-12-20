  # 3d printing shop app
[IN PROGRESS] PHP web ecomerce application. Created for a 3D printing house.
## IDE setup
### To set up step debugger in phpStorm you have to config path mapping in IDE
1. Go to Settings > Languages & Frameworks > PHP and create a server with a hostname localhost
2. Check use path mappings
3. Add mapping like: C:\pathOnYourDisk\mySite mapped to remote /var/www/mySite
   * To generate own files map run this command
   ```composer dump-autoload -o```
## Links
* main page ```http://localhost:8000/```
* local email inbox:
```http://localhost:8025/```

## Docker
* To enter docker container command line
```docker exec -it 3d-printing-app /bin/bash```
* To reload nginx.conf without restarting
```docker exec 3d-printing-nginx nginx -s reload```
* To run docker-compose from terminal
```docker-compose up -d --build```
* To force rebuild whole container
```docker-compose build --no-cache --pull```
* To exec command driectly on docker maching
```docker exec -ti 3d-printing-app sh -c "echo hello world"```



## App CLI 
run commands in 3d-printing-app docker commandline
### About database migration
* To generate database schema: ```php myapp migrations:diff```
* To create schema on database: ```php myapp migrations:migrate```

### List all available command
* ```php myapp list```




### To run tests
```./vendor/bin/phpunit```

## Credits
 Software used to create database diagram
 https://drawsql.app/
