# Copilot instructions for influencer_education_nogaki-team

This file gives concise, practical guidance to AI coding assistants working on this Laravel 9 project.

Key points
- Project type: Laravel 9 application (PHP 8+). Main code lives in `app/`, web routes in `routes/web.php`, views in `resources/views`.
- Database: migrations live in `database/migrations`. Models are in `app/Models` and often use direct DB queries (see `DeliveryTime::getDeliveryTime`).
- Frontend: Vite + `resources/js`, `resources/css`. Use `npm run dev` (vite) for local frontend builds.

What to change and how
- When editing models/controllers, follow PSR-12 style and the project's existing patterns (Eloquent models under `app/Models`, controllers under `app/Http/Controllers`).
- Prefer using Eloquent relationships when appropriate, but preserve existing direct DB queries if they match surrounding code style.
- Example: `app/Models/DeliveryTime.php` currently calls DB::table with an undefined variable `$curriculum_id`. Use the method parameter name consistently (e.g., `$id`) and validate inputs.

Developer workflows (commands)
- Install PHP dependencies: `composer install`
- Create `.env` from `.env.example` if missing; generate key: `php artisan key:generate`
- Run migrations: `php artisan migrate`
- Run tests: `./vendor/bin/phpunit` or `php artisan test`
- Frontend dev: `npm install` then `npm run dev`

Project-specific conventions
- Routes: web-facing routes are declared in `routes/web.php` and frequently map to controller methods in `App\Http\Controllers`.
- Auth: Laravel built-in `Auth::routes()` is used; check `app/Http/Controllers/Auth/*` for customizations.
- Naming: database columns like `curriculum_id` and model names (Curriculum, DeliveryTime) follow conventional Laravel naming.

Integration points and caveats
- Uses Laravel Sanctum and Laravel UI in `composer.json`. Be cautious when changing auth flow.
- Frontend uses `laravel-vite-plugin`; keep Vite config in `vite.config.js` when adding assets.
- Seeders and factories are present under `database/` — prefer adding seed data for test scenarios rather than altering production data.

When unsure, prefer small, well-scoped changes and add tests. Point to files when recommending edits.

Quick examples
- Fix the bug in `app/Models/DeliveryTime.php`: rename method parameter to `$curriculum_id` and use it in the query; or change to Eloquent: `return self::where('curriculum_id', $curriculum_id)->first();`.

If anything here is unclear or you want more project-specific rules (naming, testing patterns, CI), ask for clarification and indicate which area to expand.
