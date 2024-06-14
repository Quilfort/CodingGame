<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $playerIdx);
fscanf(STDIN, "%d", $nbGames);

// Initialize $gpuArray with empty strings
$gpuArray = array_fill(0, $nbGames, "");

// Initialize $posArray with zeros
$posArray1 = array_fill(0, $nbGames, 0);
$posArray2 = array_fill(0, $nbGames, 0);
$posArray3 = array_fill(0, $nbGames, 0);

// Initialize $stunArray with zeros
$stunTimer1 = array_fill(0, $nbGames, 0);
$stunTimer2 = array_fill(0, $nbGames, 0);
$stunTimer3 = array_fill(0, $nbGames, 0);

// Define the priority order of commands and their respective increments
$priorityOrder = [
    "UP" => 2,
    "LEFT" => 1,
    "DOWN" => 2,
    "RIGHT" => 3
];

$finalCommand = "RIGHT";

// game loop
while (TRUE) {
    // Read and discard score information lines
    for ($i = 0; $i < 3; $i++) {
        $scoreInfo = stream_get_line(STDIN, 64 + 1, "\n");
    }

    // Read GPU data
    for ($i = 0; $i < $nbGames; $i++) {
        fscanf(STDIN, "%s %d %d %d %d %d %d %d", $gpu, $reg0, $reg1, $reg2, $reg3, $reg4, $reg5, $reg6);
        $gpuArray[$i] = $gpu;
        $posArray1[$i] = $reg0;
        $posArray2[$i] = $reg1;
        $posArray3[$i] = $reg2;
        $stunTimer1[$i] = $reg3;
        $stunTimer2[$i] = $reg4;
        $stunTimer3[$i] = $reg5;
    }

    // Print each GPU string with its index to error log (for debugging)
    foreach ($gpuArray as $index => $gpuString) {
        error_log("GPU $index: $gpuString");
    }

    // Initialize $commandArray with empty strings for this iteration
    $commandArray = array_fill(0, $nbGames, "");

    // Process each GPU string and determine commands
    foreach ($gpuArray as $index => $gpu) {
        // Initialize position and stun timer for this GPU string from arrays
        $pos = $posArray1[$index];
        $stunTimer = $stunTimer1[$index];

        // Determine command based on GPU string and player's position
        $len = strlen($gpu);
        $command = "";

        // Example logic: prioritize based on $priorityOrder and adapt as per your game's dynamics
        if ($pos + 1 < $len && $gpu[$pos + 1] === '#') {
            $command = "UP";
        } else {
            if ($pos + 2 < $len && $gpu[$pos + 2] === '#') {
                $command = "LEFT";
            } elseif ($pos + 3 < $len && $gpu[$pos + 3] === '#') {
                $command = "DOWN";
            } else {
                $command = "RIGHT";
            }
        }

        // Store command in $commandArray at the corresponding index, considering stun timers
        if ($stunTimer === 0) {
            $commandArray[$index] = $command;
        }
    }

    // Print each command with its index to error log (for debugging)
    foreach ($commandArray as $index => $commandString) {
        error_log("Command $index: $commandString");
    }

    // Determine the final command based on command counts and winning conditions
    $bestCommand = "RIGHT";
    $highestCount = 0;

    // Check for "UP" in commandArray and prioritize it
    if (in_array("UP", $commandArray)) {
        $finalCommand = "UP";
    } else {
        // Count occurrences of each command in $commandArray
        $commandCounts = array_count_values($commandArray);

        // Find the command with the highest count (excluding commands where stunTimer is not zero)
        foreach ($commandCounts as $command => $count) {
            if ($count > $highestCount) {
                $highestCount = $count;
                $bestCommand = $command;
            }
        }

        $finalCommand = $bestCommand;
        if ($finalCommand === "") {
            $finalCommand = "RIGHT";
        }
    }

    // Output the final command
    error_log("Final Command: $finalCommand");

    // Output the final command to be used as required
    echo $finalCommand . "\n";

    // Reset $commandArray for the next iteration
    $commandArray = array_fill(0, $nbGames, "");
}
