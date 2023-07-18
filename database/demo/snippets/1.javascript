const emojis = ["🌟", "💡", "🚀", "🎉", "🌈", "🔥", "💫", "🌺", "🎨", "🎶"];
const phrases = [
  "Keep shining and spreading positivity!",
  "Let your ideas illuminate the world!",
  "Blast off towards your dreams!",
  "Celebrate every moment with joy!",
  "Embrace the colors of life!",
  "Ignite your passions and unleash your potential!",
  "Reach for the stars and create your own constellation!",
  "Blossom and bloom like a beautiful flower!",
  "Paint your life with vibrant hues!",
  "Let the music of your soul guide you!"
];

const getRandomElement = (arr) => arr[Math.floor(Math.random() * arr.length)];

const generateRandomMessage = () => {
  const emoji = getRandomElement(emojis);
  const phrase = getRandomElement(phrases);
  return `${emoji} ${phrase} ${emoji}`;
};

console.log(generateRandomMessage());
