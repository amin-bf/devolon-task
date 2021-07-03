# Create devolod_db_test database if it doesn`t exist
CREATE DATABASE IF NOT EXISTS devolod_db_test;
# Grant all privilidges on devolod_db_test to devolon_dbu
GRANT ALL PRIVILEGES ON devolod_db_test.* TO 'devolon_dbu' identified by 'password';
