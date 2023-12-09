### Routes

Project routes must follow the Laravel route pattern, specifically the
[Resource Controllers](https://laravel.com/docs/10.x/controllers#actions-handled-by-resource-controller) routes.

Following the pattern, we can use the `Route::resource('example')` method to create the routes, according to the
table below:

| Method | URI | Action        | Route Name |
| --- | --- |---------------| --- |
| GET | /example | index         | example.index |
| GET | /example/create | form to store | example.create |
| POST | /example | store         | example.store |
| GET | /example/{example} | show          | example.show |
| GET | /example/{example}/edit | form to edit  | example.edit |
| PUT/PATCH | /example/{example} | update        | example.update |
| DELETE | /example/{example} | destroy       | example.destroy |

To create routes that do not follow the standard, use the `Route::get('example')` or `Route::post('example')` method,
for example.

For more information, see the [Laravel routing documentation](https://laravel.com/docs/10.x/routing)
and/or the [Resource Controllers documentation](https://laravel.com/docs/10.x/controllers#resource-controllers).

