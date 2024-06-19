<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $initialPR = floatval($_POST['initialPR']);
    $numNewPages = intval($_POST['numNewPages']);
    $dampingFactor = isset($_POST['dampingFactor']) ? floatval($_POST['dampingFactor']) : 0.85;

    // Calculate the total PageRank contribution from new pages
    $newPageContribution = $initialPR * $dampingFactor / $numNewPages;

    // The base PageRank value that each page receives (distributed uniformly)
    $basePR = (1 - $dampingFactor) / ($numNewPages + 1);

    // Calculate the final target PageRank
    $targetPR = $basePR + $newPageContribution * $numNewPages;

    header('Content-Type: application/json');
    echo json_encode(['targetPR' => $targetPR, 'numNewPages' => $numNewPages]);
}
?>
