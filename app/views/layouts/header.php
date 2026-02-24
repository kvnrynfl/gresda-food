<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <?php include '../app/views/components/core/head.php'; ?>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <?php include '../app/views/components/core/alerts.php'; ?>

    <?php include '../app/views/components/core/navbar.php'; ?>

    <!-- Main Content Wrapper -->
    <main class="flex-grow <?php echo (!isset($title) || $title !== 'Home') ? 'pt-16' : ''; ?>">

