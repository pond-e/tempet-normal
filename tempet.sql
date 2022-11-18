PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;

Create Table user_info(
  user TEXT,
  password TEXT,
  session TEXT,
  power	TEXT,
  cooling TEXT,
  dehumidification TEXT,
  temperature TEXT,
  heating TEXT,
  stop_button TEXT
);

Insert into user_info values(
  'admin',
  'admin',
  'padding',
  'false',
  'false',
  'false',
  'false',
  'false',
  'false'
);

COMMIT;
