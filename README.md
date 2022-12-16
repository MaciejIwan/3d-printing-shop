# 3d printing shop app

### To set up step debugger in phpStorm you have to config path mapping in IDE
1. Go to Settings > Languages & Frameworks > PHP and create a server with a hostname localhost
2. Check use path mappings
3. Add mapping like: C:\pathOnYourDisk\mySite mapped to remote /var/www/mySite

## To check local email inbox go to:
```http://localhost:8025/```

# About Docker
### To enter docker container command line
```docker exec -it 3d-printing-app /bin/bash```
### To reload nginx.conf without restarting
```docker exec 3d-printing-nginx nginx -s reload```
### To run docker-compose from terminal
```docker-compose up -d --build```
### To force rebuild whole container
```docker-compose build --no-cache --pull```
### To exec command driectly on docker maching
```docker exec -ti 3d-printing-app sh -c "echo hello world"```

### To generate own files map
```composer dump-autoload -o```


# About database migration
run commands in 3d-printing-app docker commandline
### To generate database schema
```vendor/bin/doctrine-migrations diff```

### To create schema on database
```vendor/bin/doctrine-migrations migrate```