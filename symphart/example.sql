-- get book name and authors in the one line
SELECT b.name, GROUP_CONCAT( a.first_name)
    FROM book b, authors a, book_author_items ba
    WHERE b.id = ba.book_id AND a.id = ba.author_id AND b.id = 8
GROUP BY 1;

-- have one author only
SELECT b.name, b.id
FROM book b, book_author_items ba
WHERE ba.book_id = b.id
GROUP BY b.id
HAVING COUNT(*) = 1;

-- have two author only
SELECT b.name, b.id
FROM book b, book_author_items ba
WHERE ba.book_id = b.id
GROUP BY b.id
HAVING COUNT(*) = 2;

-- books count by author count
SELECT COUNT(*)
    FROM (SELECT b.id
        FROM book b, book_author_items ba
        WHERE ba.book_id=b.id
        GROUP BY 1
        HAVING COUNT(*) = 2
    ) table1;

-- book name, book id
SELECT b.name, b.id
    FROM book b, book_author_items ba
    WHERE ba.book_id=b.id
    GROUP BY b.id
    HAVING COUNT(*) = 1; -- = 2 || > 2 | etc ...

-- filter by book publish year and specific author
SELECT *
    FROM book b, book_author_items ba, authors a
    WHERE
        YEAR(b.publish_date) = '1996' -- filter by year
        AND b.name LIKE 'Auth%' -- filter by name
        AND a.id = 8 -- filter by author
        AND a.first_name LIKE 'Ry%' -- filter by author first name
        AND a.id = ba.author_id
        AND b.id = ba.book_id

-- using join
SELECT title
FROM book b
    JOIN author_book ab ON b.id = ab.book_id
    JOIN author a ON a.id = ab.author_id
WHERE a.first_name = '';


SELECT a.id, a.first_name, a.last_name, ba.author_id, ba.book_id, b.title
    FROM author a
    LEFT JOIN book_author ba ON a.id=ba.author_id
    LEFT JOIN book b ON b.id=ba.book_id;

-- book with more than one author
SELECT COUNT(ba.author_id), ba.book_id
FROM author a
    LEFT JOIN book_author ba ON a.id=ba.author_id
    LEFT JOIN book b ON b.id=ba.book_id
GROUP BY ba.book_id HAVING COUNT (ba.author_id) > 1;
