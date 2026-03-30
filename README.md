# VLAM Training
[![build](https://github.com/mhoek2/vlam/actions/workflows/docs.yml/badge.svg)](https://github.com/mhoek2/vlam/actions/workflows/docs.yml)

## CodeIgniter 4
CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

## CodeIgniter 4 Shield Authentication
Shield is the official authentication and authorization framework for CodeIgniter 4. \
Shield provides two primary methods Session-based and Access Token authentication out of the box.

It also provides HMAC SHA256 Token and JSON Web Token authentication. [official site](https://shield.codeigniter.com/)

# :o: Getting-Started
Private repo, to get started:
1. Navigate to the ```gh-pages``` branch 
2. download the zip and extract
3. open index.html locally.

# Helpful SQL Queries:

### List Foreign Relations:
```sql
SELECT 
    TABLE_NAME, 
    COLUMN_NAME, 
    CONSTRAINT_NAME, 
    REFERENCED_TABLE_NAME, 
    REFERENCED_COLUMN_NAME
FROM 
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE 
    REFERENCED_TABLE_NAME IS NOT NULL 
    AND TABLE_SCHEMA = 'hklab69_vlam';
```
