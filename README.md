## Задание ##

Нужно создать ручку REST API для доставки электронной почты (транзакционная электронная почта). 
Ручка должна позволять клиенту указывать получателей электронной почты и используемую тему.

Дополнительно:
● иногда доставка электронной почты может занять много времени (> 5 секунд), что можно сделать, чтобы сделать это быстрее? Каковы недостатки вашего решения? 
● мы хотели бы добавить как можно больше тем, как бы вы структурировали услугу с этим требованием?

## Реализация ##

на ручку $url/api/email/send отправляется запрос с post данными users и theme, 
App\Controller\MessageController - контроллер, который обрабатывает запрос
и запускает рассылку

## Что смущает ##

- нужно ли добавить обработку других ответов от сервера
- скорее всего, не хватает кучи проверок на ошибки с добавлением вывода исключений и errors
- на что можно написать тесты?