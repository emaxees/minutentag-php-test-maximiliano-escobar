<html>
    <head>
        <title>PHP Minutentag Test</title>
    </head>
    <body>
        <?php 
            function processItems($p, $o, $ext) {
                $items = [];
                $sp = false;
                $cd = false;
            
                $ext_p = [];
            
                // Extract quantity information from $ext array and store it in $ext_p
                foreach ($ext as $i => $e) {
                    $ext_p[$e['price']['id']] = $e['qty'];
                }
            
                // Process each item in the order
                foreach ($o['items']['data'] as $i => $item) {
                    $product = [
                        'id' => $item['id']
                    ];
            
                    // Check if the item has additional quantity information in $ext_p
                    if (isset($ext_p[$item['price']['id']])) {
                        $qty = $ext_p[$item['price']['id']];
                        if ($qty < 1) {
                            $product['deleted'] = true;
                        } else {
                            $product['qty'] = $qty;
                        }
                        unset($ext_p[$item['price']['id']]);
                    } elseif ($item['price']['id'] == $p['id']) {
                        // Check if the item matches the specified product ID ($p['id'])
                        $sp = true;
                    } else {
                        // If the item doesn't match the specified product ID, mark it as deleted
                        $product['deleted'] = true;
                        $cd = true;
                    }
            
                    // Add the processed product to the $items array
                    $items[] = $product;
                }
            
                // If the specified product ID ($p['id']) is not found in the order, add it to $items
                if (!$sp) {
                    $items[] = [
                        'id' => $p['id'],
                        'qty' => 1
                    ];
                }
            
                // Process any remaining items in $ext_p and add them to $items
                foreach ($ext_p as $id => $qty) {
                    if ($qty < 1) {
                        continue; // Skip items with quantity less than 1
                    }
            
                    $items[] = [
                        'id' => $id,
                        'qty' => $qty
                    ];
                }
            
                // Return the final array of processed items
                return $items;
            }
        ?>
        <br></br>
        <?php
            class LetterCounter {
                // Static method to count letters in a string and return the result
                public static function CountLettersAsString($inputString) {
                    // Initialize an array to store letter counts
                    $letterCounts = [];
            
                    // Convert the input string to lowercase for case-insensitive counting
                    $inputString = strtolower($inputString);
            
                    // Iterate through each character in the string
                    for ($i = 0; $i < strlen($inputString); $i++) {
                        $char = $inputString[$i];
            
                        // Check if the character is a letter
                        if (ctype_alpha($char)) {
                            // Check if the letter exists in the array, if not, initialize it with a count of 1
                            if (!isset($letterCounts[$char])) {
                                $letterCounts[$char] = 1;
                            } else {
                                // Increment the count for the letter in the array
                                $letterCounts[$char]++;
                            }
                        }
                    }
            
                    // Initialize an array to store the final result
                    $result = [];
            
                    // Iterate through the letter counts
                    foreach ($letterCounts as $letter => $count) {
                        // Create a string representation with letter and asterisks
                        $result[] = $letter . ':' . str_repeat('*', $count);
                    }
            
                    // Return the final result as a string
                    return implode(',', $result);
                }
            }
            
            $inputString = "Interview";
            $result = LetterCounter::CountLettersAsString($inputString);
            echo $result;
        ?>
        <br></br>
        <?php
            class DateFetcher {
                public static function fetchAndPrintDate() {
                    // URL for the date service
                    $url = "http://date.jsontest.com/";

                    // Make a request to the URL and get the JSON response
                    $jsonResponse = file_get_contents($url);

                    // Decode the JSON response
                    $data = json_decode($jsonResponse, true);

                    // Check if the JSON decoding was successful
                    if ($data !== null) {
                        // Extract the date and time components from the decoded data
                        $date = $data['date'];
                        $time = $data['time'];

                        // Convert the date to a readable format
                        $formattedDate = date("l jS \\of F, Y - h:i A", strtotime("$date $time"));

                        // Print the formatted date
                        echo "Current date: $formattedDate";
                    } else {
                        // Handle the case where JSON decoding fails
                        echo "Unable to fetch and parse the date.";
                    }
                }
            }

            // Call the method to fetch and print the date
            DateFetcher::fetchAndPrintDate();
        ?>
        <br></br>
        <?php
            class ResponseProcessor {
                public static function fetchAndPrintData() {
                    // URL for the response service
                    $url = "http://echo.jsontest.com/john/yes/tomas/no/belen/yes/peter/no/julie/no/gabriela/no/messi/no";

                    // Make a request to the URL and get the JSON response
                    $jsonResponse = file_get_contents($url);

                    // Decode the JSON response
                    $data = json_decode($jsonResponse, true);

                    // Check if the JSON decoding was successful
                    if ($data !== null) {
                        // Initialize arrays for 'yes' and 'no' responses
                        $yesResponses = [];
                        $noResponses = [];

                        // Iterate through the data and categorize responses
                        foreach ($data as $name => $response) {
                            if ($response === 'yes') {
                                $yesResponses[] = $name;
                            } elseif ($response === 'no') {
                                $noResponses[] = $name;
                            }
                        }

                        // Print the HTML table
                        echo "<table border='1'>";
                        echo "<tr><th>Yes</th><th>No</th></tr>";

                        // Determine the maximum count between 'yes' and 'no' responses
                        $maxCount = max(count($yesResponses), count($noResponses));

                        // Print each row with 'yes' and 'no' responses
                        for ($i = 0; $i < $maxCount; $i++) {
                            $yesName = isset($yesResponses[$i]) ? $yesResponses[$i] : '';
                            $noName = isset($noResponses[$i]) ? $noResponses[$i] : '';

                            echo "<tr><td>$yesName</td><td>$noName</td></tr>";
                        }

                        echo "</table>";
                    } else {
                        // Handle the case where JSON decoding fails
                        echo "Unable to fetch and parse the response data.";
                    }
                }
            }

            // Call the method to fetch and print the response data
            ResponseProcessor::fetchAndPrintData();
        ?>

    </body>
</html>