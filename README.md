# Medicine Warehouse Management System

This is a comprehensive Medicine Warehouse Management System built with Laravel. The system facilitates the management of medicine inventories and orders through user roles and permissions. It is designed following SOLID principles and utilizes the Repository Design Pattern to ensure clean and maintainable code.
## Features

### User Roles

1. **Warehouse Owner**:
    - Create and manage accounts for employees.
    - Assign roles to employees (Warehouse Supervisor, Order Supervisor).

2. **Warehouse Supervisor**:
    - Responsible for entering new medicines into the system.
    - Manage medicine quantities and warehouse operations.

3. **Order Supervisor**:
    - Handle medicine order requests from pharmacists.
    - Manage order processing and fulfillment.

4. **Pharmacist**:
    - Browse the entire system.
    - Place medicine orders from the desired warehouse.

### Key Technologies

- **Laravel**: The PHP framework used for building the application.
- **SOLID Principles:**
  - The project adheres to SOLID principles to ensure a scalable and maintainable codebase
- **Repository Design Pattern**: 
  - The application follows the Repository Design Pattern to abstract the data layer, making it easier to manage data access logic and promote code reusability.
- **JWT (JSON Web Token)**: Used for user authentication and token generation.

## Installation and Setup

To get started with the medicine Warehouse Management System, follow the steps below:

1. **Clone the repository**:
   ```bash
   git clone https://gitlab.com/sariafba/medicinez.git
2. **Install dependencies**:
   ```bash
   composer install
3. **Environment setup**:
- Copy the .env.example file to .env and update the necessary environment variables, such as database credentials.
   ```bash
  cp .env.example .env
4. **Generate application key**:
    ```bash
   php artisan key:generate
5. **Run migrations and seed the database**:
   ```bash
   php artisan migrate:fresh --seed
