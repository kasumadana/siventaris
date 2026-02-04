# SIVENTARIS (Sistem Inventaris Sekolah)

SIVENTARIS is a comprehensive School Inventory Management System designed to streamline the borrowing and tracking of tools and equipment across various departments (Jurusan). It provides a seamless experience for Students to book items and for Toolmen/Admins to manage stock and loans.

## Tech Stack

-   **Framework**: [Laravel 11](https://laravel.com/) (PHP Framework)
-   **Admin Panel**: [Filament v3](https://filamentphp.com/)
-   **Frontend**: [Livewire 3](https://livewire.laravel.com/) + Blade + Tailwind CSS
-   **Database**: MySQL
-   **Styling**: Tailwind CSS (Default)

## Installation Guide (Zero to Hero)

Follow these steps to set up the project on your local machine:

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/username/siventaris.git
    cd siventaris
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    -   Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    -   Configure your database credentials in `.env`:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=siventaris
        DB_USERNAME=root
        DB_PASSWORD=
        ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrate and Seed Database**
    -   Run migrations and populate the database with default data (Roles, Users, Categories, Items):
        ```bash
        php artisan migrate:fresh --seed
        ```

6.  **Build Assets**
    ```bash
    npm run build
    ```

7.  **Run the Server**
    ```bash
    php artisan serve
    ```
    Access the app at `http://127.0.0.1:8000`.

## Default Accounts

Use these credentials to test different roles:

| Role | Email | Password | Access |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@sekolah.sch.id` | `password` | Full Access (Filament Panel) |
| **Toolman** | `toolman@sekolah.sch.id` | `password` | Manage Loans & Items (Filament Panel) |
| **Student** | `siswa@sekolah.sch.id` | `password` | Frontend Booking & Dashboard |

## Git Workflow Rules

To ensure a smooth collaboration, please follow these rules:

1.  **Pull First**: Always pull the latest changes before starting work.
    ```bash
    git pull origin main
    ```
2.  **Create a Branch**: Create a new branch for your feature or fix.
    ```bash
    git checkout -b feature/your-feature-name
    ```
3.  **Commit Often**: Write clear commit messages.
    ```bash
    git commit -m "feat: add booking validation logic"
    ```
4.  **Push and PR**: Push your branch and create a Pull Request on GitHub.
    ```bash
    git push origin feature/your-feature-name
    ```

## Key Features Logic

-   **Inventory Sync**: Stock is automatically calculated based on the count of `ItemUnits` with status `available`. See `ItemUnitObserver`.
-   **Borrowing Cycle**:
    -   Student books item -> Status `pending`
    -   Toolman approves (Handover) -> Status `active` -> ItemUnit becomes `borrowed`
    -   Student returns -> Status `returned` -> ItemUnit becomes `available`
-   **Security**: Students are strictly blocked from the Admin Panel via `User::canAccessPanel()`.

---

**Happy Coding! 🚀**
