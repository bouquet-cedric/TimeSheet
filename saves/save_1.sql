PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE tasks (
                id integer primary key autoincrement,
                jira varchar NOT NULL,
                date_t date NOT NULL,
                time_t time NOT NULL,
                date date NOT NULL,
                time varchar NOT NULL,
                comment varchar,
                day int,
                month int,
                year int
            );
INSERT INTO tasks VALUES(1,'ODCNG-18121','Friday 13-05-2022','11:05:18','Wednesday 11-05-2022','30','daily',11,5,2022);
INSERT INTO tasks VALUES(2,'ODCNG-18122','Friday 13-05-2022','10:57:47','Wednesday 11-05-2022','1h','non working day',11,5,2022);
INSERT INTO tasks VALUES(3,'ODCNG-18159','Friday 13-05-2022','11:05:06','Wednesday 11-05-2022','6h 30','automatisation indicators',11,5,2022);
INSERT INTO tasks VALUES(4,'ODCNG-18121','Friday 13-05-2022','11:01:38','Thursday 12-05-2022','1h30','daily + TO BE DEFINE',12,5,2022);
INSERT INTO tasks VALUES(5,'ODCNG-18122','Friday 13-05-2022','10:58:18','Thursday 12-05-2022','1h','non working day',12,5,2022);
INSERT INTO tasks VALUES(6,'ODCNG-18159','Friday 13-05-2022','11:03:14','Thursday 12-05-2022','4h 30','automatisation indicators',12,5,2022);
INSERT INTO tasks VALUES(7,'ODECSCNGACCEPTANCE-15782','Friday 13-05-2022','11:00:14','Thursday 12-05-2022','1h','resetAllPassword',12,5,2022);
INSERT INTO tasks VALUES(8,'ODCNG-18121','Friday 13-05-2022','10:57:07','Friday 13-05-2022','30','daily',13,5,2022);
INSERT INTO tasks VALUES(9,'ODCNG-18122','Friday 13-05-2022','10:58:51','Friday 13-05-2022','1h','non working day',13,5,2022);
INSERT INTO tasks VALUES(10,'ODCNG-18159','Friday 13-05-2022','12:29:53','Friday 13-05-2022','3h30','automatisation indicators',13,5,2022);
INSERT INTO tasks VALUES(11,'ODECSCNGACCEPTANCE-15782','Friday 13-05-2022','17:55:54','Friday 13-05-2022','3h','resetAllPassword',13,5,2022);
INSERT INTO tasks VALUES(12,'ODCNG-17229','Tuesday 17-05-2022','11:17:19','Monday 16-05-2022','1h 30','Environment',16,5,2022);
INSERT INTO tasks VALUES(13,'ODCNG-18121','Monday 16-05-2022','14:40:41','Monday 16-05-2022','30','daily',16,5,2022);
INSERT INTO tasks VALUES(14,'ODCNG-18122','Sunday 15-05-2022','20:23:21','Monday 16-05-2022','1h','non working day',16,5,2022);
INSERT INTO tasks VALUES(15,'ODCNG-18159','Monday 16-05-2022','14:41:29','Monday 16-05-2022','3h','automatisation indicators',16,5,2022);
INSERT INTO tasks VALUES(16,'ODECSCNGACCEPTANCE-15782','Monday 16-05-2022','16:24:52','Monday 16-05-2022','2h','resetAllPassword',16,5,2022);
INSERT INTO tasks VALUES(17,'ODCNG-17229','Tuesday 17-05-2022','15:17:29','Tuesday 17-05-2022','3h','Environment',17,5,2022);
INSERT INTO tasks VALUES(18,'ODCNG-18121','Tuesday 17-05-2022','11:15:06','Tuesday 17-05-2022','1h 30','daily + macro-analyse',17,5,2022);
INSERT INTO tasks VALUES(19,'ODCNG-18122','Sunday 15-05-2022','20:23:33','Tuesday 17-05-2022','1h','non working day',17,5,2022);
INSERT INTO tasks VALUES(20,'ODECSCNGACCEPTANCE-15782','Tuesday 17-05-2022','16:50:08','Tuesday 17-05-2022','2h 30','resetAllPassword',17,5,2022);
INSERT INTO tasks VALUES(21,'ODCNG-17229','Wednesday 18-05-2022','13:49:08','Wednesday 18-05-2022','1h 30','Environment',18,5,2022);
INSERT INTO tasks VALUES(22,'ODCNG-18121','Wednesday 18-05-2022','13:43:01','Wednesday 18-05-2022','30','daily',18,5,2022);
INSERT INTO tasks VALUES(23,'ODCNG-18122','Sunday 15-05-2022','20:23:42','Wednesday 18-05-2022','5h','non working day',18,5,2022);
INSERT INTO tasks VALUES(24,'ODECSCNGACCEPTANCE-15645','Wednesday 18-05-2022','13:49:52','Wednesday 18-05-2022','1h','Ergonomy issues',18,5,2022);
INSERT INTO tasks VALUES(25,'ODCNG-18122','Friday 13-05-2022','12:32:30','Thursday 19-05-2022','1d','congés',19,5,2022);
INSERT INTO tasks VALUES(26,'ODCNG-18122','Friday 13-05-2022','12:31:59','Friday 20-05-2022','1d','congés',20,5,2022);
INSERT INTO tasks VALUES(27,'ODCNG-17229','Monday 23-05-2022','11:22:30','Monday 23-05-2022','6h30','Environment',23,5,2022);
INSERT INTO tasks VALUES(28,'ODCNG-18121','Monday 23-05-2022','11:20:14','Monday 23-05-2022','30','daily',23,5,2022);
INSERT INTO tasks VALUES(29,'ODCNG-18122','Monday 23-05-2022','17:33:01','Monday 23-05-2022','1h','non working day',23,5,2022);
INSERT INTO tasks VALUES(30,'ODCNG-17229','Wednesday 25-05-2022','10:25:40','Tuesday 24-05-2022','2h','Environment',24,5,2022);
INSERT INTO tasks VALUES(31,'ODCNG-18121','Wednesday 25-05-2022','10:23:39','Tuesday 24-05-2022','30','daily',24,5,2022);
INSERT INTO tasks VALUES(32,'ODCNG-18122','Wednesday 25-05-2022','10:24:56','Tuesday 24-05-2022','1h','non working day',24,5,2022);
INSERT INTO tasks VALUES(33,'ODECSCNGACCEPTANCE-15782','Tuesday 24-05-2022','11:57:57','Tuesday 24-05-2022','4h30','resetAllPassword',24,5,2022);
INSERT INTO tasks VALUES(34,'ODCNG-17229','Wednesday 25-05-2022','16:57:31','Wednesday 25-05-2022','2h','Environment',25,5,2022);
INSERT INTO tasks VALUES(35,'ODCNG-18121','Wednesday 25-05-2022','10:31:40','Wednesday 25-05-2022','30','daily',25,5,2022);
INSERT INTO tasks VALUES(36,'ODCNG-18122','Wednesday 25-05-2022','10:39:48','Wednesday 25-05-2022','1h','non working day',25,5,2022);
INSERT INTO tasks VALUES(37,'ODECSCNGACCEPTANCE-15645','Wednesday 25-05-2022','11:28:04','Wednesday 25-05-2022','3h','Ergonomy issues',25,5,2022);
INSERT INTO tasks VALUES(38,'ODECSCNGACCEPTANCE-15782','Wednesday 25-05-2022','10:28:02','Wednesday 25-05-2022','1h30','resetAllPassword : MR to report',25,5,2022);
INSERT INTO tasks VALUES(39,'ODCNG-18122','Friday 27-05-2022','09:54:33','Thursday 26-05-2022','1d','jour férié',26,5,2022);
INSERT INTO tasks VALUES(40,'ODCNG-17229','Friday 27-05-2022','12:19:24','Friday 27-05-2022','1h 30','Environment',27,5,2022);
INSERT INTO tasks VALUES(41,'ODCNG-18121','Friday 27-05-2022','09:53:33','Friday 27-05-2022','30','daily',27,5,2022);
INSERT INTO tasks VALUES(42,'ODCNG-18122','Friday 27-05-2022','09:45:22','Friday 27-05-2022','1h','non working day',27,5,2022);
INSERT INTO tasks VALUES(43,'ODECSCNGACCEPTANCE-15645','Friday 27-05-2022','09:44:07','Friday 27-05-2022','1h','Ergonomy issues',27,5,2022);
CREATE TABLE copy_tasks (
                id integer primary key autoincrement,
                jira varchar NOT NULL,
                date_t date NOT NULL,
                time_t time NOT NULL,
                date date NOT NULL,
                time varchar NOT NULL,
                comment varchar,
                day int,
                month int,
                year int
            );
