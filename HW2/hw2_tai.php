<?php
/**
 * Assignment #2: Roman Numeral Conversion
 * Author: Tai Dao
 * Date: 2/19/2019
 * Time: 2:44 PM
 *
 * Credits to: https://www.selftaughtjs.com/algorithm-sundays-converting-roman-numerals/
 */

/*
 * As a rule of thumb, you should keep in mind that no letter should be repeated more than 3 times
 *
 */
tester();

function tester(){
    $roman = "XIII";
    RomanToNumber($roman);

}
function RomanToNumber ($romanNum) {
    $result = 0;

    echo 'This is the start of RomanToNumber function: ';
    echo "<br>The roman number to be converted is: $romanNum<br>";

    for ($i = 0; $i < strlen($romanNum); $i++) {
        $symbol = $romanNum[$i];
        $result = $result + getNumberFromRomanSymbol($symbol);
    }

    echo "The result is: $result<br>";

}

function getNumberFromRomanSymbol ($symbol) {
    if ($symbol == 'I')
        return 1;
    if ($symbol == 'V')
        return 5;
    if ($symbol == 'X')
        return 10;
    if ($symbol == 'L')
        return 50;
    if ($symbol == 'C')
        return 100;
    if ($symbol == 'D')
        return 500;
    if ($symbol == 'M')
        return 1000;
    return 0;
}


/**
 * This function is used to test prime_function
 */
function tester_function() {
    $test1 = 10;
    $expectedOutput1 = '2 3 5 7 ';

    echo 'Test Case 1:<br>';
    echo 'Expected output for prime_function(10): ' . $expectedOutput1;
    echo '<br>';
    echo "Actual output for prime_function($test1): " . prime_function($test1);
    if (prime_function($test1) == $expectedOutput1) {
        echo '<br><br>Status: PASSED';
    }
    else {
        echo '<br><br>Status: FAILED';
    }
    
    echo '<br><br><br><br>';
}