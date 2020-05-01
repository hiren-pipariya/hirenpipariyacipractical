## instruction for run project

1. Set permission for `storage` and `bootstrap/cache` directories (should be writable by web server)
2. copy `.env.example` file to `.env` file (create .env file if file not exist)
3. run command (in terminal or console) : `php artisan key:generate` (for generate application key)
4. setup database credentials in `.env` file
5. run command (terminal or console) : `php artisan serve` for start project (link http://127.0.0.1:8000 where project served) or can be access by `<HOST>::<PORT>/<PATHTOPROJECT>/public` if project is whithin apache server root directoru or within htdocs of xampp
6. run command (terminal or console) : `php artisan storage:link` (to create symbolic link of storage to public)
7. run command (terminal or console) : `php artisan migrate` (to create table in database)


**Note:** Command should be run from the root directory of project.

**Admin User Credentials:**
email:admin@admin.com
password:123456789

Only admin can add,update,delete skills
