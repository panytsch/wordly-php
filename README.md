# wordly

## How to run

```docker-compose up --build``` in root directory to build app.

When it's done, run ```docker-compose exec php bash -c 'php artisan game:start'``` to start game

## About

It's classic wordly game but with simpler logic
game has a random 5 letters word which you should guess having 5 tries.

if letter is on it's place letter will have green background. If letter exists in word but place is different - white background. If letter doesn't exists - default background

Words are taken from external APIs

Supported languages are English and Spanish

## Saves

I added also progress saving if you're in the middle of the game

So if you press ctr+c you'll be asked to save progress

## Enjoy!
