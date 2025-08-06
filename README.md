<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

 
## commands

composer require laravel/ui
php artisan ui vue

npm run dev


# Clean previous installs
rm -rf node_modules package-lock.json
npm cache clean --force

# Reinstall
npm install

https://www.youtube.com/watch?v=erUHpM5lobY

php artisan install:api

npm install admin-lte@4.0.0-rc4


npm install vue-router@4
npm install vue-meta
npm install @vueuse/head

## structure

resources/js/
├── components/           # Reusable Vue components
│   └── Header.vue
│   └── Footer.vue
│
├── layouts/              # Page layouts
│   └── DefaultLayout.vue
│   └── AuthLayout.vue
│
├── pages/                # Main pages
│   └── Home.vue
│   └── About.vue
│   └── Login.vue
│
├── router/
│   └── index.js          # Vue Router setup
│
├── App.vue               # Root component
└── app.js                # Entry point

## install Ziggy for route
composer require tightenco/ziggy
npm install ziggy-js

route('user.show', { id: 5 }) // generates /user/5

git reset --hard origin/main
