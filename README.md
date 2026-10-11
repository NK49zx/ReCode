# ReCode

A question-and-answer platform for programmers, in the spirit of Stack Overflow.
Users ask questions with code snippets and tags, answer each other, vote, and
bookmark posts. Admins manage users, content and reports from a separate
dashboard.

Built with Laravel 12, Blade, Tailwind CSS and DaisyUI.

## Features

**Questions and answers**
- Ask, edit and delete questions, each with an optional code snippet and
  multiple tags.
- Answer questions and edit or delete your own answers. The person who asked
  can mark one answer as accepted, which is enforced by a policy.
- Upvote or downvote questions and answers, with one vote per user per post.
- Bookmark questions to read later.
- View counts on questions.

**Discovery**
- Live search: questions are matched by title as you type, using a JSON
  endpoint that returns the top 5.
- Tag pages: browse all tags, or all questions under one tag.

**User profiles**
- Edit your profile (username, first and last name, bio) and change your
  password.
- Separate pages for your questions, answers, upvoted posts and bookmarks.
- A personal stats page.

**Moderation and admin**
- Users can report a user, question or answer, with a reason.
- Admins review reports (`pending` → `reviewed` / `resolved` / `rejected`), add
  notes, and ban or unban users. Banned users are logged out automatically by
  the `LogoutBannedUser` middleware.
- Admin dashboard: user management (edit, delete), question management, and
  analytics. Analytics show totals, answered questions, the top 5 tags, and a
  14-day sign-up chart (Chart.js).
- Role flags: `is_admin`, `is_super_admin`, and `managed_by` for admin
  hierarchy.

**Accounts**
- Registration, login, email verification and password reset, through Laravel
  Breeze.

## Tech stack

| Layer | Tools |
|---|---|
| Backend | PHP 8.2, Laravel 12, Eloquent ORM, policies and gates, middleware |
| Frontend | Blade, Tailwind CSS 3, DaisyUI 5, Alpine.js, jQuery, Select2 (tag picker), Chart.js |
| Build | Vite 6 |
| Database | SQLite by default (any Laravel-supported database works) |
| Auth | Laravel Breeze |
| Tests | PHPUnit 11 (in-memory SQLite) |

## Data model

```
users ──< questions ──< answers ──< code_blocks
  │          │  │          │
  │          │  └──< question_tag >── tags
  │          │
  ├──< bookmarks >─────────┤ (user, question) unique
  ├──< question_votes ─────┘ (user, question) unique, up/down
  ├──< votes ── answers      (user, answer)   unique, up/down
  └──< reports               (reporter → user | question | answer)
```

## Getting started

Requirements: PHP 8.2+, Composer, Node.js 18+ and npm.

```bash
git clone <repo-url> ReCode
cd ReCode
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
composer run dev
```

`composer run dev` starts the web server, queue worker, log viewer and Vite
together. Open http://localhost:8000.

The seeder creates a test user (`test@example.com`) and 87 tags covering
languages, frameworks, databases, DevOps and testing tools.

### Make an admin

```bash
php artisan tinker
>>> App\Models\User::where('email', 'you@example.com')->update(['is_admin' => true]);
```

Then visit `/admin`.

## Project structure

```
app/Http/Controllers/    Question, Answer, Vote, Bookmark, Tag, Search, Report, Profile*, Admin*
app/Http/Middleware/     AdminMiddleware, LogoutBannedUser
app/Models/              User, Question, Answer, Tag, Vote, QuestionVote, Bookmark, Report, CodeBlock
app/Policies/            AnswerPolicy
database/migrations/     schema for all tables above
database/seeders/        test user and tag list
resources/views/         Blade pages: questions, answers, tags, profile, admin, auth
public/js/               live search, answer editor, tag toggle, charts
routes/web.php           public, authenticated and admin routes
```

## Running tests

```bash
composer test
```

## License

MIT
