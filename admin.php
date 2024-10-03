<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect if not logged in
    exit();
}
?>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$baseDirectory = realpath('./');
$directory = $baseDirectory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dir'])) {
        $requestedDir = trim($_POST['dir']);
        if ($requestedDir === '') {
            $directory = $baseDirectory;
        } else {
            $newDirectory = realpath($baseDirectory . '/' . $requestedDir);
            if ($newDirectory !== false && strpos($newDirectory, $baseDirectory) === 0) {
                $directory = $newDirectory;
            } else {
                $directory = $baseDirectory;
            }
        }
    }
}

$content = '';
$currentFileName = '';
if (isset($_POST['file'])) {
    $fileToDisplay = $directory . '/' . $_POST['file'];
    if (file_exists($fileToDisplay) && is_readable($fileToDisplay)) {


        $content = htmlspecialchars(file_get_contents($fileToDisplay));
        $currentFileName = htmlspecialchars(basename($fileToDisplay)); // Get the filename
    
    } else {
        $content = "File does not exist or is not readable.";
    }
}

$items = scandir($directory);
$parentDir = dirname($directory);
$backDir = str_replace($baseDirectory, '', $parentDir);
$backDir = ltrim($backDir, '/');
$isAtBaseDir = ($directory === $baseDirectory);

usort($items, function($a, $b) use ($directory) {
    $aIsDir = is_dir($directory . '/' . $a);
    $bIsDir = is_dir($directory . '/' . $b);
    return $aIsDir === $bIsDir ? strnatcasecmp($a, $b) : ($aIsDir ? -1 : 1);
});
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Browser</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="container my-4">
    <h1 class="text-center">Admin File Browser</h1>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <span class="h4">Current Directory: <?php echo htmlspecialchars(basename($directory)); ?></span>
        <?php if ($currentFileName): ?>
            <span class="h4">Viewing: <?php echo htmlspecialchars($currentFileName); ?></span>
        <?php endif; ?>
    </div>

    <div class="mb-3 d-flex justify-content-between">
        <div>
            <?php if (!$isAtBaseDir): ?>
                <form action="" method="POST" style="display: inline;">
                    <input type="hidden" name="dir" value="<?php echo htmlspecialchars($backDir); ?>">
                    <button type="submit" class="btn btn-secondary">Back</button>
                </form>
            <?php endif; ?>
        </div>
        <div>
            <form action="logout.php" method="POST" style="display: inline;">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <div class="row" style="height: 400px;">
        <div class="col-md-6 overflow-auto">
            <ul class="list-group">
                <?php foreach ($items as $item): ?>
                    <?php if ($item !== '.' && $item !== '..'): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php $itemPath = $directory . '/' . $item; ?>
                            <span>
                                <?php if (is_dir($itemPath)): ?>
                                    <img src="icons/folder.svg" alt="Folder" style="width: 20px; height: 20px; margin-right: 5px;"> <!-- Folder icon -->
                                <?php else: ?>
                                    <img src="icons/file.svg" alt="File" style="width: 20px; height: 20px; margin-right: 5px;"> <!-- File icon -->
                                <?php endif; ?>
                                <?php echo htmlspecialchars($item); ?>
                            </span>
                            <span>
                                <?php if (is_dir($itemPath)): ?>
                                    <form action="" method="POST" style="display: inline;">
                                        <input type="hidden" name="dir" value="<?php echo htmlspecialchars(trim($requestedDir . '/' . $item, '/')); ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Open</button>
                                    </form>
                                <?php else: ?>
                                    <form action="" method="POST" style="display: inline;">
                                        <input type="hidden" name="dir" value="<?php echo htmlspecialchars($requestedDir); ?>">
                                        <input type="hidden" name="file" value="<?php echo htmlspecialchars($item); ?>">
                                        <button type="submit" class="btn btn-info btn-sm">View</button>
                                    </form>
                                <?php endif; ?>
                            </span>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-6 h-100">
            <div class="h-100">
                <textarea class="form-control h-100" style="font-family: monospace;" readonly><?php echo $content; ?></textarea>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>