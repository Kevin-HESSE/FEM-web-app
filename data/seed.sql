TRUNCATE TABLE "category", "rating", "video", "user", "user_video" RESTART IDENTITY;

INSERT INTO
    category
    VALUES
        (1, 'Movies', 'movies'),
        (2, 'TV Series', 'tv-series');

INSERT INTO
    rating
    VALUES
        (1, 'PG'),
        (2, 'E'),
        (3, '18+');

INSERT INTO
    video(id, title, slug, release_at, is_trending, category_id, rating_id)
    VALUES
        (1,'Beyond Earth', 'beyond-earth', '2019-01-01',  true, 1, 1),
        (2,'Bottom Gear', 'bottom-gear', '2021-01-01',  true, 1, 1),
        (3,'Undiscovered Cities', 'undiscovered-cities', '2019-01-01',  true, 1, 3),
        (4,'1998', '1998', '2021-01-01',  true, 1, 1),
        (5,'Dark Side of the Moon', 'dark-side-of-the-moon', '2018-01-01',  true, 1, 1),
        (6, 'The Great Lands', 'the-great-lands', '2019-01-01',  false, 1, 2),
        (7, 'The Diary', 'the-diary', '2019-01-01',  false, 2, 1),
        (8, 'Earth’s Untouched', 'earths-untouched', '2017-01-01',  false, 1, 3),
        (9, 'No Land Beyond', 'no-land-beyond', '2019-01-01',  false, 1, 2),
        (10, 'During the Hunt', 'during-the-hunt', '2016-01-01',  false, 2, 1),
        (11, 'Autosport the Series', 'autosport-the-series', '2016-01-01',  false, 2, 3),
        (12, 'Same Answer II', 'same-answer-2', '2017-01-01',  false, 1, 2),
        (13, 'Below Echo', 'below-echo', '2016-01-01',  false, 2, 1),
        (14, 'The Rockies', 'the-rockies', '2016-01-01',  false, 2, 1),
        (15, 'Relentless', 'relentless', '2017-01-01',  false, 2, 1),
        (16, 'Community of Ours', 'community-of-ours', '2018-01-01', false, 2, 3),
        (17, 'Van Life', 'van-life', '2017-01-01', false, 1, 1),
        (18, 'The Heiress', 'the-heiress', '2021-01-01', false, 1, 1),
        (19, 'Off the Track', 'off-the-track', '2017-01-01', false, 1, 3),
        (20, 'Whispering Hill', 'whispering-hill', '2017-01-01', false, 1, 2),
        (21, '112', '112', '2013-01-01', false, 2, 1),
        (22, 'Lone Heart', 'lone-heart', '2017-01-01', false, 1, 2),
        (23, 'Dogs', 'dogs', '2016-01-01', false, 2, 2),
        (24, 'Asia in 24 Days', 'asia-in-24-days', '2020-01-01', false, 2, 1),
        (25, 'The Tasty Tour', 'the-tasty-tour', '2016-01-01', false, 2, 1),
        (26, 'Darker', 'darker', '2017-01-01', false, 1, 3),
        (27, 'Unresolved Cases', 'unresolved-cases', '2018-01-01', false, 2, 3),
        (28, 'Mission: Saturn', 'mission-saturn', '2017-01-01', false, 1, 1)
        ;

INSERT INTO
    "user" (id, username, email, password, roles, is_verified)
    VALUES
        (1, 'toto', 'toto@test.io', '$2y$13$h10aCprVAkF8V6.IhNGXQOUbKTATyeOxZ/8vD6OpSWSizSEpDyLc2', '{}', true),
        (2, 'tata', 'tata@test.io', '$2y$13$h10aCprVAkF8V6.IhNGXQOUbKTATyeOxZ/8vD6OpSWSizSEpDyLc2', '{}', true);

INSERT INTO
    user_video
    VALUES
        (1, 5),
        (1, 8),
        (1, 15),
        (1, 18),
        (1, 19),
        (1, 22),
        (1, 23),
        (1, 26),
        (1, 28),
        (2,3),
        (2,5);