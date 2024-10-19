# Game Vault

Game vault is an example video game aggregator adapted from a [course at Laracasts](https://laracasts.com/series/build-a-video-game-aggregator). 

Code has been updated to [Laravel Livewire v3](https://livewire.laravel.com/) and [IGDB API v4](https://api-docs.igdb.com/#getting-started).

<br/>
<img width="1727" alt="Screenshot 2024-10-19 at 12 07 33 PM" src="https://github.com/user-attachments/assets/507efbf6-1dbd-48f5-bc80-ddfa911de9dc">
<br/>

## Installation Instructions

- Clone the repo and `cd` into it.
- `composer install`
- `npm install`
- `npm run dev`
- Rename or copy `.env.example` file to `.env`.
- Set your `TWITCH_API_CLIENT_ID` and `TWITCH_API_CLIENT_SECRET` in your .env file. Follow the [getting start guide](https://api-docs.igdb.com/#getting-started).
- `php artisan key:generate`
- `php artisan serve` or use [Laravel Herd](https://herd.laravel.com/).
- Visit localhost:8000 in your browser.
- To refresh cached data: `php artisan cache:clear`.
