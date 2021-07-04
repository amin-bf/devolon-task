# Create devolon_db_test database if it doesn`t exist
CREATE DATABASE IF NOT EXISTS devolon_db_test;
# Grant all privilidges on devolon_db_test to devolon_dbu
GRANT ALL PRIVILEGES ON devolon_db_test.* TO 'devolon_dbu'@'%';
FLUSH PRIVILEGES;

