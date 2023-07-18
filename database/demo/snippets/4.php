function generateRandomPassword($length) {
  $uppercaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $lowercaseLetters = 'abcdefghijklmnopqrstuvwxyz';
  $numbers = '0123456789';
  $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';

  $allChars = $uppercaseLetters . $lowercaseLetters . $numbers . $specialChars;

  $password = '';
  for ($i = 0; $i < $length; $i++) {
    $randomIndex = mt_rand(0, strlen($allChars) - 1);
    $password .= $allChars[$randomIndex];
  }

  return $password;
}

function checkPasswordStrength($password) {
  $strength = 0;
  $length = strlen($password);
  $hasUppercase = preg_match('/[A-Z]/', $password);
  $hasLowercase = preg_match('/[a-z]/', $password);
  $hasNumber = preg_match('/\d/', $password);
  $hasSpecialChar = preg_match('/[^A-Za-z\d]/', $password);

  if ($length >= 8) {
    $strength++;
  }
  if ($hasUppercase && $hasLowercase) {
    $strength++;
  }
  if ($hasNumber) {
    $strength++;
  }
  if ($hasSpecialChar) {
    $strength++;
  }

  return $strength;
}

$passwordLength = 10;
$randomPassword = generateRandomPassword($passwordLength);
$passwordStrength = checkPasswordStrength($randomPassword);

echo "Random Password: $randomPassword\n";
echo "Password Strength: $passwordStrength\n";
