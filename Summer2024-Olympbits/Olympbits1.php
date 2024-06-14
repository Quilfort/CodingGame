<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $playerIdx);
fscanf(STDIN, "%d", $nbGames);



$pos = 0;
$end = $pos + 3;


// game loop
while (TRUE)
{
    // Read and discard score information lines
    for ($i = 0; $i < 3; $i++)
    {
        $scoreInfo = stream_get_line(STDIN, 64 + 1, "\n");
    }


    for ($i = 0; $i < $nbGames; $i++)
    {
        fscanf(STDIN, "%s %d %d %d %d %d %d %d", $gpu, $reg0, $reg1, $reg2, $reg3, $reg4, $reg5, $reg6);

    }

    // If GPU is GAME_OVER, reset position and break
    if ($gpu === 'GAME_OVER') {
        $pos = 0;
    }

    $len = strlen($gpu);

    $command = "";
    error_log("Char: " . $gpu[$pos] . " Pos: " . $pos);
    if ($pos + 1 <  $len && $gpu[$pos + 1] === '#') {
        $command = "UP";
        $pos += 2;
    } else {
        if ( $pos + 2 <  $len && $gpu[$pos + 2] === '#') {
            $command = "LEFT";
            $pos += 1;
            
        } elseif ($pos + 3 <  $len && $gpu[$pos + 3] === '#') {
            $command = "DOWN";
            $pos += 2;
        } else {
            $command = "RIGHT";
            $pos += 3;
        }
    }
    $end = $pos + 3;
    error_log("Command: " . $command);
    echo($command . "\n");
      // If GPU is GAME_OVER, reset position and break
      if ($gpu === 'GAME_OVER') {
        $pos = 0;
    }

}
?>


