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
- In response to the first bonus question, I decided that the most obvious 
thing was to implement sending emails through the queue. At first, I wanted to do 
it either through a database or with the help of a message broker 
(for example, rabbitmq). But then I decided that this does not fully 
demonstrate my ability to use the framework documentation and Google :)) 
so I used the library 'swiftmailer', which can put messages in a queue (spool)
and gradually send them by cron task. In my opinion, the disadvantage of such 
an approach would be a time gap in sending the letter to the first 
recipient in the queue and the last one. 

- The second question took me by surprise. In addition to the obvious answer 
for me - using template engine to generate different letter themes - 
did not come up with anything. I used Twig with preset masks for data 
substitution, which will be different in different letters. 
Now there are 2 templates: 'welcome' and 'registration'. Most likely, 
there is some other unobvious implication for me in this question :(

I hope I created a clear code structure. 
The structure of the main functionality looks like this
![alt text](https://pp.userapi.com/c846216/v846216418/18bff8/P-bt3Fv2fho.jpg)

Templates - /source/templates/emails

cron task looks like this
```
* * * * * php /source/bin/console swiftmailer:spool:send --message-limit=5
```