### Models

#### Create a model

To create a model, run the command `sail a make:model Client/Annotations -m`. The `-m` flag will create a
migration file for the model.

For better project organization, we suggest that you ALWAYS create your models within a folder with the
module name. Like this:
- If there are models with the same name, there will be no conflict;
- New models, directly related to the module, will be grouped;
- Facilitates project organization;
- New developers, who do not know the project, can better understand its structure.

When creating models/migrations, it is VERY IMPORTANT that you follow the following rules:
- Use the model file in the singular;
- Follow the CamelCase standard;
- Create, in the model, ALL relationships with other tables;
- Use `softDelete` in ALL models;
- In migration, create the table name in the plural;
- Analyze the table and create indexes, relationships, etc.;
- Use the [Laravel Auditing] package (https://laravel-auditing.com/) to audit the models;

#### Model customizations

In the project models, there are some customizations that must be followed:
- All models must extend the class `App\Models\AppModel`, as it contains the project settings,
  where they can be enabled, according to need. We STRONGLY suggest you review the file
  `AppModel.php`.
- Some `scopes` are already prepared in `AppModel`. We suggest that you enable the
  [Laravel Scopes](https://laravel.com/docs/10.x/eloquent#query-scopes), according to need, to facilitate
  the queries to be executed.

#### Model audit

To audit the models, we use the [Laravel Auditing](https://laravel-auditing.com/) package. For that,
the model must use the `OwenIt\Auditing\Auditable` trait and implement the interface
`OwenIt\Auditing\Contracts\Auditable`.

No action beyond the steps above is required. The package is already configured and customized to audit
all models.

#### IMPORTANT
**Project stubs have been updated to now create the model, with documentation customizations!**
