<?php
/**
 * Assignment #4: PHP + SQL
 * Author: Tai Dao
 * Date: 4/10/2019
 * Time: 6:17 PM
 *
 * Credits to: https://www.selftaughtjs.com/algorithm-sundays-converting-roman-numerals/
 */

example();
#homePage();
#tester_function();

function example() {
    //build a form
//Asking user to upload a valid file
    echo <<< END

    <html>
        <head>
            <title> File Upload </title>
        </head>
    <body>
        Welcome to the site!<br>
        <form method='post' action='hw4.php' enctype='multipart/form-data'>
            Please Upload a .txt File:
            <input type='file' name='filename' size='10'>
            <input type='submit' value='Upload'>
        </form>
END;
}

function homePage () {
    echo <<<_END
	<html>
		<head>
			<title>HW4: Tai Dao</title>
		</head>
		<body>
			Welcome to the site!<br>
			<form method="post" action="formtest2.php">
				Please enter a string:
				<input type="text" name="name">
				<input type="submit" name="Upload">
			</form>
		</body>
	</html>
_END;

}
function readInputToDB ($input) {

}


function romanToNumber ($romanNum) {
    $result = 0;

    // Empty string edge case...
    if ($romanNum == ""){
        return "*ERROR* (Invalid input. No string was specified.)";
    }

    // Checking for ValidRomanNumerals...
    if(!checkValidRomanNumeral($romanNum)) {
        return "*ERROR* (Invalid input. Input is not a roman numeral.)";
    }

    // Iterating through roman numeral string...
    for ($i = 0; $i < strlen($romanNum); $i++) {
        $currentSymbol = $romanNum[$i];
        $currentNumber = getNumberFromRomanSymbol($currentSymbol);

        // Current symbol is not the last symbol
        if ($i+1 < strlen($romanNum)) {
            $nextSymbol = $romanNum[$i+1];
            $nextNumber =  getNumberFromRomanSymbol($nextSymbol);

            // Case 1: Value of symbol is greater than or equal to next symbol
            if ( $currentNumber >= $nextNumber ) {
                $result = $result + $currentNumber;
            }

            // Case 2: Value of symbol is less than the next symbol
            else {
                $result = $result + ($nextNumber - $currentNumber);
                $i = $i + 1;

            }
        }

        // Current symbol is the last symbol in string.
        else {
            $result = $result + $currentNumber;
            $i++;
        }
    }
    return $result;
}

/*
 * This function checks if a string $romanNum is a valid roman numeral
 *
 * @returns true  // if valid
 * @returns false // if invalid
 */
