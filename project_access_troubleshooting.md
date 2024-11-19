# Project Access Troubleshooting Guide

## Current Issues
If you're seeing "Project not found" errors, there are several potential causes:

1. **Project ID Type Mismatch**
   - In research.php, project_id is cast to int: `(int)$_GET['id']`
   - In view.php, it isn't cast: `isset($_GET['id']) ? $_GET['id'] : null`
   - Solution: Ensure consistent type casting across all files

2. **Session Issues**
   - Check if $_SESSION['user_id'] is properly set
   - Use debug_permissions.php to verify session data
   - Solution: Add session_start() if missing, check session data

3. **Database Permission Logic**
   - Two implementations exist:
     - getProjectDetails(): Uses JOIN with complex permission check
     - getProjectDetailsSecure(): Uses separate queries for clarity
   - Solution: Use getProjectDetailsSecure() consistently

## How to Debug
1. Visit debug_permissions.php?id=YOUR_PROJECT_ID
2. Check error logs for "Project not found" or "Access denied" messages
3. Verify project exists in research_projects table
4. Verify collaboration record exists if you're not the owner

## Additional Notes
- Projects must either be owned by you or have a collaboration record
- Project IDs should be positive integers
- Session must be maintained across requests