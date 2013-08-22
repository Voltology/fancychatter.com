ALTER TABLE livechatter ADD COLUMN alerted int(11) AFTER status;
ALTER TABLE searches ADD COLUMN latitude float(10,8) AFTER location;
ALTER TABLE searches ADD COLUMN longitude float(10,8) AFTER latitude;

CREATE INDEX alerted_idx ON livechatter (alerted) USING btree;
CREATE INDEX latitude_idx ON searches (latitude) USING btree;
CREATE INDEX longitude_idx ON searches (longitude) USING btree;
