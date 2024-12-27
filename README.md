# Orkideh Banking API Project

## Project Overview
The Orkideh Banking API system has been developed to handle core banking functionalities, including account transactions, card transfers, and validations. This project is containerized using Docker for seamless deployment and scalability, and includes CI pipelines using GitHub Actions for code quality assurance.

---

## Key Features
1. **Banking API System:**
    - Supports functionalities such as:
        - Transferring funds between cards.
        - Validating card numbers and sufficient balances.
    - Follows robust validation rules for secure transactions.

2. **Localization:**
    - Fully supports multi-language messages for both Persian (fa) and English (en).
    - Localized messages ensure clear communication with users in their preferred language.

3. **API Implementation:**
    - Built using Laravel.
    - Relies on Laravel FormRequests for request validation.
    - Exception handling implemented for insufficient balances and other common errors.

4. **CI Pipeline:**
    - Integrated with GitHub Actions.
    - Runs the following checks:
        - `./vendor/bin/phpstan --memory-limit=2048M analyse` for static analysis.
        - `./vendor/bin/pint --test` for code style checks.
        - `php artisan test` for unit and feature tests.

5. **Containerized Environment:**
    - The project is fully Dockerized for easy setup and environment consistency.
    - Command to build and run the container:
      ```bash
      sudo docker compose up -d --build
      ```
    - To access the running container:
      ```bash
      sudo docker exec -it -u www-data orkideh_app bash
      ```
6. **Api Endpoint:**
    - Transactions
      - ```POST /transactions/transfer``` : Transfer funds between cards.
      - ```GET /transactions/top-users``` : Get a list of top users.
    - Telescope
      - ```/telescope```: Access the Laravel Telescope debugging tool (if enabled).

---

## Deployment Instructions
1. Clone the repository to your local machine.
   ```bash
   git clone <repository_url>
   cd <project_directory>
   ```

   
2. Create .env
   ```bash
   cp .env.example  .env
   ```
   
3. Build and start the container using Docker Compose:
   ```bash
   sudo docker compose up -d --build
   ```
   - By default, the application will be accessible at: ```http://127.0.0.1:8035/```
   - Please note that due to the execution of the ENTRYPOINT ["./run.sh"] script, it might take a few seconds for the application to fully load.
   - The commands executed in the run.sh file are:
   ```bash
    composer install
    npm i
    npm run build

    # Remove this line in production environment
    php artisan key:generate

    php artisan migrate --seed
    php artisan storage:link
   ```



4. Access the application through the container by using the following command:
   ```bash
   sudo docker exec -it -u www-data orkideh_app bash
   ```
5. Test the API endpoints using tools such as Postman or cURL.
6. For email functionality, ensure the queue worker is running inside the container:
   ```bash
   php artisan queue:work
   ```

---

## Testing and Quality Assurance
1. **Static Analysis:**
    - Ensure code meets PHP standards using PHPStan.
   ```bash
   ./vendor/bin/phpstan --memory-limit=2048M analyse
   ```
2. **Code Style Checks:**
    - Maintain clean and consistent code with Pint.
   ```bash
   ./vendor/bin/pint --test
   ```
3. **Unit and Feature Tests:**
    - Verify functionality with Laravel’s testing suite.
   ```bash
   php artisan test
   ```


---

This README provides an overview of the Orkideh Banking API project, its setup instructions, and guidelines for testing and deployment.

