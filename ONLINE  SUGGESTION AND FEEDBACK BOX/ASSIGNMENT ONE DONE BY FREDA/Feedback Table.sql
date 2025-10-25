CREATE TABLE feedback (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  feedback TEXT NOT NULL,
  rating INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO feedback (name, email, feedback, rating) VALUES ('John Doe', 'john@example.com', 'This is a sample feedback.', 5);

SELECT * FROM feedback;
SELECT name, email, feedback FROM feedback;
SELECT * FROM feedback WHERE rating = 5;

UPDATE feedback SET rating = 4 WHERE id = 1;
UPDATE feedback SET feedback = 'New feedback' WHERE id = 1;

DELETE FROM feedback WHERE id = 1;

CREATE INDEX idx_feedback_name ON feedback (name);
CREATE INDEX idx_feedback_email ON feedback (email);

DROP INDEX idx_feedback_name ON feedback;
DROP INDEX idx_feedback_email ON feedback;

TRUNCATE TABLE feedback;
DROP TABLE feedback;