
$adjectives = ['Crazy', 'Brilliant', 'Daring', 'Energetic', 'Fantastic'];
$nouns = ['Hacker', 'Ninja', 'Wizard', 'Juggler', 'Champion'];

$randomAdjective = $adjectives[array_rand($adjectives)];
$randomNoun = $nouns[array_rand($nouns)];

$username = $randomAdjective . $randomNoun . rand(100, 999);

echo "Generated Username: $username";
