<?php
function kryptosEncrypt($password, $keyword) {
    // Generate random word to add to the original password
    $salt = '';
    $sym = '!@#$%^&*()-_=+[]{}<>?.,';
    for ($i = 0; $i < 8; $i++) {
        $salt .= rand(0, 1) ? chr(rand(33, 126)) : $sym[rand(0, strlen($sym) - 1)];
    }

    // saltedpass howa el password + el salt
    $saltedPassword = $salt . $password;

    // cryptage lil password
    $encrypted = '';
    $keywordLength = strlen($keyword);
    for ($i = 0; $i < strlen($saltedPassword); $i++) {
        $charCode = ord($saltedPassword[$i]);
        $shift = ord($keyword[$i % $keywordLength]) % 26; // tbadel pos mta3 el code binesba lil keyword 
        $encrypted .= chr(($charCode + $shift - 33) % 94 + 33); // bich mayfoutech el ASCII ta3 a7rof
    }

    // cryptage lil cryptage (polyalphabetic substitution) tbadel pos mta3 el crypt binesba lil pos mta3 el 7rouf fil keyword
    $layer1 = hash('sha256', $encrypted);
    $layer2 = hash('whirlpool', $layer1);

    // Step 4: Inject random sym into hashed output
    $finalOutput = '';
    for ($i = 0; $i < strlen($layer2); $i++) {
        $finalOutput .= $layer2[$i];
        if (rand(0, 3) === 0) { // 25% chance to add a symbol
            $finalOutput .= $sym[rand(0, strlen($sym) - 1)];
        }
    }

    return [
        'salt' => $salt,
        'encrypted' => $finalOutput
    ];
}
?>
