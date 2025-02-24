# Framework:

## CodeIgniter 4
CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

## CodeIgniter 4 Shield Authentication
Shield is the official authentication and authorization framework for CodeIgniter 4. \
Shield provides two primary methods Session-based and Access Token authentication out of the box.

It also provides HMAC SHA256 Token and JSON Web Token authentication. [official site](https://shield.codeigniter.com/)

# Devlogs:

## Devlog 001 - week 06
Setup framework, implement front and admin controller and view separation. \
Little work has been done on the design aspect, main focus lies in setting up core features.
Example: Authentication, users roles and permissions, front and backend separation.

Mockup of creating assignments with entries has been implemented:

https://github.com/user-attachments/assets/0ccd585c-d110-45f1-8e9c-39a3aca2bdde


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
