### How to run:

#### User upload challenge
1. Clone repository.
2. Open a terminal.
3. Navigate into the cloned repository and run `composer install` to install PDO extension for database interactions
4. To setup and populate the database:
   1. Run `php user_upload.php --create_table` to create the database and the table.
   2. Run `php user_upload.php --file users.csv` to populate the table.
   3. Run `php user_upload.php --help` to see a list of flags that can be used.

#### Foobar challenge
1. Navigate into the cloned repository and run `php foobar.php`


### Assumptions:
1. The `--create_table` flag has to be ran before `--file` or `--dry_run`
2. Running `--create_table` flag when table already exists creates a new table.
3. The `--file [csv file name]` flag does not create the database and table automatically.
