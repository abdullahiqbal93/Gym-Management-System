-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 17, 2024 at 08:11 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_message_tbl`
--

DROP TABLE IF EXISTS `admin_message_tbl`;
CREATE TABLE IF NOT EXISTS `admin_message_tbl` (
  `msg_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int DEFAULT NULL,
  `message` text,
  `date` date DEFAULT NULL,
  `msg_type` enum('warning','normal') DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_message_tbl`
--

INSERT INTO `admin_message_tbl` (`msg_id`, `member_id`, `message`, `date`, `msg_type`) VALUES
(15, 35, 'Please remember to bring a towel to the gym.', '2024-02-10', 'normal'),
(16, 36, 'Reminder: Yoga class moved to 5 PM today.', '2024-02-15', 'normal'),
(17, 37, 'Your membership renewal is due next week.', '2024-02-20', 'normal'),
(18, 38, 'Warning: Excessive noise complaints reported.', '2024-02-25', 'warning'),
(19, 39, 'Reminder: Personal training session tomorrow.', '2024-02-28', 'normal'),
(20, 40, 'Message for testing purposes.', '2024-03-01', 'normal');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
CREATE TABLE IF NOT EXISTS `announcement` (
  `announcement_id` int NOT NULL AUTO_INCREMENT,
  `message` text,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`announcement_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `message`, `date`) VALUES
(8, 'New class schedule starting next week.', '2024-02-20'),
(9, 'Upcoming holiday schedule changes.', '2024-02-25'),
(10, 'Reminder: Gym closed for maintenance tomorrow.', '2024-02-28'),
(11, 'Special offer: Refer a friend and get 10% off.', '2024-03-01'),
(12, 'Nutrition workshop this Saturday, sign up now!', '2024-03-05'),
(13, 'Congratulations to our member of the month!', '2024-03-10');

-- --------------------------------------------------------

--
-- Table structure for table `bmi_table`
--

DROP TABLE IF EXISTS `bmi_table`;
CREATE TABLE IF NOT EXISTS `bmi_table` (
  `bmi_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`bmi_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bmi_table`
--

INSERT INTO `bmi_table` (`bmi_id`, `member_id`, `height`, `weight`, `bmi`) VALUES
(1, 35, 175.00, 75.00, 24.49),
(2, 36, 160.00, 60.00, 23.44),
(3, 37, 180.00, 85.00, 26.23),
(4, 38, 170.00, 70.00, 24.22),
(5, 39, 165.00, 55.00, 20.20),
(6, 40, 172.00, 80.00, 27.04);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `payment_status` enum('pending','paid','expired') DEFAULT 'pending',
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approval_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `member_id` (`member_id`),
  KEY `package_id` (`package_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `member_id`, `package_id`, `booking_date`, `payment_status`, `approval_status`, `approval_date`, `expiry_date`) VALUES
