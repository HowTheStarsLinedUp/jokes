# jokes

## Command "download"
Download jokes and save them to a file.
### Options:
**-c, --count**<br>
Number of jokes.<br>
Default 1.<br><br>
**-f, --file**<br>
File path to store jokes. You can use json or csv.<br>
Default 'PROJECT_ROOT/jokes.json'.<br>
Can be configured in the configuration .env file.<br><br>
**-s, --source**<br>
The joke source alias. Where it comes from.<br>
Default 'chucknorris' or 'dadjokes'.<br>
Can be configured in the configuration .env file.<br>
### Example:
```php
php ./index.php download
php ./index.php download -c 6 -s dadjokes -f ./tests/file.csv
```

## Command "generate"
Generates Persons and Marks.
### Arguments:
**personCount**<br>
How many persons to generate.<br><br>
**maxMarksPerJoke**<br>
Maximum random marks per joke.<br><br>
**fromDate**<br>
Date to generate marks from. Format '2022-01'.<br><br>
**toDate**<br>
Date to generate marks to. Format '2022-12'.<br><br>
**jokesSrcFile**<br>
Path to jokes storage file.
### Options:
**-m, --maxMark**<br>
Maximum mark value. Default 10.<br><br>
**-f, --file**<br>
File path for saved marks.<br>
Default 'PROJECT_ROOT/marks.json'.<br>
Can be configured in the configuration .env file.<br>
### Example:
```php
php ./index.php generate 100 10 ./tests/jokesExample.json '2022-01' '2022-12'
php ./index.php generate 100 10 ./tests/jokesExample.json '2022-01' '2022-12' -m 15 -f ./test/folder/file.json
```

## Command "show"
Downloads joke and print it to console.
### Options:
**-s, --source**<br>
The joke source alias. Where it comes from.<br>
Default 'chucknorris.
Can be configured in the configuration .env file.
### Example:
```php
php ./index.php show
php ./index.php show -s dadjokes
```

## Command "statistics"
Shows statistics.
### Arguments:
**marksSrcFile**<br>
Path to marks storage file.<br>
Default 'PROJECT_ROOT/jokes.json'.<br>
Can be configured in the configuration .env file.
### Example:
```php
php ./index.php statistics ./tests/marksExample.json
```
