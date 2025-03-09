# Laravel Auto Cache Clear

A Laravel package that automatically clears cache for Eloquent models using PHP attributes. Define cache-clearing behavior directly above your model with the `#[ClearCacheWhen]` attribute, and let the package handle the rest.

---

## Features

- **Attribute-Based Configuration**: Use the `#[ClearCacheWhen]` attribute to define when cache should be cleared for a model.
- **Automatic Cache Clearing**: Automatically clears cache when specified model events occur.
- **Dynamic Cache Keys**: Define custom cache keys using placeholders like `{model}` and `{id}`.
- **Static Cache Keys**: Clear static cache keys (e.g., `"users"`) when model events occur.
- **Flexible and Extensible**: Works with any Eloquent model.

---

## Installation

### 1. Install the Package

```bash
composer require zidbih/laravel-auto-cache-clear
```

---

## Usage

### 1. Add the `#[ClearCacheWhen]` Attribute to Your Model

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zidbih\LaravelAutoCacheClear\Attributes\ClearCacheWhen;
use Zidbih\LaravelAutoCacheClear\Traits\AutoClearsCache;

#[ClearCacheWhen(['created', 'updated', 'deleted'], cacheKey: 'user:{id}:details', staticKeys: ['users'])]
class User extends Model
{
    use AutoClearsCache;
}
```

#### Attribute Parameters

- `events`: Model events that should trigger cache clearing (e.g., `['created', 'updated', 'deleted','restored']`).
- `cacheKey`: Cache key pattern (default: `{model}:{id}`). You can use placeholders like `{model}` and `{id}`.
- `staticKeys`: An array of static cache keys to clear (e.g., `['users','posts']`).

### 2. Use the `AutoClearsCache` Trait

```php
use Zidbih\LaravelAutoCacheClear\Traits\AutoClearsCache;

class User extends Model
{
    use AutoClearsCache;
}
```

### 3. Cache Data in Your Application

```php
use Illuminate\Support\Facades\Cache;

// Cache a list of users
$users = Cache::remember('users', 60, function () {
    return User::all();
});

// Cache a single user
$user = Cache::remember('user:1:details', 60, function () {
    return User::find(1);
});
```

When a user is created, updated, or deleted, the cache keys `user:1:details` and `users` will automatically be cleared.

---

## Example Workflow

### 1. Define the Model

```php
#[ClearCacheWhen(['created', 'updated', 'deleted'], cacheKey: 'user:{id}:details', staticKeys: ['users'])]
class User extends Model
{
    use AutoClearsCache;
}
```

### 2. Cache Data

```php
$users = Cache::remember('users', 60, fn () => User::all());
$user = Cache::remember('user:1:details', 60, fn () => User::find(1));
```

### 3. Trigger Model Events

When a user is created, updated, or deleted, the following will be cleared:

- The dynamic key: `user:1:details`
- The static key: `users`

---

## Contributing

Contributions are welcome! Feel free to [open an issue](https://github.com/medmahmoudhdaya/laravel-auto-cache-clear/issues) or submit a pull request.

---

## License

This package is open-source software licensed under the [MIT license](LICENSE).

---

## Credits

Developed by **Med Mahmoud Hadaya (zidbih)**  
Inspired by the Laravel community.
