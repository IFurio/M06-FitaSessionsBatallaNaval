<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exercici 1.2</title>
        <link href="https://fonts.googleapis.com/css?family=Gruppo" rel="stylesheet">
        <!-- <link rel="stylesheet" href="styles.css"> -->
        <style>
            body {
                background-image: url('./carrier.jpg');
                background-repeat: no-repeat;
                background-size: cover;
                color: white;
                font-family: "Gruppo";
                font-size: 20px;
                font-weight: bold;
            }

            .autocenter {
                display: flex;
                flex-direction: column;
                justify-content: center; /* Horizontally center */
                align-items: center; /* Vertically center */
                height: 100vh; /* 100% of viewport height */
                backdrop-filter: blur(10px);
                width: 1000px;
                height: 800px;
                margin: auto;
                border: 1px white solid;
                border-radius: 50px;
                background-color: rgba(0, 0, 0, 0.3);
            }

            h1 {
                letter-spacing: 10px;
            }

            table, td {
                border: 1px solid white;
                border-collapse: collapse;
                padding: 3px;
                text-align: center;
                height: 50px;
            }
            td {
                width: 50px;
            }
        </style>
    </head>
    <body>
        <?php
            echo "  <div class=\"autocenter\">";
            echo "  <h1>Batalla Naval</h1>";

            // fragata = 1, submarino = 2, destructor = 3, portaviones = 4

            $colums = 11;
            $rows = 11;

            $matrix = [[0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                       [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]];

            function checkAdjacent($fila, $columna) {
                // logic of adjacent and matrix limits:
                // checkAdjacent checks if there are any adjacent ship in the current position
                // also if the adjacent position is inside the matrix (using isset)
                global $matrix;
                if (isset($matrix[$fila - 1][$columna])) {
                    if ($matrix[$fila - 1][$columna] != 0) {
                        return false;
                    }
                }
                if (isset($matrix[$fila + 1][$columna])) {
                    if ($matrix[$fila + 1][$columna] != 0) {
                        return false;
                    }
                }
                if (isset($matrix[$fila][$columna - 1])) {
                    if ($matrix[$fila][$columna - 1] != 0) {
                        return false;
                    }
                }
                if (isset($matrix[$fila][$columna + 1])) {
                    if ($matrix[$fila][$columna + 1] != 0) {
                        return false;
                    }
                }
                return true;
            }

            // 4 frigates, 3 submarines, 2 destroyers i 1 carrier.

            $totalBoats = 10;
            for ($i = 1; $i <= $totalBoats;) {
                $rowPosition = rand(0, 9);
                $columPosition = rand(0, 9);
                $orientation = rand(0, 1);

                if ($i <= 4) { // set frigate position
                    if ($matrix[$rowPosition][$columPosition] == 0) {
                        $result = checkAdjacent($rowPosition, $columPosition);
                        if ($result) {   // set frigate position
                            $matrix[$rowPosition][$columPosition] = 1;
                            $i++;
                        }     
                    }
                }
                elseif ($i <= 7) { // set submarine position
                    if ($orientation == 0) { // horizontal
                        if ($columPosition == $colums - 2) { // this is the final column
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition][$columPosition - 1] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition, $columPosition - 1);
                                if ($result && $result2) {
                                    $matrix[$rowPosition][$columPosition] = 2;
                                    $matrix[$rowPosition][$columPosition - 1] = 2;
                                    $i++;
                                }
                            }
                        }
                        else { // the column can be the first or else
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition][$columPosition + 1] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition, $columPosition + 1);
                                if ($result && $result2) {
                                    $matrix[$rowPosition][$columPosition] = 2;
                                    $matrix[$rowPosition][$columPosition + 1] = 2;
                                    $i++;
                                }
                            }
                        }
                    } else { // vertical
                        if ($rowPosition == $rows - 2) { // this is the final row
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition - 1][$columPosition] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition - 1, $columPosition);
                                if ($result && $result2) {
                                    $matrix[$rowPosition][$columPosition] = 2;
                                    $matrix[$rowPosition - 1][$columPosition] = 2;
                                    $i++;
                                }
                            }
                        }
                        else { // the row can be the first or else
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition + 1][$columPosition] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition + 1, $columPosition);
                                if ($result && $result2) {
                                    $matrix[$rowPosition][$columPosition] = 2;
                                    $matrix[$rowPosition + 1][$columPosition] = 2;
                                    $i++;
                                } 
                            }
                        }
                    }
                }
                elseif ($i <= 9) { // set destructor position
                    if ($orientation == 0) { // horizontal
                        if ($columPosition + 3 > $colums - 2) { // it have to go to left
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition][$columPosition - 1] == 0 && $matrix[$rowPosition][$columPosition - 2] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition, $columPosition - 1);
                                $result3 = checkAdjacent($rowPosition, $columPosition - 2);
                                if ($result && $result2 && $result3) {
                                    $matrix[$rowPosition][$columPosition] = 3;
                                    $matrix[$rowPosition][$columPosition - 1] = 3;
                                    $matrix[$rowPosition][$columPosition - 2] = 3;
                                    $i++;
                                }
                            }
                        } else { // always go to right
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition][$columPosition + 1] == 0 && $matrix[$rowPosition][$columPosition + 2] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition, $columPosition + 1);
                                $result3 = checkAdjacent($rowPosition, $columPosition + 2);
                                if ($result && $result2 && $result3) {
                                    $matrix[$rowPosition][$columPosition] = 3;
                                    $matrix[$rowPosition][$columPosition + 1] = 3;
                                    $matrix[$rowPosition][$columPosition + 2] = 3;
                                    $i++;
                                }
                            }
                        }
                    }
                    else { // vertical
                        if ($rowPosition + 3 > $rows - 2) { // it have to go up
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition - 1][$columPosition] == 0 && $matrix[$rowPosition - 2][$columPosition] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition - 1, $columPosition);
                                $result3 = checkAdjacent($rowPosition - 2, $columPosition);
                                if ($result && $result2 && $result3) {
                                    $matrix[$rowPosition][$columPosition] = 3;
                                    $matrix[$rowPosition - 1][$columPosition] = 3;
                                    $matrix[$rowPosition - 2][$columPosition] = 3;
                                    $i++;
                                }
                            }
                        } else { // always go down
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition + 1][$columPosition] == 0 && $matrix[$rowPosition + 2][$columPosition] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition + 1, $columPosition);
                                $result3 = checkAdjacent($rowPosition + 2, $columPosition);
                                if ($result && $result2 && $result3) {
                                    $matrix[$rowPosition][$columPosition] = 3;
                                    $matrix[$rowPosition + 1][$columPosition] = 3;
                                    $matrix[$rowPosition + 2][$columPosition] = 3;
                                    $i++;
                                }
                            }
                        }
                    }
                } else { // set aircraft carrier position
                    if ($orientation == 0) { // horizontal
                        if ($columPosition + 4 > $colums - 2) { // it have to go to left
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition][$columPosition - 1] == 0 && $matrix[$rowPosition][$columPosition - 2] == 0 && 
                                $matrix[$rowPosition][$columPosition - 3] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition, $columPosition - 1);
                                $result3 = checkAdjacent($rowPosition, $columPosition - 2);
                                $result4 = checkAdjacent($rowPosition, $columPosition - 3);
                                if ($result && $result2 && $result3 && $result4) {
                                    $matrix[$rowPosition][$columPosition] = 4;
                                    $matrix[$rowPosition][$columPosition - 1] = 4;
                                    $matrix[$rowPosition][$columPosition - 2] = 4;
                                    $matrix[$rowPosition][$columPosition - 3] = 4;
                                    $i++;
                                }
                            }
                        } else { // always go to the right
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition][$columPosition + 1] == 0 && $matrix[$rowPosition][$columPosition + 2] == 0 && 
                                $matrix[$rowPosition][$columPosition + 3] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition, $columPosition + 1);
                                $result3 = checkAdjacent($rowPosition, $columPosition + 2);
                                $result4 = checkAdjacent($rowPosition, $columPosition + 3);
                                if ($result && $result2 && $result3 && $result4) {
                                    $matrix[$rowPosition][$columPosition] = 4;
                                    $matrix[$rowPosition][$columPosition + 1] = 4;
                                    $matrix[$rowPosition][$columPosition + 2] = 4;
                                    $matrix[$rowPosition][$columPosition + 3] = 4;
                                    $i++;
                                }
                            }
                        }
                    } else { // vertical 
                        if ($rowPosition + 4 > $rows - 2) { // it have to go to up
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition - 1][$columPosition] == 0 && $matrix[$rowPosition - 2][$columPosition] == 0 && 
                                $matrix[$rowPosition - 3][$columPosition] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition - 1, $columPosition);
                                $result3 = checkAdjacent($rowPosition - 2, $columPosition);
                                $result4 = checkAdjacent($rowPosition - 3, $columPosition);
                                if ($result && $result2 && $result3 && $result4) {
                                    $matrix[$rowPosition][$columPosition] = 4;
                                    $matrix[$rowPosition - 1][$columPosition] = 4;
                                    $matrix[$rowPosition - 2][$columPosition] = 4;
                                    $matrix[$rowPosition - 3][$columPosition] = 4;
                                    $i++;
                                }
                            }
                        } else { // always go down
                            if ($matrix[$rowPosition][$columPosition] == 0 && $matrix[$rowPosition + 1][$columPosition] == 0 && $matrix[$rowPosition + 2][$columPosition] == 0 && 
                                $matrix[$rowPosition + 3][$columPosition] == 0) {
                                $result = checkAdjacent($rowPosition, $columPosition);
                                $result2 = checkAdjacent($rowPosition + 1, $columPosition);
                                $result3 = checkAdjacent($rowPosition + 2, $columPosition);
                                $result4 = checkAdjacent($rowPosition + 3, $columPosition);
                                if ($result && $result2 && $result3 && $result4) {
                                    $matrix[$rowPosition][$columPosition] = 4;
                                    $matrix[$rowPosition + 1][$columPosition] = 4;
                                    $matrix[$rowPosition + 2][$columPosition] = 4;
                                    $matrix[$rowPosition + 3][$columPosition] = 4;
                                    $i++;
                                }  
                            }
                        }
                    }
                }
            }

            echo "  <table>";
            $limit = "N";
            $asciiValue = 65;
            for ($row = 0; $row <= $rows - 1; $row++) { // for each row
                echo "\t\t<tr>\n";
                for ($colum = 0; $colum <= $colums - 1; $colum++) { // for each colum
                    if ($row == 0 && $colum == 0) {
                        echo "\t\t<td></td>\n";
                    }
                    elseif ($row == 0) { // if this is the first row
                        echo "\t\t<td>$colum</td>\n";
                    }
                    elseif ($colum == 0) {
                        $letter = chr($asciiValue);
                        echo "\t\t<td>$letter</td>\n";
                        $asciiValue++;
                    } else {
                        $columPosition = $colum - 1;
                        $rowPosition = $row - 1;
                        if ($matrix[$rowPosition][$columPosition] == 0) {
                            echo "\t\t<td></td>\n";
                        } else {
                            $valor = $matrix[$rowPosition][$columPosition];
                            if ($valor == 1) {
                                echo "<td><img src=\"./frigate.png\"></td>";
                            }
                            elseif ($valor == 2) {
                                echo "\t\t<td><img src=\"./submarine.png\"></td>\n";
                            }
                            elseif ($valor == 3) {
                                echo "\t\t<td><img src=\"./destroyer.png\"></td>\n";
                            } else {
                                echo "\t\t<td><img src=\"./carrier-icon.png\"></td>\n";
                            }
                        }
                        
                    }
                }
                echo "\t\t</tr>\n";
            }
            echo "  </table>";
            echo "  </div>";
        ?>
    </body>
</html>