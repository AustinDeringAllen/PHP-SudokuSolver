<?php
    $board = array(
        array(0, 6, 4, 0, 9, 0, 3, 7, 0),
        array(8, 0, 0, 0, 0, 1, 6, 0, 0),
        array(5, 0, 9, 0, 0, 0, 0, 2, 0),
        array(4, 0, 0, 1, 8, 9, 7, 6, 0),
        array(3, 0, 0, 0, 0, 0, 0, 0, 2),
        array(0, 8, 6, 2, 5, 3, 0, 0, 4),
        array(0, 3, 0, 0, 0, 0, 5, 0, 7),
        array(0, 0, 7, 9, 0, 0, 0, 0, 6),
        array(0, 5, 2, 0, 4, 0, 1, 3, 0)
    );

    function solveSudoku($board) {
        $emptyPositions = getEmptyPositions($board);
        $impossibleNumbers = array();
        for($i = 0; $i < sizeof($emptyPositions); $i++) {
            $impossibleNumbers[$i] = array();
        }

        $key = 0;
        while(true) {
            echo("Key: $key\n");
            $currentPosition = $emptyPositions[$key];
            $nextMove = findValidMove($board, $currentPosition, $impossibleNumbers[$key]);

            if($nextMove != -1) {
                $key++;
                $board[$currentPosition[0]][$currentPosition[1]] = $nextMove;
            } else {
                $impossibleNumbers[$key] = array();
                if($key != 0) {
                    $key--;
                }
                $previousPosition = $emptyPositions[$key];
                $impossibleNumbers[$key][] = $board[$previousPosition[0]][$previousPosition[1]];
                $board[$previousPosition[0]][$previousPosition[1]] = 0; 
            }

            if($key == sizeof($emptyPositions)) {
                break;
            }
        }

        prettify($board);
    }

    function getEmptyPositions($board) {
        $emptyPositions = array();
        for($row = 0; $row < sizeof($board); $row++) {
            for($col = 0; $col < sizeof($board); $col++) {
                if($board[$row][$col] == 0) {
                    $emptyPositions[] = array($row, $col);
                }
            }
        }
        return $emptyPositions;
    }

    function findValidMove($board, $currentPosition, $impossibleNumbers) {
        for($number = 1; $number <= sizeof($board); $number++) {
            if(isValidMove($board, $currentPosition, $number, $impossibleNumbers)) {
                echo("VALID NUMBER: ");
                echo($number);
                echo("\n");
                return $number;
            } else {
                echo("INVALID NUMBER: ");
                echo($number);
                echo("\n");
            }
        }
        echo("No Number Found");
        return -1;
    }

    function isValidMove($board, $currentPosition, $number, $impossibleNumbers) {
        $row = $col = $grid = false;

        if(in_array($number, $impossibleNumbers)) {
            return false;
        }

        $row = checkRow($board, $currentPosition, $number, $impossibleNumbers);
        $col = checkCol($board, $currentPosition, $number, $impossibleNumbers);
        $grid = checkGrid($board, $currentPosition, $number, $impossibleNumbers);

        return $row && $col && $grid;
    }

    function checkRow($board, $currentPosition, $number, $impossibleNumbers) {
        for($i = 0; $i < sizeof($board); $i++) {
            if($board[$currentPosition[0]][$i] == $number) {
                return false;
            }
        }
        return true;
    }

    function checkCol($board, $currentPosition, $number, $impossibleNumbers) {
        for($i = 0; $i < sizeof($board); $i++) {
            if($board[$i][$currentPosition[1]] == $number) {
                return false;
            }
        }
        return true;
    }

    function checkGrid($board, $currentPosition, $number, $impossibleNumbers) {
        $newPosition = array($currentPosition[0],$currentPosition[1]);
        for($i = 0; $i < sizeof($newPosition); $i++) {
            switch($newPosition[$i] % 3) {
                case 0:
                    $newPosition[$i] += 1;
                    break;
                case 2:
                    $newPosition[$i] -= 1;
                    break;
            }
        }

        for($i = $newPosition[0]-1; $i <= $newPosition[0]+1; $i++) {
            for($j = $newPosition[1]-1; $j <= $newPosition[1]+1; $j++) {
                if($board[$i][$j] == $number) {                    
                    return false;
                }
            }
        }
        return true;
    }

    function prettify($board) {
        echo("----------\n");
        foreach($board as $row) {
            for($col = 0; $col < sizeof($row); $col++) {
                if($col == sizeof($row)-1) {
                    echo($row[$col]);
                    echo("\n");
                } else {
                    echo($row[$col]);
                    echo(" , ");
                }
            }
        }
    }
    
    solveSudoku($board);
?>