INSERT INTO copy_tasks VALUES(1,'ODCNG-18121','Friday 13-05-2022','11:05:18','Wednesday 11-05-2022','30','daily',11,5,2022);
INSERT INTO copy_tasks VALUES(2,'ODCNG-18122','Friday 13-05-2022','10:57:47','Wednesday 11-05-2022','1h','non working day',11,5,2022);
INSERT INTO copy_tasks VALUES(3,'ODCNG-18159','Friday 13-05-2022','11:05:06','Wednesday 11-05-2022','6h 30','automatisation indicators',11,5,2022);
INSERT INTO copy_tasks VALUES(4,'ODCNG-18121','Friday 13-05-2022','11:01:38','Thursday 12-05-2022','1h30','daily + TO BE DEFINE',12,5,2022);
INSERT INTO copy_tasks VALUES(5,'ODCNG-18122','Friday 13-05-2022','10:58:18','Thursday 12-05-2022','1h','non working day',12,5,2022);
INSERT INTO copy_tasks VALUES(6,'ODCNG-18159','Friday 13-05-2022','11:03:14','Thursday 12-05-2022','4h 30','automatisation indicators',12,5,2022);
INSERT INTO copy_tasks VALUES(7,'ODECSCNGACCEPTANCE-15782','Friday 13-05-2022','11:00:14','Thursday 12-05-2022','1h','resetAllPassword',12,5,2022);
INSERT INTO copy_tasks VALUES(8,'ODCNG-18121','Friday 13-05-2022','10:57:07','Friday 13-05-2022','30','daily',13,5,2022);
INSERT INTO copy_tasks VALUES(9,'ODCNG-18122','Friday 13-05-2022','10:58:51','Friday 13-05-2022','1h','non working day',13,5,2022);
INSERT INTO copy_tasks VALUES(10,'ODCNG-18159','Friday 13-05-2022','12:29:53','Friday 13-05-2022','3h30','automatisation indicators',13,5,2022);
INSERT INTO copy_tasks VALUES(11,'ODECSCNGACCEPTANCE-15782','Friday 13-05-2022','17:55:54','Friday 13-05-2022','3h','resetAllPassword',13,5,2022);
INSERT INTO copy_tasks VALUES(12,'ODCNG-17229','Tuesday 17-05-2022','11:17:19','Monday 16-05-2022','1h 30','Environment',16,5,2022);
INSERT INTO copy_tasks VALUES(13,'ODCNG-18121','Monday 16-05-2022','14:40:41','Monday 16-05-2022','30','daily',16,5,2022);
INSERT INTO copy_tasks VALUES(14,'ODCNG-18122','Sunday 15-05-2022','20:23:21','Monday 16-05-2022','1h','non working day',16,5,2022);
INSERT INTO copy_tasks VALUES(15,'ODCNG-18159','Monday 16-05-2022','14:41:29','Monday 16-05-2022','3h','automatisation indicators',16,5,2022);
INSERT INTO copy_tasks VALUES(16,'ODECSCNGACCEPTANCE-15782','Monday 16-05-2022','16:24:52','Monday 16-05-2022','2h','resetAllPassword',16,5,2022);
INSERT INTO copy_tasks VALUES(17,'ODCNG-17229','Tuesday 17-05-2022','15:17:29','Tuesday 17-05-2022','3h','Environment',17,5,2022);
INSERT INTO copy_tasks VALUES(18,'ODCNG-18121','Tuesday 17-05-2022','11:15:06','Tuesday 17-05-2022','1h 30','daily + macro-analyse',17,5,2022);
INSERT INTO copy_tasks VALUES(19,'ODCNG-18122','Sunday 15-05-2022','20:23:33','Tuesday 17-05-2022','1h','non working day',17,5,2022);
INSERT INTO copy_tasks VALUES(20,'ODECSCNGACCEPTANCE-15782','Tuesday 17-05-2022','16:50:08','Tuesday 17-05-2022','2h 30','resetAllPassword',17,5,2022);
INSERT INTO copy_tasks VALUES(21,'ODCNG-17229','Wednesday 18-05-2022','13:49:08','Wednesday 18-05-2022','1h 30','Environment',18,5,2022);
INSERT INTO copy_tasks VALUES(22,'ODCNG-18121','Wednesday 18-05-2022','13:43:01','Wednesday 18-05-2022','30','daily',18,5,2022);
INSERT INTO copy_tasks VALUES(23,'ODCNG-18122','Sunday 15-05-2022','20:23:42','Wednesday 18-05-2022','5h','non working day',18,5,2022);
INSERT INTO copy_tasks VALUES(24,'ODECSCNGACCEPTANCE-15645','Wednesday 18-05-2022','13:49:52','Wednesday 18-05-2022','1h','Ergonomy issues',18,5,2022);
INSERT INTO copy_tasks VALUES(25,'ODCNG-18122','Friday 13-05-2022','12:32:30','Thursday 19-05-2022','1d','congés',19,5,2022);
INSERT INTO copy_tasks VALUES(26,'ODCNG-18122','Friday 13-05-2022','12:31:59','Friday 20-05-2022','1d','congés',20,5,2022);
INSERT INTO copy_tasks VALUES(27,'ODCNG-17229','Monday 23-05-2022','11:22:30','Monday 23-05-2022','6h30','Environment',23,5,2022);
INSERT INTO copy_tasks VALUES(28,'ODCNG-18121','Monday 23-05-2022','11:20:14','Monday 23-05-2022','30','daily',23,5,2022);
INSERT INTO copy_tasks VALUES(29,'ODCNG-18122','Monday 23-05-2022','17:33:01','Monday 23-05-2022','1h','non working day',23,5,2022);
INSERT INTO copy_tasks VALUES(30,'ODCNG-17229','Wednesday 25-05-2022','10:25:40','Tuesday 24-05-2022','2h','Environment',24,5,2022);
INSERT INTO copy_tasks VALUES(31,'ODCNG-18121','Wednesday 25-05-2022','10:23:39','Tuesday 24-05-2022','30','daily',24,5,2022);
INSERT INTO copy_tasks VALUES(32,'ODCNG-18122','Wednesday 25-05-2022','10:24:56','Tuesday 24-05-2022','1h','non working day',24,5,2022);
INSERT INTO copy_tasks VALUES(33,'ODECSCNGACCEPTANCE-15782','Tuesday 24-05-2022','11:57:57','Tuesday 24-05-2022','4h30','resetAllPassword',24,5,2022);
INSERT INTO copy_tasks VALUES(34,'ODCNG-17229','Wednesday 25-05-2022','16:57:31','Wednesday 25-05-2022','2h','Environment',25,5,2022);
INSERT INTO copy_tasks VALUES(35,'ODCNG-18121','Wednesday 25-05-2022','10:31:40','Wednesday 25-05-2022','30','daily',25,5,2022);
INSERT INTO copy_tasks VALUES(36,'ODCNG-18122','Wednesday 25-05-2022','10:39:48','Wednesday 25-05-2022','1h','non working day',25,5,2022);
INSERT INTO copy_tasks VALUES(37,'ODECSCNGACCEPTANCE-15645','Wednesday 25-05-2022','11:28:04','Wednesday 25-05-2022','3h','Ergonomy issues',25,5,2022);
INSERT INTO copy_tasks VALUES(38,'ODECSCNGACCEPTANCE-15782','Wednesday 25-05-2022','10:28:02','Wednesday 25-05-2022','1h30','resetAllPassword : MR to report',25,5,2022);
INSERT INTO copy_tasks VALUES(39,'ODCNG-18122','Friday 27-05-2022','09:54:33','Thursday 26-05-2022','1d','jour férié',26,5,2022);
INSERT INTO copy_tasks VALUES(40,'ODCNG-17229','Friday 27-05-2022','12:19:24','Friday 27-05-2022','1h 30','Environment',27,5,2022);
INSERT INTO copy_tasks VALUES(41,'ODCNG-18121','Friday 27-05-2022','09:53:33','Friday 27-05-2022','30','daily',27,5,2022);
INSERT INTO copy_tasks VALUES(42,'ODCNG-18122','Friday 27-05-2022','09:45:22','Friday 27-05-2022','1h','non working day',27,5,2022);
INSERT INTO copy_tasks VALUES(43,'ODECSCNGACCEPTANCE-15645','Friday 27-05-2022','09:44:07','Friday 27-05-2022','1h','Ergonomy issues',27,5,2022);
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('tasks',43);
INSERT INTO sqlite_sequence VALUES('copy_tasks',43);
CREATE VIEW viewTasks as SELECT * from tasks where id in ( SELECT id
                    FROM tasks 
                    ORDER BY year desc,month desc,day desc) order by year,month,day,jira;
COMMIT;
