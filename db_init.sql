CREATE DATABASE CodeAndPunch;
USE CodeAndPunch;
CREATE TABLE information (
user_id int(11) NOT NULL primary key AUTO_INCREMENT unique,
username nvarchar(50) not null,
role boolean,
password nvarchar(255) not null,
full_name nvarchar(50),
email nvarchar(100),
phone_num varchar(10));

INSERT INTO information ()
VALUES
(1,N'Ak3tsuk1_0biw1ns', 1, 'cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90', N'Phạm Việt Thắng', 'thangpvhayluanguoi@gmail.com', '0987123456'),
(2,'EHC_NguyenHoangQuan', 0, 'bc502a15547fd68c71ac8643b27b2124a7f9faa66e3bfd2d2b99d40468e4eafd', N'Nguyễn Hoàng Quân', 'quannhuytinvl@gmail.com', '0999888999'),
(3,'d3ckk_no0b', 1, 'cabf92a325311830230d8bb4acc712fcf09380a35be871f0d2ccf92add5e9da8', N'Nguyễn Văn Đức', 'ducnvbcm@gmail.com', '0999999999'),
(4,'NghiaGermany', 0, 'b2cff4b2c53d6b998cda86d738e09ece26f46c5aa0d29724eb9e5d74f594f333', N'Trần Đức Nghĩa', 'nghiatdhe17@gmail.com', '0123456789'),
(5,'XanhhnaX', 1, 'd510ce394c546e3d2de98b97dff4b13854a46bc5f67a339be1a69aaf064bf965', N'Giáp Nhật Ánh', 'anhgnhe179999@gmail.com', '0123123123'),
(6,'EHC_DangMinhTri', 0, '8fc3754ba3fbef476143e4e6f31310d6e5aa7f4a5ac00da7a52fbcc425e7a25b', N'Đặng Minh Trí', 'tridmhe188888@gmail.com', '0234234234'),
(7,'twentysick', 1, '452d82eb73c727d60b57d901a42a774c5fa9ff50cb328f7eff476d53fc1911e6', N'Cao Tất Thành', 'thanhctpcn@gmail.com', '0987987987'),
(8,'EHC_0r3o', 0, '9340f31f35b19eabc1fa2bb32c6dde0ddcb1ffe9a6d70621b353b17e8f272ba7', N'Hà Đình Tâm', 'tamhdhe170850@gmail.com', '0385022103'),
(9,'test', 0, '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', N'abcabc', 'hihi@gmail.com', '111111'),
(10,'teacher', 1, '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', N'Super Teacher', 'teacher@gmail.com', '0111111111');



CREATE TABLE `codeandpunch`.`homework` (`homework_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT , `tittle` NVARCHAR(255) ,`description` NVARCHAR(512) ,`file_name` NVARCHAR(512) ,  `date` DATE , `current_submission` INT(11) ) ENGINE = InnoDB;
INSERT INTO `homework` ()
VALUES ('1', 'First test','This is a first test for you','test.txt',  '2023-05-31', '0')


CREATE TABLE `student_homework` (`student_id` INT(11), `homework_id` INT(11), `file_name` NVARCHAR(512)) ENGINE = InnoDB;
