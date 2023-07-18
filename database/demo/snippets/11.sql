-- Create a table for a library management system
CREATE TABLE books (
  book_id INT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  author VARCHAR(100) NOT NULL,
  publication_year INT,
  available BOOLEAN DEFAULT true
);

-- Insert sample data
INSERT INTO books (book_id, title, author, publication_year)
VALUES
  (1, 'The Great Gatsby', 'F. Scott Fitzgerald', 1925),
  (2, 'To Kill a Mockingbird', 'Harper Lee', 1960),
  (3, '1984', 'George Orwell', 1949),
  (4, 'Pride and Prejudice', 'Jane Austen', 1813);

-- Display all books in the library
SELECT * FROM books;

-- Update availability of a book
UPDATE books
SET available = false
WHERE book_id = 3;

-- Display available books
SELECT * FROM books WHERE available = true;

-- Count the number of books published before 1900
SELECT COUNT(*) FROM books WHERE publication_year < 1900;

-- Delete a book from the library
DELETE FROM books WHERE book_id = 4;

-- Calculate the average publication year of the books
SELECT AVG(publication_year) FROM books;
