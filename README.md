## Задание ##

Нужно создать ручку REST API для доставки электронной почты (транзакционная электронная почта). 
Ручка должна позволять клиенту указывать получателей электронной почты и используемую тему.

Дополнительно:
● иногда доставка электронной почты может занять много времени (> 5 секунд), что можно сделать, чтобы сделать это быстрее? Каковы недостатки вашего решения? 
● мы хотели бы добавить как можно больше тем, как бы вы структурировали услугу с этим требованием?

## Реализация ##

на ручку $url/api/send/email отправляется запрос с post данными users и theme, 
App\Infrastructure\Controller\Rest\MessageController - контроллер, который обрабатывает запрос
и запускает рассылку