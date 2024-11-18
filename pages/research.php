<?php
requireLogin();
require_once 'includes/db_functions.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$user_id = $_SESSION['user_id'];

switch($action) {
    case 'create':
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = validateInput($_POST['title']);
            $description = validateInput($_POST['description']);
            $metadata = [
                'keywords' => explode(',', validateInput($_POST['keywords'])),
                'category' => validateInput($_POST['category']),
                'status' => validateInput($_POST['status'])
            ];
            
            if(empty($title)) {
                $error = "Title is required";
            } else {
                $project_id = createResearchProject($user_id, $title, $description, $metadata);
                if($project_id) {
                    header('Location: index.php?page=research&action=view&id=' . $project_id);
                    exit();
                } else {
                    $error = "Error creating project";
                }
            }
        }
        include 'research/create.php';
        break;
        
    case 'view':
        $project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $project = getProjectDetails($project_id, $user_id);
        
        if(!$project) {
            echo "<div class='alert alert-danger'>Project not found</div>";
            return;
        }
        include 'research/view.php';
        break;
        
    default:
        $projects = getResearchProjects($user_id);
        include 'research/list.php';
        break;
}
?>