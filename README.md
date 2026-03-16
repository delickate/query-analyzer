# query-analyzer

A Laravel package to interactively analyze and run SQL queries on your database with ease.

---

## Features

- **List all database tables** in a convenient sidebar.
- **Show table columns dynamically** on clicking each table.
- **Write and execute raw SQL queries** using a simple query editor.
- **Display query results** in a clean, scrollable tabular format.
- Easy to **publish configuration and stub files** to your Laravel application.
- Built with a minimal setup to integrate smoothly into existing Laravel projects.

---

## Installation

Install the package via Composer:

```bash
> composer require delickate/query-analyzer
> php artisan vendor:publish --tag=query-analyzer --force
```

Copy following routes to routes/web.php

```bash
use App\Http\Controllers\QueryAnalyzerController;


Route::get('/query-analyzer', [QueryAnalyzerController::class,'index']);

Route::get('/query-analyzer/tables', [QueryAnalyzerController::class,'tables']);
Route::get('/query-analyzer/columns/{table}', [QueryAnalyzerController::class,'columns']);
Route::post('/query-analyzer/execute', [QueryAnalyzerController::class,'execute']);
```

# 🤝 Contributing

Contributions are welcome.

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Open a Pull Request

---

# 📄 License

This package is open-sourced software licensed under the **MIT license**.

---

# 🏢 Maintained By

Developed and maintained by **Delickate**.