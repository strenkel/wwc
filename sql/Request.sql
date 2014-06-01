-- Some request for analyzing the results

-- Scores
SELECT w1.name, w2.name, s.points1, s.points2 FROM score s join worker w1 join worker w2 ON s.player1 = w1.id and s.player2 = w2.id order by w1.name, w2.name;