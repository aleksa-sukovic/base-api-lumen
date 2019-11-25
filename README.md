# Base API

'Base API' is foundation aimed to provide solid starting point for any project that fits the specific needs.

This project was done as an assignment task for my "Software Engineering" college course.

## Features

Main idea was to explore principles of modeling software to create an abstract base that could serve as starting point for many future projects that fit some predefined needs.

This is web project. It is separated into 2 main parts:
1. Backend API (this repository).
2. [Frontend Admin Panel](https://github.com/aleksa-sukovic/base-admin-angular).

Why separate projects into two distinct parts? Many reasons:
* Both parts can live on separate servers.
* Easier to maintain.
* Not bound to specific technologies (API implementation can change, as long as its endpoints remain the same).
* Ability to use API for other clients other that admin panel (websites, mobile apps).

This project was good example for showcasing common modeling techniques, especially those used in world of web applications.

### What is included

Numerous of features are included representing the core of this project. Adding new objects should be as straightforward as extended core classes. Idea was to be able to extend the current base making no or as little modifications to it as possible.

1. Main architecture:
   - Controllers.
   - Repositories.
   - Validators.
   - Transformers.
   - Filters / Search for individual objects.
2. User management.
   - User profile.
   - User groups (authorization).
3. Full authentication flow using JWT.
4. Locale management.
5. Management of translatable objects.
6. CORS Handling.

## What have I learned

* A lot of software modeling techniques. (more than I can list)
* Laravel/Lumen.
* PHP.
