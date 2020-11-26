# JSONlogin
Minimal HTML login page that uses a json file as a database

* Minimal login system that requires a new user to input username, password and then contact the webadmin for manual review. The user input has been automatically encrypted and stored into ```.toAddDb```. The webadmin then has to add the entry in the "database" file, which is called ```.user_db```, in the same folder as the rest of the files.
* There is also a ```.access_db``` that keeps track of login attempts, the login.php scripts checks how many times someone has tried to login and might deny access for 15 minutes (by default) if there has been more than 3 failed attempts in less than 15 minutes.  
* All "database" files should be hidden, as to prevent anyone from accessing them via the webserver.
* The said files need to be created and writeable by the webserver process with"
```bash
touch .access_db .toAddDb .user_db
```

To prevent user from accessing a page, put this text on top of the file:
```php
<?php
session_start();
if (isset($_SESSION['login_user']) == false || empty($_SESSION['login_user'])) {
    header("Location:login.html");
}
?>
```
and rename your file to ```.php```

The `jLoginaze.sh` shell script just inserts the above code at the top into the file to be protected whose filename is provided as a CLI argument to it like:
```bash
jLoginaze.sh file_to_be_protected.php
```

If you want to protect more than just a web page, you should have something similar to this (done in Nginx):
```
location ^~ /yourlocation {
            index index.php;
            set $tmp 0;

            if ($http_cookie !~* "session_key_active"){
                set $tmp 1;
            }
            if ( $request_filename ~ "login.*"){
                set $tmp 0;
            }

            if ($tmp = 1){
                rewrite ^/.* https://mysite.com/yourlocation/login.html last;
            }

            location ~ \.php$ {
                fastcgi_pass unix:/run/php-fpm/php-fpm.sock;
                fastcgi_index index.php;
                include fastcgi.conf;
                fastcgi_param SCRIPT_FILENAME $request_filename;
                try_files $uri =404;
            }
        }

```

Backwards compatibility till PHP 5.3.7 provided using [password_compat](https://github.com/ircmaxell/password_compat) library

WIP, more clear instructions & coming... sometime in the future :)
