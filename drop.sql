# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.2.1                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          moviseries.dez                                  #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2017-05-02 11:50                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `movies_categories` DROP FOREIGN KEY `movies_movies_categories`;

ALTER TABLE `movies_categories` DROP FOREIGN KEY `categories_movies_categories`;

ALTER TABLE `movies_urls` DROP FOREIGN KEY `movies_movies_urls`;

ALTER TABLE `movies_urls` DROP FOREIGN KEY `urls_movies_urls`;

ALTER TABLE `seasons` DROP FOREIGN KEY `series_seasons`;

ALTER TABLE `seasons_urls` DROP FOREIGN KEY `seasons_seasons_urls`;

ALTER TABLE `seasons_urls` DROP FOREIGN KEY `urls_seasons_urls`;

ALTER TABLE `passwords_reset` DROP FOREIGN KEY `users_passwords_reset`;

ALTER TABLE `movies_score` DROP FOREIGN KEY `users_movies_score`;

ALTER TABLE `movies_score` DROP FOREIGN KEY `movies_movies_score`;

ALTER TABLE `series_score` DROP FOREIGN KEY `users_series_score`;

ALTER TABLE `series_score` DROP FOREIGN KEY `series_series_score`;

ALTER TABLE `categories_series` DROP FOREIGN KEY `categories_categories_series`;

ALTER TABLE `categories_series` DROP FOREIGN KEY `series_categories_series`;

ALTER TABLE `mega_movies` DROP FOREIGN KEY `movies_mega_movies`;

ALTER TABLE `mega_seasons` DROP FOREIGN KEY `seasons_mega_seasons`;

# ---------------------------------------------------------------------- #
# Drop table "mega_seasons"                                              #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `mega_seasons` MODIFY `mega_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `mega_seasons` ALTER COLUMN `language_name` DROP DEFAULT;

ALTER TABLE `mega_seasons` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `mega_seasons`;

# ---------------------------------------------------------------------- #
# Drop table "mega_movies"                                               #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `mega_movies` MODIFY `mega_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `mega_movies` ALTER COLUMN `language_name` DROP DEFAULT;

ALTER TABLE `mega_movies` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `mega_movies`;

# ---------------------------------------------------------------------- #
# Drop table "categories_series"                                         #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `categories_series` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `categories_series`;

# ---------------------------------------------------------------------- #
# Drop table "series_score"                                              #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `series_score` ALTER COLUMN `score` DROP DEFAULT;

ALTER TABLE `series_score` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `series_score`;

# ---------------------------------------------------------------------- #
# Drop table "movies_score"                                              #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `movies_score` ALTER COLUMN `score` DROP DEFAULT;

ALTER TABLE `movies_score` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `movies_score`;

# ---------------------------------------------------------------------- #
# Drop table "passwords_reset"                                           #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `passwords_reset` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `passwords_reset`;

# ---------------------------------------------------------------------- #
# Drop table "seasons_urls"                                              #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `seasons_urls` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `seasons_urls`;

# ---------------------------------------------------------------------- #
# Drop table "seasons"                                                   #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `seasons` MODIFY `season_id` INTEGER(20) NOT NULL;

# Drop constraints #

ALTER TABLE `seasons` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `seasons`;

# ---------------------------------------------------------------------- #
# Drop table "series"                                                    #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `series` MODIFY `serie_id` INTEGER(20) NOT NULL;

# Drop constraints #

ALTER TABLE `series` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `series`;

# ---------------------------------------------------------------------- #
# Drop table "movies_urls"                                               #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `movies_urls` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `movies_urls`;

# ---------------------------------------------------------------------- #
# Drop table "urls"                                                      #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `urls` MODIFY `url_id` INTEGER(20) NOT NULL;

# Drop constraints #

ALTER TABLE `urls` ALTER COLUMN `quality` DROP DEFAULT;

ALTER TABLE `urls` ALTER COLUMN `server` DROP DEFAULT;

ALTER TABLE `urls` ALTER COLUMN `language_name` DROP DEFAULT;

ALTER TABLE `urls` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `urls`;

# ---------------------------------------------------------------------- #
# Drop table "movies_categories"                                         #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `movies_categories` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `movies_categories`;

# ---------------------------------------------------------------------- #
# Drop table "categories"                                                #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `categories` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `categories`;

# ---------------------------------------------------------------------- #
# Drop table "movies"                                                    #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `movies` MODIFY `movie_id` INTEGER(20) NOT NULL;

# Drop constraints #

ALTER TABLE `movies` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `movies`;

# ---------------------------------------------------------------------- #
# Drop table "users"                                                     #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `users` MODIFY `user_id` INTEGER(20) NOT NULL;

# Drop constraints #

ALTER TABLE `users` ALTER COLUMN `user_type` DROP DEFAULT;

ALTER TABLE `users` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `users`;
