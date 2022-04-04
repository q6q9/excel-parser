## Description
How it uses:

https://youtu.be/5gpGH6EDn2g


## Installation:

After git cloning exec:
If it's need give permissions
``` 
cp .env.example .env ;
docker-compose up -d --scale queue=2 ;
docker exec -it excel-parser-php composer install ;
docker exec -it excel-parser-php npm install ;
docker exec -it excel-parser-php php artisan migrate ;
docker exec -it excel-parser-php php artisan migrate --database=test;
docker exec -it excel-parser-php npm run watch; 
```

For testing: 
```
docker exec -it excel-parser-php php artisan test;
```

## Basic logic:

Controllers:
* <a href="https://github.com/q6q9/excel-parser/blob/main/app/Http/Controllers/ExcelController.php">ExcelController</a>

* <a href="https://github.com/q6q9/excel-parser/blob/main/app/Http/Controllers/RowsController.php">RowsController</a>

Events:
* <a href="https://github.com/q6q9/excel-parser/blob/main/app/Events/Processing.php">Processing</a>

* <a href="https://github.com/q6q9/excel-parser/blob/main/app/Events/ExcelParsing.php">ExcelParsing</a>

Listeners:
* <a href="https://github.com/q6q9/excel-parser/blob/main/app/Listeners/ExcelParser.php">ExcelParser</a>

Imports: 

* <a href="https://github.com/q6q9/excel-parser/blob/main/app/Imports/RowImport.php">RowImport</a>

View:

* <a href="https://github.com/q6q9/excel-parser/blob/main/resources/views/welcome.blade.php">welcome.blade.php</a>

Tests:

* <a href="https://github.com/q6q9/excel-parser/blob/main/tests/Unit/ExcelParserTest.php">ExcelParserTest</a>
