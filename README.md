# web-api

VN I deal: WEB API

```
location /api {
   alias /var/www/html/vnideal/web-api/public;
   try_files $uri $uri/ @demo1;

   location ~ \.php$ {
     fastcgi_split_path_info ^(.+\.php)(/.+)$;
     fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
     fastcgi_index index.php;
     include fastcgi_params;
     fastcgi_param SCRIPT_FILENAME $request_filename;
   }
 }

 location @demo1 {
   rewrite /api/(.*)$ /api/index.php last;
 }
```
