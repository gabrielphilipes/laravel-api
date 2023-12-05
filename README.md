<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400">
    </a>
</p>


#### Install template project

1. Clone the repository, through the command `git clone {{url_repo}}`
2. Copy the file `.env.example` to `.env`, running the command `cp .env.example .env`
3. To run the project, it is necessary to install its Composer dependencies. 
As the project runs with [Laravel Sail (Docker)](https://laravel.com/docs/8.x/sail), it is necessary:
   - Have Docker installed on your machine. [Installation tutorial](https://docs.docker.com/get-docker/)
   - Run the command below to install the project dependencies:
     ```shell
     docker run --rm \
         -u "$(id -u):$(id -g)" \
         -v $(pwd):/opt \
         -w /opt \
         laravelsail/php80-composer:latest \
         composer install --ignore-platform-reqs
     ```
4. To run the project, run the command `./vendor/bin/sail up -d`. The `sail` command will be used a lot
during development. I suggest creating an alias for it in your terminal.
5. Finally, the project will be available at `http://localhost`. The ports used are:
   - 80: HTTP (Laravel)
   - 3306: MariaDB
   - 6379: Redis

Obs.: If you want to use another port, you can change it in the `.env >> APP_PORT, FORWARD_DB_PORT or FORWARD_REDIS_PORT` file.

### Roadmap (WIP)

- [X] Custom README.md
- [x] Prepare Sail
- [X] Install and Configure 
  - [X] [Laravel Pint](https://laravel.com/docs/10.x/pint) (pattern format code)
  - [X] [LaraStan](https://github.com/larastan/larastan) (best practices in code)
  - [X] [Laravel Telescope](https://laravel.com/docs/10.x/telescope) (monitor Laravel App)
  - [X] [Laravel Horizon](https://laravel.com/docs/10.x/horizon) (execute jobs in background)
  - [X] [Pest](https://pestphp.com/) (test)
  - [X] [Husky](https://typicode.github.io/husky/getting-started.html): Pre-Commit (execute Pest, LaraStan and Pint)
  - [X] [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum) (authentication)
  - [X] [LaraDumps](https://laradumps.dev/) (debug)
  - [X] [Laravel Pail](https://github.com/laravel/pail) (logs monitor)
  - [X] [Laravel Auditing](https://laravel-auditing.com/) (audit models)
- [X] Create Arch test: no debugging
- [X] [Laravel Modules](https://nwidart.com/laravel-modules/v6/introduction)
  - [X] Configure: configs, stubs, etc
- [ ] Prepare GitHub Actions, for deploy
