<h1>Property API</h1>

#Installation:
1. run `docker compose up --build` if you have Docker.
1. run the following command if you used Docker: `cp -R /backup/* ./storage/` from inside `Laravel` container.
1. copy `.env.example` to `.env`
1. Edit the database credentials, the default db credentials for Docker are: 
   Username: root
   Password: root
   Database: laravel
1. run `composer install`
1. run `php artisan migrate`
1. if you want dummy data, run `php artisan db:seed`
1. run 'npm install'
1. run 'npm run dev' or `npm run prod` for production

#Usage
1. Navigate to `/`
1. You will see a list of properties.
1. If you want to delete a property, you need to be authenticated:
   1. Register by filling the form at `/register`.
   1. Go to the property page by clicking "View" on any of the properties.
   1. click "Delete"

#Fetching Properties:
1. Fill `API_KEY` and `API_URL` with the appropriate values, API_URL should end with `/api`, for example `https://example.com/api`
2. run the command `php artisan properties:fetch`
