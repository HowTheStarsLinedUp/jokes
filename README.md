#
# jokes

##
## Command "download"
Downloads jokes and saves them to a file.

### Options:
- --count | -c - (optional) Number of jokes.
- --source | -s - (optional) The joke source alias. Where it comes from. Default ENV['CHUCKNORRIS_API_ALIAS'].
- --file | -f - (optional) File path to store jokes. You can use json or csv. Default ENV['JOKES_FILE'].

### Example:
php ./index.php download -c 1 -s chucknorris -f ./tmp/test/folder/file.csv

##
## Command "generate"
Generates Persons and Marks.

### Arguments:
- personCount - (required) How many persons to generate.
- maxMarksPerJoke - (required) Maximum random marks per joke.
- jokesSrcFile - (required) Path to jokes storage file.
- from - (required) Date to generate marks from.
- to - (required) Date to generate marks to.

### Options:
- --maxMark - (optional) Maximum mark value. Default = 10.
- --file | -f - File path for saved marks. Default ENV['MARKS_FILE'].

### Example:
php ./index.php generate 100 10 ./jokes.json '2022-01' '2022-12'

##
## Command "show"
Downloads joke and print it to console.

### Options:
- --source | -s - (optional) The joke source alias. Where it comes from. Default ENV['CHUCKNORRIS_API_ALIAS'].
### Example:
php ./index.php show -s chucknorris<br />
php ./index.php show -s dadjokes

## Command "statistics"
Shows statistics.

### Arguments:
- marksSrcFile - (optional) Path to marks storage file. Default ENV['MARKS_FILE'].

### Example:
php ./index.php statistics
