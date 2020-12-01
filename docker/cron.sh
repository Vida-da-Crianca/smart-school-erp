# SHELL=/bin/bash

# m h dom mon dow   user   command
* * * * * /usr/local/bin/php /app/man schedule:run >/dev/null 2>&1