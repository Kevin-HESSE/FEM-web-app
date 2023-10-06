TRUNCATE TABLE "category", "rating", "video", "user", "user_video", "reset_password_request" RESTART IDENTITY;
ALTER SEQUENCE IF EXISTS category_id_seq RESTART;
ALTER SEQUENCE IF EXISTS rating_id_seq RESTART;
ALTER SEQUENCE IF EXISTS user_id_seq RESTART;
ALTER SEQUENCE IF EXISTS video_id_seq RESTART;


INSERT INTO
    category
    VALUES
        (nextval('category_id_seq'), 'Movies', 'movies'),
        (nextval('category_id_seq'), 'TV Series', 'tv-series');

-- ALTER SEQUENCE

INSERT INTO
    rating
    VALUES
        (nextval('rating_id_seq'), 'PG'),
        (nextval('rating_id_seq'), 'E'),
        (nextval('rating_id_seq'), '18+');

INSERT INTO
    video(id, title, slug, release_at, is_trending, category_id, rating_id)
    VALUES
        (nextval('video_id_seq'),'Beyond Earth', 'beyond-earth', '2019-01-01',  true, 1, 1),
        (nextval('video_id_seq'),'Bottom Gear', 'bottom-gear', '2021-01-01',  true, 1, 1),
        (nextval('video_id_seq'),'Undiscovered Cities', 'undiscovered-cities', '2019-01-01',  true, 1, 3),
        (nextval('video_id_seq'),'1998', '1998', '2021-01-01',  true, 1, 1),
        (nextval('video_id_seq'),'Dark Side of the Moon', 'dark-side-of-the-moon', '2018-01-01',  true, 1, 1),
        (nextval('video_id_seq'), 'The Great Lands', 'the-great-lands', '2019-01-01',  false, 1, 2),
        (nextval('video_id_seq'), 'The Diary', 'the-diary', '2019-01-01',  false, 2, 1),
        (nextval('video_id_seq'), 'Earth’s Untouched', 'earths-untouched', '2017-01-01',  false, 1, 3),
        (nextval('video_id_seq'), 'No Land Beyond', 'no-land-beyond', '2019-01-01',  false, 1, 2),
        (nextval('video_id_seq'), 'During the Hunt', 'during-the-hunt', '2016-01-01',  false, 2, 1),
        (nextval('video_id_seq'), 'Autosport the Series', 'autosport-the-series', '2016-01-01',  false, 2, 3),
        (nextval('video_id_seq'), 'Same Answer II', 'same-answer-2', '2017-01-01',  false, 1, 2),
        (nextval('video_id_seq'), 'Below Echo', 'below-echo', '2016-01-01',  false, 2, 1),
        (nextval('video_id_seq'), 'The Rockies', 'the-rockies', '2016-01-01',  false, 2, 1),
        (nextval('video_id_seq'), 'Relentless', 'relentless', '2017-01-01',  false, 2, 1),
        (nextval('video_id_seq'), 'Community of Ours', 'community-of-ours', '2018-01-01', false, 2, 3),
        (nextval('video_id_seq'), 'Van Life', 'van-life', '2017-01-01', false, 1, 1),
        (nextval('video_id_seq'), 'The Heiress', 'the-heiress', '2021-01-01', false, 1, 1),
        (nextval('video_id_seq'), 'Off the Track', 'off-the-track', '2017-01-01', false, 1, 3),
        (nextval('video_id_seq'), 'Whispering Hill', 'whispering-hill', '2017-01-01', false, 1, 2),
        (nextval('video_id_seq'), '112', '112', '2013-01-01', false, 2, 1),
        (nextval('video_id_seq'), 'Lone Heart', 'lone-heart', '2017-01-01', false, 1, 2),
        (nextval('video_id_seq'), 'Dogs', 'dogs', '2016-01-01', false, 2, 2),
        (nextval('video_id_seq'), 'Asia in 24 Days', 'asia-in-24-days', '2020-01-01', false, 2, 1),
        (nextval('video_id_seq'), 'The Tasty Tour', 'the-tasty-tour', '2016-01-01', false, 2, 1),
        (nextval('video_id_seq'), 'Darker', 'darker', '2017-01-01', false, 1, 3),
        (nextval('video_id_seq'), 'Unresolved Cases', 'unresolved-cases', '2018-01-01', false, 2, 3),
        (nextval('video_id_seq'), 'Mission: Saturn', 'mission-saturn', '2017-01-01', false, 1, 1)
        ;

INSERT INTO
    "user" (id, username, email, password, roles, is_verified)
    VALUES
        (nextval('user_id_seq'), 'admin', 'admin@entertainment.io', '$2y$13$h10aCprVAkF8V6.IhNGXQOUbKTATyeOxZ/8vD6OpSWSizSEpDyLc2', '{}', true),
        (nextval('user_id_seq'), 'test', 'test@entertainment.io', '$2y$13$h10aCprVAkF8V6.IhNGXQOUbKTATyeOxZ/8vD6OpSWSizSEpDyLc2', '{}', false);

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