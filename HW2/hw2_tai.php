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
 * Tester must be done correctly!
 *
 * Consider all inputs like VV if you want. but you don't have to
 * Z
 * Keep your functions small
 */
tester();

function tester(){
    $roman = "XCIX";
    RomanToNumber($roman);

}
function RomanToNumber ($romanNum) {
    $result = 0;

    echo 'This is the start of RomanToNumber function: ';
    echo "<br>The roman number to be converted is: $romanNum<br>";

    for ($i = 0; $i < strlen($romanNum) - 1; $i++) {


        // TODO turn these into smaller functions
        // Check string length before comparing with next number in string
        if ($i+1 < strlen($romanNum)){
            // Case 1: Value of symbol is less than next symbol
            if ($romanNum[$i] < $romanNum[$i+1]) {
                echo "Case2... <br>";
                $biggerNumber =  getNumberFromRomanSymbol($romanNum[$i+1]);
                $smallerNumber = getNumberFromRomanSymbol($romanNum[$i]);
                $result = $biggerNumber - $smallerNumber;
                $i++;
            }
            // Case 2: Value of symbol is greater than or equal to next symbol
            else {
                //TODO
                echo "Case3... <br>";
                // $valueOfSymbol = getNumberFromRomanSymbol(romanNum[$i]);


            }
        }
        else {
                echo "Case Exit...<br>";
            // TODO: Gotta stop and return result here. cuz there's no more string after to check

        }
    }
    if ($result == 0 ){
        echo "input was invalid!";
    }
    else {
        echo "The result is: $result<br>";
    }

}

function checkValidInput ($string) {

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
    return -1;
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