(1, 35, 1, '2024-03-01', 'paid', 'approved', '2024-03-01', '2024-04-01'),
(2, 36, 2, '2024-03-02', 'paid', 'approved', '2024-03-02', '2024-04-02'),
(3, 37, 3, '2024-03-03', 'pending', 'pending', '0000-00-00', '0000-00-00'),
(4, 38, 4, '2024-03-04', 'pending', 'pending', '0000-00-00', '0000-00-00'),
(5, 39, 5, '2024-03-05', 'pending', 'pending', '0000-00-00', '0000-00-00'),
(9, 40, 1, '2024-03-06', 'pending', 'pending', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE IF NOT EXISTS `equipment` (
  `equipment_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `description` text,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`equipment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `name`, `quantity`, `description`, `unit_price`, `photo`) VALUES
(33, 'Yoga Mats', 15, 'High-quality yoga mats for floor exercises', 20.00, './image/equipments/mat2.jpg'),
(32, 'Dumbbells', 20, 'Set of rubber-coated dumbbells in various weights', 500.00, './image/equipments/dumbell.jpg'),
(31, 'Treadmill', 5, 'Commercial-grade treadmill for cardio workouts', 2500.00, './image/equipments/treadmil.jpg'),
(34, 'Stationary Bike', 8, 'Indoor cycling equipment for cardio workouts', 1200.00, './image/equipments/bicycle.jpg'),
(35, 'Barbell Set', 10, 'Professional-grade barbell set for weightlifting', 800.00, './image/equipments/barbell.jpg'),
(38, 'Rowing Machine', 5, 'Indoor rowing machine for full-body workout', 12500.00, './image/equipments/row_machine.jpg'),
(39, 'Exercise Ball', 15, 'Large exercise ball for core strengthening exercises', 1000.00, './image/equipments/ball.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `membership_type` enum('monthly','yearly') DEFAULT 'monthly',
  `account_status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `full_name`, `dob`, `gender`, `contact_no`, `email`, `password`, `photo`, `doj`, `membership_type`, `account_status`) VALUES
(35, 'John Doe', '1990-05-15', 'male', '1234567890', 'john@example.com', 'password123', 'john_photo.jpg', '2024-02-01', 'monthly', 'active'),
(36, 'Jane Smith', '1988-09-20', 'female', '9876543210', 'jane@example.com', 'pass321word', 'jane_photo.jpg', '2024-02-02', 'monthly', 'active'),
(37, 'Michael Johnson', '1995-07-03', 'male', '4567890123', 'michael@example.com', 'securepwd456', 'michael_photo.jpg', '2024-02-03', 'monthly', 'active'),
(38, 'Emily Davis', '1993-12-18', 'female', '7890123456', 'emily@example.com', 'p@ssw0rd789', 'emily_photo.jpg', '2024-02-04', 'yearly', 'active'),
(39, 'David Wilson', '1985-04-25', 'male', '3210987654', 'david@example.com', 'strongpass789', 'david_photo.jpg', '2024-02-05', 'yearly', 'active'),
(40, 'Sarah Taylor', '1998-10-10', 'female', '6543210987', 'sarah@example.com', 'secretp@ss123', 'sarah_photo.jpg', '2024-02-06', 'yearly', 'active'),
(42, 'Muneef', '2002-01-28', 'female', '0773135254', 'moha7@gmail.com', '1234', NULL, '2024-03-04', 'monthly', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `membership_fee`
--

DROP TABLE IF EXISTS `membership_fee`;
CREATE TABLE IF NOT EXISTS `membership_fee` (
  `fee_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `payment_id` int NOT NULL,
  `fee_month` int DEFAULT NULL,
  `fee_status` enum('paid','due') DEFAULT 'paid',
  PRIMARY KEY (`fee_id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `membership_fee`
--

INSERT INTO `membership_fee` (`fee_id`, `member_id`, `payment_id`, `fee_month`, `fee_status`) VALUES
(18, 39, 8, 2024, 'paid'),
(17, 38, 7, 2, 'paid'),
(16, 37, 6, 2, 'paid'),
(15, 36, 5, 2, 'paid'),
(14, 35, 4, 2, 'paid'),
(31, 41, 24, 11, 'paid'),
(29, 41, 35, 2, 'paid'),
(27, 40, 9, 2024, 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `member_message_tbl`
--

DROP TABLE IF EXISTS `member_message_tbl`;
CREATE TABLE IF NOT EXISTS `member_message_tbl` (
  `msg_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int DEFAULT NULL,
  `message` text,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `member_message_tbl`
--

INSERT INTO `member_message_tbl` (`msg_id`, `member_id`, `message`, `date`) VALUES
(25, 35, 'Please change my schedule', '2024-03-29'),
(26, 36, 'today gym open or not', '2024-02-28'),
(27, 37, 'i cant come today', '2024-02-27'),
(28, 38, 'can you reduce my schedule price', '2024-02-26'),
(29, 39, 'i want to add new schedule', '2024-02-25');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

DROP TABLE IF EXISTS `package`;
CREATE TABLE IF NOT EXISTS `package` (
  `package_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `duration` int DEFAULT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `name`, `description`, `price`, `duration`) VALUES
(1, 'Chest Blast', 'Focuses on developing chest muscles.', 50.00, 30),
(2, 'Abs Core Crusher', 'Targets core muscles for strength and definition.', 60.00, 30),
(3, 'Leg Power', 'Strengthens and tones leg muscles.', 70.00, 30),
(4, 'Arm Sculpt', 'Shapes and defines arm muscles.', 55.00, 30),
(5, 'Cardio Burn', 'High-intensity cardio workout for fat burning.', 40.00, 30);

-- --------------------------------------------------------

--
-- Table structure for table `package_workout`
--

DROP TABLE IF EXISTS `package_workout`;
CREATE TABLE IF NOT EXISTS `package_workout` (
  `package_id` int NOT NULL,
  `workout_id` int NOT NULL,
  `sets` int DEFAULT NULL,
  `reps` int DEFAULT NULL,
  PRIMARY KEY (`package_id`,`workout_id`),
  KEY `workout_id` (`workout_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `package_workout`
--

INSERT INTO `package_workout` (`package_id`, `workout_id`, `sets`, `reps`) VALUES
(5, 29, 1, 60),
(5, 28, 1, 60),
(5, 27, 1, 60),
(5, 26, 1, 60),
(4, 25, 3, 15),
(4, 24, 3, 15),
(4, 23, 3, 15),
(4, 22, 3, 15),
(3, 21, 3, 12),
(3, 20, 3, 15),
(3, 19, 3, 12),
(3, 18, 4, 15),
(2, 17, 3, 20),
(2, 16, 3, 20),
(2, 15, 3, 20),
(2, 14, 3, 20),
(1, 13, 3, 12),
(1, 12, 3, 12),
(1, 11, 3, 15),
(1, 10, 4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `fee_month` int DEFAULT NULL,
  `payment_status` enum('pending','approved','declined') DEFAULT 'pending',
  `payment_type` enum('membership','package') DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `package_id` (`package_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `member_id`, `package_id`, `amount`, `payment_date`, `fee_month`, `payment_status`, `payment_type`) VALUES
(10, 35, 1, 50.00, '2024-03-01', NULL, 'approved', 'package'),
(11, 36, 2, 60.00, '2024-03-02', NULL, 'approved', 'package'),
(12, 37, 3, 70.00, '2024-03-03', NULL, 'pending', 'package'),
(13, 38, 4, 55.00, '2024-03-04', NULL, 'pending', 'package'),
(14, 39, 5, 40.00, '2024-03-05', NULL, 'pending', 'package'),
(15, 40, 1, 50.00, '2024-03-06', NULL, 'pending', 'package'),
(4, 35, NULL, 1500.00, '2024-02-01', 2, 'approved', 'membership'),
(5, 36, NULL, 1500.00, '2024-02-02', 2, 'approved', 'membership'),
(6, 37, NULL, 1500.00, '2024-02-03', 2, 'approved', 'membership'),
(7, 38, 0, 17000.00, '2024-02-04', 2024, 'approved', 'membership'),
(8, 39, 0, 17000.00, '2024-02-05', 2024, 'approved', 'membership'),
(9, 40, 0, 17000.00, '2024-02-06', 2024, 'approved', 'membership');

--
-- Triggers `payment`
--
DROP TRIGGER IF EXISTS `after_member_registration`;
DELIMITER $$
CREATE TRIGGER `after_member_registration` AFTER INSERT ON `payment` FOR EACH ROW BEGIN
    IF NEW.payment_type = 'membership' AND NEW.payment_status = 'approved' THEN
        INSERT INTO membership_fee (member_id, payment_id, fee_month, fee_status)
        VALUES (NEW.member_id, NEW.payment_id, NEW.fee_month, 'paid');
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_payment_approval`;
DELIMITER $$
CREATE TRIGGER `after_payment_approval` AFTER UPDATE ON `payment` FOR EACH ROW BEGIN
    IF OLD.payment_status = 'pending' AND NEW.payment_status = 'approved' THEN
        UPDATE booking
        SET payment_status = 'paid'
        WHERE member_id = NEW.member_id AND package_id = NEW.package_id;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_payment_revert`;
DELIMITER $$
CREATE TRIGGER `after_payment_revert` AFTER UPDATE ON `payment` FOR EACH ROW BEGIN
    IF OLD.payment_status = 'approved' AND NEW.payment_status = 'pending' THEN
        UPDATE booking
        SET payment_status = 'pending'
        WHERE member_id = NEW.member_id AND package_id = NEW.package_id;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `payment_approval_trigger`;
DELIMITER $$
CREATE TRIGGER `payment_approval_trigger` AFTER UPDATE ON `payment` FOR EACH ROW BEGIN
    IF NEW.payment_type = 'membership' AND OLD.payment_status = 'pending' AND NEW.payment_status = 'approved' THEN
        INSERT INTO membership_fee (member_id, payment_id, fee_month, fee_status)
        VALUES (NEW.member_id, NEW.payment_id, NEW.fee_month, 'paid');
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int DEFAULT NULL,
  PRIMARY KEY (`schedule_id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `booking_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

DROP TABLE IF EXISTS `trainer`;
CREATE TABLE IF NOT EXISTS `trainer` (
  `trainer_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`trainer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`trainer_id`, `full_name`, `specialization`, `contact_no`, `email`, `salary`, `photo`) VALUES
(13, 'Michael Johnson', 'CrossFit Trainer', '0764562453', 'michael.j@example.com', 2800.00, './image/trainers/t5.jpg'),
(11, 'John Doe', 'Personal Trainer', '0774569853', 'john.doe@example.com', 3000.00, './image/trainers/t6.jpg'),
(12, 'Jane Smith', 'Yoga Instructor', '0784543853', 'jane.smith@example.com', 2500.00, './image/trainers/t7.jpg'),
(14, 'Samantha Lee', 'Pilates Instructor', '0777854264', 'samantha.lee@example.com', 2600.00, './image/trainers/t4.jpg'),
(15, 'Adam Brown', 'Nutritionist', '0774155264', 'adam.brown@example.com', 2700.00, './image/trainers/t3.jpg'),
(16, 'Laura Wilson', 'Zumba Instructor', '0768585264', 'laura.wilson@example.com', 2400.00, './image/trainers/t8.jpg'),
(17, 'Chris Evans', 'Boxing Trainer', '0727624264', 'chris.evans@example.com', 2800.00, './image/trainers/t1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `workout`
--

DROP TABLE IF EXISTS `workout`;
CREATE TABLE IF NOT EXISTS `workout` (
  `workout_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`workout_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `workout`
--

INSERT INTO `workout` (`workout_id`, `name`, `description`) VALUES
(10, 'Bench Press', 'Strengthens chest muscles.'),
(11, 'Push-ups', 'Bodyweight exercise targeting chest and arms.'),
(12, 'Dumbbell Flyes', 'Isolation exercise for chest.'),
(13, 'Chest Dips', 'Bodyweight exercise focusing on chest and triceps.'),
(14, 'Crunches', 'Targets abdominal muscles for core strength.'),
(15, 'Planks', 'Core stabilization exercise.'),
(16, 'Russian Twists', 'Strengthens obliques and core.'),
(17, 'Leg Raises', 'Targets lower abdominal muscles.'),
(18, 'Squats', 'Full body exercise focusing on legs and glutes.'),
(19, 'Lunges', 'Targets quadriceps, hamstrings, and glutes.'),
(20, 'Deadlifts', 'Compound exercise for lower body and back.'),
(21, 'Leg Press', 'Strengthens leg muscles with less stress on back.'),
(22, 'Bicep Curls', 'Isolation exercise for biceps.'),
(23, 'Tricep Dips', 'Strengthens triceps and shoulders.'),
(24, 'Hammer Curls', 'Variation of bicep curls targeting brachialis.'),
(25, 'Tricep Extensions', 'Targets triceps muscles.'),
(26, 'Jumping Jacks', 'Cardio exercise engaging multiple muscle groups.'),
(27, 'Burpees', 'Full body exercise combining squat, push-up, and jump.'),
(28, 'High Knees', 'Cardio exercise for lower body and core.'),
(29, 'Mountain Climbers', 'Dynamic exercise for cardiovascular fitness.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
