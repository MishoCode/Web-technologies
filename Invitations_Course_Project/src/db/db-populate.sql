INSERT INTO users (fn, email, password, first_name, last_name, course, specialty)
VALUES ('11111', 'ivan@abv.bg', '$2y$10$1.rr/4Y2eWDjsec99ylO2uQozYkW93jefehH/UWMKzpnFNSMWySFC', 'Ivan', 'Ivanov', '4', 'KN');

INSERT INTO users (fn, email, password, first_name, last_name, course, specialty)
VALUES ('11112', 'gosho@abv.bg', '$2y$10$l8BWv/6doXjZrqmNLytkd.bvIg3BS1U8ZNd.XwtzvY2.dODSLfWn6', 'Georgi', 'Ivanov', '4', 'KN');

INSERT INTO invitations (title, place, date, time, end_time, filename, presenter_fn)
VALUES ('DOM', 'fmi 02', '2023-03-09', '10:00:00', '10:10:00', 'gosho@abv.bg_meme1.jpg', '11112');

INSERT INTO invitations (title, place, date, time, end_time, filename, presenter_fn)
VALUES ('CSS Basics', 'fmi 02', '2023-04-17', '10:00:00', '10:10:00', 'ivan@abv.bg_meme2.jpg', '11111');