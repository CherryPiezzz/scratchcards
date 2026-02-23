# About
Please visit the pull request for the solution at this link: [Scratchcards PR](https://github.com/CherryPiezzz/scratchcards/pull/4)

The branch for the PR is `feature_scratchcards_3`.

## Instructions
1. Clone the repository:
```
git clone https://github.com/CherryPiezzz/scratchcards.git
cd scratchcards
```
2. Install composer:
```
composer install
```
3. If needed set up environment:
```
cp .env.example .env
php artisan key:generate
```
4. Checkout branch:
```
git checkout feature_scratchcards_3
```
5. Move the `input.txt` file [here](https://git.evoluted.net/evoluted-public/php-engineer-2026-technical-test/-/blob/main/input.txt?ref_type=heads) to:
```
storage\app\public
```
6. For the tests to work you'll need to create a test input file as follows:
   i. Make the file below using a method you're comfortable with i.e. touch/vim:
```
storage\app\private\sample_scratchcards.txt
```
   ii. Add the following contents to the file and save it:
```
Card   1: 41 48 83 86 17 | 83 86 6 31 17 9 53 48
Card   2: 13 32 20 16 2 | 20 16 2 97 13 32 24 61
Card   3: 1 21 53 59 44 | 69 82 63 72 16 4 17 36
Card   4: 41 92 73 84 69 | 59 84 76 36 92 39 69 14
Card   5: 87 26 16 66 23 | 88 26 91 40 16 66 45 6

```
7. Run the command:
```
php artisan check:scratchcards
```
8. Run the tests:
```
php artisan test
```

## Author
Adam Hague