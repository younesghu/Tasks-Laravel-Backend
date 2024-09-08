### Tasks Laravel Backend

<hr>

## About 
<p>This is a backend API for a Task Management Application built with Laravel. It follows RESTful principles and includes JWT-based authentication to secure user sessions. This API allows users to create, update, delete, and retrieve tasks while ensuring security and efficiency.</p>

<p><strong>Features:</strong></p>

<ul>
    <li>CRUD operations for tasks (Create, Read, Update, Delete).</li>
    <li>JWT Authentication for secure user sessions.</li>
    <li>Task prioritization and status tracking.</li>
    <li>Error handling for smoother user experience.</li>
    <li>Modular design for easy scalability.</li>
</ul>

<p><strong>Technologies Used:</strong></p>

<ul>
    <li>PHP (8.x)</li>
    <li>Laravel (11.x)</li>
    <li>JWT Authentification</li>
    <li>MySQL database</li>
    <li>RESTful API</li>
</ul>

## Installation & Setup

<p>To get the project up and running, follow these steps:</p>

<ul>
  <li><strong>Clone the repository:</strong></li>

  <pre><code>bash
git clone https://github.com/younesghu/Tasks-Laravel-Backend.git
cd Tasks-Laravel-Backend
  </code></pre>

  <li><strong>Install dependencies:</strong></li>

  <pre><code>bash
composer install
  </code></pre>

  <li><strong>Create a <code>.env</code> file:</strong></li>

  <pre><code>bash
cp .env.example .env
  </code></pre>

  <p>Set up your environment variables in <code>.env</code> (e.g., database credentials, JWT secret).</p>

  <li><strong>Generate an application key:</strong></li>

  <pre><code>bash
php artisan key:generate
  </code></pre>

  <li><strong>Run the database migrations:</strong></li>

  <pre><code>bash
php artisan migrate
      or
php artisan migrate:fresh --seed
  </code></pre>
  
<strong>Optionally, you can use the <code>migrate:fresh --seed</code> command to reset your database and seed it with sample data. This will include a user with the following details:</strong>

<ul>
  <li><strong>Name:</strong> Test User</li>
  <li><strong>Email:</strong> test@example.com</li>
  <li><strong>Password:</strong> password</li>
</ul>

  <li><strong>Start the development server:</strong></li>

  <pre><code>bash
php artisan serve
  </code></pre>
</ul>

## Use Case Diagram

![Task App Use Case](https://github.com/user-attachments/assets/2c36cb55-4d34-46d4-bbb4-ad9ecda8a5a0)

## Use Class Diagram

![Task App Use Class Diagram](https://github.com/user-attachments/assets/845ebea0-7799-4bf1-86fa-412d4582cc7a)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

