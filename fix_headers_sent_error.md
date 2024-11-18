# How to Fix "Headers Already Sent" Error

## Problem
You are encountering the following error:
```
Warning: Cannot modify header information - headers already sent by (output started at /var/www/html/includes/header.php:1) in /var/www/html/pages/login.php on line 18
```

## Cause
This error occurs when trying to send HTTP headers after content has already been output to the browser. Common causes include:
1. Whitespace or HTML output before PHP header modifications
2. BOM (Byte Order Mark) at the start of PHP files
3. Previous echo statements or HTML content
4. Spaces before opening PHP tags

## Solution

1. **Check for whitespace in header.php**
   - Make sure there are no spaces, newlines, or HTML content before the opening `<?php` tag
   - Remove any BOM if present (save the file as UTF-8 without BOM)

2. **Review login.php**
   - Ensure all header modifications (like `header()`, `session_start()`, etc.) are at the very top of the file
   - Move any header modifications before any output is sent

3. **General fixes:**
   ```php
   <?php
   // Start with session_start() and other header modifications
   session_start();
   // Other header modifications here
   
   // Then include your header file
   include 'header.php';
   
   // Rest of your code
   ?>
   ```

4. **Alternative Solutions:**
   - Use output buffering if you can't reorganize the code:
     ```php
     <?php
     ob_start();
     // Your code here
     ob_end_flush();
     ?>
     ```
   - Or move all header modifications to a separate file that's included first

## Steps to Implement

1. Check all PHP files in your includes directory for BOM or whitespace
2. Review your login.php and ensure header modifications are at the top
3. Consider implementing output buffering as a safeguard

Remember: Any kind of output (HTML, whitespace, echo statements) before header modifications will cause this error. The key is to ensure all header modifications happen before any output is sent to the browser.