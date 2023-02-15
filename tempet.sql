PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;

Create Table user_info(
  user TEXT,
  password TEXT,
  selected_pet TEXT,
  receive	TEXT,
  state TEXT,
  temperature TEXT
);

Insert into user_info values(
  'admin',
  'admin',
  'dogcatbird',
  'none',
  'stop',
  '19.0'
);

COMMIT;