function checkValidRomanNumeral ($romanNum) {
    // I got this regex expression from: https://stackoverflow.com/questions/37767472/check-for-the-validity-of-a-roman-number-difficult
    if ( preg_match('/^M{0,3}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/', $romanNum, $match)){
        return true;
    }
    else {
        return false;
    }
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
    $test1 = "IX";
    $test2 = "CM";
    $test3 = "ID";
    $test4 = "XM";
    $test5 = "VIIII";
    $test6 = "TESTCASESFRIGGINGsuckasdf129348023184";
    $test7 = "";
    $test8 = "IXIXVIIVXIVXCCMM";
    $test9 = "MMMCMXCIX";
    $test10 = "MCMXC";

    $expectedOutput1 = "9";
    $expectedOutput2 = "900";
    $expectedOutput3 = "*ERROR* (Invalid input. Input is not a roman numeral.)";
    $expectedOutput4 = "*ERROR* (Invalid input. Input is not a roman numeral.)";
    $expectedOutput5 = "*ERROR* (Invalid input. Input is not a roman numeral.)";
    $expectedOutput6 = "*ERROR* (Invalid input. Input is not a roman numeral.)";
    $expectedOutput7 = "*ERROR* (Invalid input. No string was specified.)";
    $expectedOutput8 = "*ERROR* (Invalid input. Input is not a roman numeral.)";
    $expectedOutput9 = "3999";
    $expectedOutput10 = "1990";

    $expectedOutputERR = "*ERROR* (Invalid input. Input is not a roman numeral.)";

    echo 'Test Case 1: Valid Subtractive Input 1<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test1'): " . $expectedOutput1 . '<br>';
    echo "Actual output for romanToNumber('$test1'): " . romanToNumber($test1) . '<br>';
    if ($expectedOutput1 == romanToNumber($test1)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }
    echo 'Test Case 2: Valid Subtractive Input 2<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test2'): " . $expectedOutput2 . '<br>';
    echo "Actual output for romanToNumber('$test2'): " . romanToNumber($test2) . '<br>';
    if ($expectedOutput2 == romanToNumber($test2)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }

    echo 'Test Case 3: Invalid Subtractive Input 1<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test3'): " . $expectedOutput3 . '<br>';
    echo "Actual output for romanToNumber('$test3'): " . romanToNumber($test3) . '<br>';
    if ($expectedOutput3 == romanToNumber($test3)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }

    echo 'Test Case 4: Invalid Subtractive Input 2<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test4'): " . $expectedOutput4 . '<br>';
    echo "Actual output for romanToNumber('$test4'): " . romanToNumber($test4) . '<br>';
    if ($expectedOutput4 == romanToNumber($test4)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }

    echo 'Test Case 5: More than 3 consecutive symbols<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test5'): " . $expectedOutput5 . '<br>';
    echo "Actual output for romanToNumber('$test5'): " . romanToNumber($test5) . '<br>';
    if ($expectedOutput5 == romanToNumber($test5)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }

    echo 'Test Case 6: Random String<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test6'): " . $expectedOutput6 . '<br>';
    echo "Actual output for romanToNumber('$test6'): " . romanToNumber($test6) . '<br>';
    if ($expectedOutput6 == romanToNumber($test6)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }

    echo 'Test Case 7: Empty String<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test7'): " . $expectedOutput7 . '<br>';
    echo "Actual output for romanToNumber('$test7'): " . romanToNumber($test7) . '<br>';
    if ($expectedOutput7 == romanToNumber($test7)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }

    echo 'Test Case 8: Random Roman Numeral Symbols<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test8'): " . $expectedOutput8 . '<br>';
    echo "Actual output for romanToNumber('$test8'): " . romanToNumber($test8) . '<br>';
    if ($expectedOutput8 == romanToNumber($test8)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }

    echo 'Test Case 9: Maximum number<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test9'): " . $expectedOutput9 . '<br>';
    echo "Actual output for romanToNumber('$test9'): " . romanToNumber($test9) . '<br>';
    if ($expectedOutput9 == romanToNumber($test9)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }

    echo 'Test Case 10: Mix of Subtractive Inputs<br>*****************************************<br>';
    echo "Expected output for romanToNumber('$test10'): " . $expectedOutput10 . '<br>';
    echo "Actual output for romanToNumber('$test10'): " . romanToNumber($test10) . '<br>';
    if ($expectedOutput10 == romanToNumber($test10)){
        echo "STATUS: PASSED<br><br>";
    }
    else {
        echo "STATUS: FAILED<br><br>";
    }
}

/*
 * This function checks if two characters together make a proper subtractive character in roman numerals.
 * Proper subtractive characters are: IV, IX, XL, XC, CD, and CM.
 *
 * @returns true;  // if valid
 * @returns false; // if invalid
 *
 * COMMENT: This function is no longer needed because it's taken care of
 * by the regex of function checkValidRomanNumerals($romanNum)...
 */

/*
function checkValidSubtractiveCharacters ($firstChar, $secondChar) {
    $testString = $firstChar . $secondChar;
    switch($testString) {
        case 'IV':
        case 'IX':
        case 'XL':
        case 'XC':
        case 'CD':
        case 'CM':
            return true;
            break;
        default:
            return false;
    }
}
*/
