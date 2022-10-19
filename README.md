# 3d printing shop app


## To set up step debugger in phpStorm you have to config path mapping in IDE
 - 2. Go to Settings > Languages & Frameworks > PHP and create a server with a hostname localhost
 - 3. Check use path mappings
 - 4. Add mapping like: C:\pathOnYourDisk\mySite mapped to remote /var/www/mySite

## To reload nginx.conf without restarting ```docker exec 3d-printing-nginx nginx -s reload```
## To run docker-compose from terminal ```docker-compose up -d --build```
## To force rebuild whole container ```docker-compose build --no-cache --pull```