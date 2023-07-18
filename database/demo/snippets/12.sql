-- Create a table for a music streaming platform
CREATE TABLE songs (
  song_id INT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  artist VARCHAR(100) NOT NULL,
  genre VARCHAR(50),
  duration INT,
  plays INT DEFAULT 0
);

-- Insert sample data
INSERT INTO songs (song_id, title, artist, genre, duration)
VALUES
  (1, 'Bohemian Rhapsody', 'Queen', 'Rock', 355),
  (2, 'Shape of You', 'Ed Sheeran', 'Pop', 233),
  (3, 'Hotel California', 'Eagles', 'Rock', 391),
  (4, 'Despacito', 'Luis Fonsi', 'Latin', 228);

-- Display all songs in the database
SELECT * FROM songs;

-- Update the number of plays for a song
UPDATE songs
SET plays = plays + 1
WHERE song_id = 2;

-- Display top 3 most played songs
SELECT * FROM songs
ORDER BY plays DESC
LIMIT 3;

-- Count the number of songs in the Rock genre
SELECT COUNT(*) FROM songs WHERE genre = 'Rock';

-- Calculate the average duration of songs
SELECT AVG(duration) FROM songs;

-- Delete a song from the database
DELETE FROM songs WHERE song_id = 4;

-- Display songs with a duration greater than 4 minutes
SELECT * FROM songs WHERE duration > 240;
