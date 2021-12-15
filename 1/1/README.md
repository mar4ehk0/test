# Usage
Start containers by command `docker-compose up --build -d`

For the console test, connect to the php container with the command `docker-compose exec php bash`, change the directory` cd public` and you can execute the command `php index.php add sku1 12`

For a browser test, add the line `127.0.0.1 mysite.local` to the hosts file, open Postman or similar software and send the data using the POST method, the available keys are command, sku, qty
