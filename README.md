## Check the api ##

```
POST http://www.dianakuzmina.de/api/email/send
Content-Type: application/json

{"theme": "registration", "users": ["email_address1", "email_address2", ...] }
or
{"theme": "welcome", "users": ["email_address1", "email_address2", ...] }
```

## api specification ##
https://github.com/diodincova/mailsender/tree/master/docs/openapi.yaml

## Main functionality ##
The api processes the route $url/api/email/send with the request 
parameters 'theme' (string) and 'users' (array). 
Based on the request parameters, assigns the recipients 
and the letter template, and sends emails.

## Features of the implementation ##
The structure of the main functionality looks like this
![alt text](https://pp.userapi.com/c846216/v846216418/18bff8/P-bt3Fv2fho.jpg)

Templates - /source/templates/emails

cron task looks like this
```
* * * * * php /source/bin/console swiftmailer:spool:send --message-limit=5
```
