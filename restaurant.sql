-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2016 at 07:42 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `add_date` varchar(100) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `name`, `email`, `password`, `add_date`, `status`) VALUES
(1, 'admin', 'Jannatul Ferdous', 'jannat.cse@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '2016-01-04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee_list`
--

CREATE TABLE IF NOT EXISTS `employee_list` (
`employee_id` int(11) NOT NULL,
  `employee_name` varchar(50) NOT NULL,
  `emp_username` varchar(30) NOT NULL,
  `emp_email` varchar(100) NOT NULL,
  `emp_address` text NOT NULL,
  `emp_mobile` varchar(14) NOT NULL,
  `emp_birthday` varchar(50) NOT NULL,
  `emp_sex` varchar(8) NOT NULL,
  `emp_designation` varchar(50) NOT NULL,
  `emp_salary` float NOT NULL,
  `emp_jdate` varchar(100) NOT NULL,
  `emp_duty_hour` varchar(100) NOT NULL,
  `emp_off_day` varchar(50) NOT NULL,
  `emp_password` varchar(50) NOT NULL,
  `emp_pic` varchar(100) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `emp_add_date` varchar(100) NOT NULL,
  `emp_status` int(2) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `employee_list`
--

INSERT INTO `employee_list` (`employee_id`, `employee_name`, `emp_username`, `emp_email`, `emp_address`, `emp_mobile`, `emp_birthday`, `emp_sex`, `emp_designation`, `emp_salary`, `emp_jdate`, `emp_duty_hour`, `emp_off_day`, `emp_password`, `emp_pic`, `admin_id`, `restaurant_id`, `emp_add_date`, `emp_status`) VALUES
(4, 'Kaniz Fatema', 'fatema007', 'fatema@gmail.com', 'Kushtia', '01712426034', '16-06-1992', 'Female', 'Cooker', 25000, '01-04-2016', '9.00AM - 9.00PM', 'Saturday', '81dc9bdb52d04dc20036dbd8313ed055', 'fatema007.jpg', 1, 0, '28-04-2016', 1),
(5, 'Mahamud', 'mahamud007', 'mahamud@gmail.com', 'Dhaka', '01674548465', '08-08-1999', 'Male', 'Waiter', 15000, '23-04-2016', '9.00AM - 9.00PM', 'Saturday', '81dc9bdb52d04dc20036dbd8313ed055', 'mahamud007.jpg', 1, 0, '28-04-2016', 1);

-- --------------------------------------------------------

--
-- Table structure for table `food_category`
--

CREATE TABLE IF NOT EXISTS `food_category` (
`cat_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `food_category`
--

INSERT INTO `food_category` (`cat_id`, `admin_id`, `restaurant_id`, `cat_name`, `date`) VALUES
(2, 1, 0, 'Burgar', '20-04-2016'),
(3, 1, 0, 'Sandwich', '20-04-2016'),
(4, 1, 0, 'Lassi', '20-04-2016'),
(5, 1, 0, 'Coffe', '20-04-2016'),
(6, 1, 0, '    Noodles', '20-04-2016');

-- --------------------------------------------------------

--
-- Table structure for table `food_details`
--

CREATE TABLE IF NOT EXISTS `food_details` (
`food_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `food_image` varchar(255) NOT NULL,
  `food_title` varchar(100) NOT NULL,
  `food_price` float NOT NULL,
  `food_summary` text NOT NULL,
  `add_date` varchar(100) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `food_details`
--

INSERT INTO `food_details` (`food_id`, `admin_id`, `restaurant_id`, `cat_id`, `food_image`, `food_title`, `food_price`, `food_summary`, `add_date`) VALUES
(3, 1, 5, 2, '3.jpg', 'Beef Burgar', 80, '<p>Testy</p>\r\n', '20-04-2016'),
(4, 1, 5, 3, '4.jpg', 'Egg Sandwich', 60, '<p>Making Egg</p>\r\n', '20-04-2016'),
(5, 1, 5, 4, '5.jpg', 'Rosse Lassi', 60, '<p>Making ice</p>\r\n', '20-04-2016'),
(6, 1, 5, 5, '6.jpg', 'Chocklete Coffe', 80, '<p>Very Testy</p>\r\n', '20-04-2016'),
(7, 1, 5, 6, '7.jpg', 'Egg Noudouse', 80, '<p>Making Egg</p>\r\n', '20-04-2016'),
(8, 1, 5, 5, '8.jpg', 'Black Coffe', 60, '<p>Tasty</p>\r\n', '22-04-2016');

-- --------------------------------------------------------

--
-- Table structure for table `member_list`
--

CREATE TABLE IF NOT EXISTS `member_list` (
`member_id` int(11) NOT NULL,
  `member_name` varchar(50) NOT NULL,
  `mem_username` varchar(30) NOT NULL,
  `mem_email` varchar(100) NOT NULL,
  `mem_address` text NOT NULL,
  `mem_mobile` varchar(14) NOT NULL,
  `mem_birthday` varchar(50) NOT NULL,
  `mem_sex` varchar(8) NOT NULL,
  `mem_password` varchar(50) NOT NULL,
  `mem_pic` varchar(100) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `mem_add_date` varchar(100) NOT NULL,
  `mem_status` int(2) NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `member_list`
--

INSERT INTO `member_list` (`member_id`, `member_name`, `mem_username`, `mem_email`, `mem_address`, `mem_mobile`, `mem_birthday`, `mem_sex`, `mem_password`, `mem_pic`, `admin_id`, `restaurant_id`, `mem_add_date`, `mem_status`, `code`) VALUES
(7, 'Zannatul Ferdus', 'jannat1', 'ferdousijannat2@gmail.com', 'Khagan', '01674548466', '19-12-1992', 'Female', '81dc9bdb52d04dc20036dbd8313ed055', 'jannat1.jpg', 0, 0, '28-04-2016', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
`message_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `sender_name` varchar(50) NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `recipent_email` varchar(255) NOT NULL,
  `sender_subject` varchar(255) NOT NULL,
  `sender_message` text NOT NULL,
  `send_date` varchar(100) NOT NULL,
  `send_status` int(2) NOT NULL,
  `recipent_status` int(2) NOT NULL,
  `active_status` int(2) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `admin_id`, `restaurant_id`, `employee_id`, `member_id`, `sender_name`, `sender_email`, `recipent_email`, `sender_subject`, `sender_message`, `send_date`, `send_status`, `recipent_status`, `active_status`) VALUES
(1, 1, 0, 0, 0, 'Jannat', 'jannat.cse@gmail.com', 'samin007@gmail.com', 'Check', 'Check Order List', '17-05-2016', 1, 1, 0),
(2, 1, 0, 0, 0, 'Jannat', 'jannat.cse@gmail.com', 'fatema@gmail.com', 'Cooking Food', 'Todays Food Items: Make Crickent Fried', '17-05-2016', 1, 1, 0),
(3, 0, 0, 4, 0, 'Fatema', 'fatema@gmail.com', 'jannat.cse@gmail.com', 'Finish Cook', 'I have all ready done my work', '17-05-2016', 1, 1, 1),
(4, 0, 0, 0, 7, 'Jannat', 'ferdousijannat2@gmail.com', 'jannat.cse@gmail.com', 'Checking', ' hellow admin', '12-06-2016', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE IF NOT EXISTS `order_list` (
`order_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `c_mobile` varchar(11) NOT NULL,
  `c_email` varchar(100) NOT NULL,
  `c_address` text NOT NULL,
  `c_account` varchar(16) DEFAULT NULL,
  `user_types` varchar(50) NOT NULL,
  `food_title` varchar(255) NOT NULL,
  `food_id` varchar(100) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `total_quantity` int(16) NOT NULL,
  `food_price` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `payment_types` varchar(50) NOT NULL,
  `account` varchar(16) NOT NULL,
  `send_date` varchar(100) NOT NULL,
  `send_time` varchar(100) NOT NULL,
  `reply_date` varchar(100) NOT NULL,
  `reply_time` varchar(100) NOT NULL,
  `month` varchar(11) NOT NULL,
  `year` int(4) NOT NULL,
  `status` int(2) NOT NULL,
  `confirm_code` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`order_id`, `member_id`, `c_mobile`, `c_email`, `c_address`, `c_account`, `user_types`, `food_title`, `food_id`, `quantity`, `total_quantity`, `food_price`, `total`, `payment_types`, `account`, `send_date`, `send_time`, `reply_date`, `reply_time`, `month`, `year`, `status`, `confirm_code`) VALUES
(115, 0, '01674548464', 'engr.shahinur0077@gmail.com', 'Dhaka', '01674548464', 'Customer', 'Rosse Lassi', '5', '1', 1, '60', 60, 'bkash', '01761607617', '08-06-2016', '02:51:16 PM', '', '', 'Jun', 2016, 0, 0),
(114, 0, '01719022565', 'engr.shahinur0077@gmail.com', 'Savar', '01719022565', 'Customer', 'Chocklete Coffe, Egg Sandwich', '6, 4', '1, 1', 2, '80, 60', 140, 'bkash', '01761607617', '08-06-2016', '02:47:43 PM', '', '', 'Jun', 2016, 0, 0),
(113, 0, '01674548464', 'engr.shahinur0077@gmail.com', 'Dhaka', '01674548464', 'Customer', 'Beef Burgar, Chocklete Coffe, Egg Sandwich', '3, 6, 4', '1, 1, 1', 3, '80, 80, 60', 220, 'bkash', '01761607617', '08-06-2016', '12:07:18 PM', '', '', 'Jun', 2016, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
`payment_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `payment_types` varchar(50) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `admin_id`, `restaurant_id`, `payment_types`, `payment`, `date`) VALUES
(2, 1, 0, 'Direct Pay', 'Cash', '29-04-2016'),
(3, 1, 0, 'bkash', '01761607617', '29-04-2016'),
(4, 1, 0, 'DBBL Mobile Banking', '017616076172', '29-04-2016');

-- --------------------------------------------------------

--
-- Table structure for table `sub_admin`
--

CREATE TABLE IF NOT EXISTS `sub_admin` (
`restaurant_id` int(11) NOT NULL,
  `sub_name` varchar(50) NOT NULL,
  `restaurant_name` varchar(255) NOT NULL,
  `sub_username` varchar(100) NOT NULL,
  `sub_address` text NOT NULL,
  `sub_email` varchar(100) NOT NULL,
  `sub_mobile` int(11) NOT NULL,
  `sub_birthday` varchar(50) NOT NULL,
  `sub_sex` varchar(8) NOT NULL,
  `sub_types` varchar(50) NOT NULL,
  `sub_password` varchar(50) NOT NULL,
  `restaurant_logo` varchar(100) NOT NULL,
  `sub_pic` varchar(100) NOT NULL,
  `sub_sign` varchar(100) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `sub_add_date` varchar(100) NOT NULL,
  `sub_status` int(2) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sub_admin`
--

INSERT INTO `sub_admin` (`restaurant_id`, `sub_name`, `restaurant_name`, `sub_username`, `sub_address`, `sub_email`, `sub_mobile`, `sub_birthday`, `sub_sex`, `sub_types`, `sub_password`, `restaurant_logo`, `sub_pic`, `sub_sign`, `admin_id`, `sub_add_date`, `sub_status`) VALUES
(5, 'Samin Jaman', 'City Restaurant', 'samin0077', 'Dhaka', 'samin007@gmail.com', 1674548464, '19-12-1992', 'Female', 'Manger', '81dc9bdb52d04dc20036dbd8313ed055', 'samin0077.jpg', 'samin0077.jpg', 'samin0077.jpg', 1, '20-04-2016', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `employee_list`
--
ALTER TABLE `employee_list`
 ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `food_category`
--
ALTER TABLE `food_category`
 ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `food_details`
--
ALTER TABLE `food_details`
 ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `member_list`
--
ALTER TABLE `member_list`
 ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
 ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
 ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `sub_admin`
--
ALTER TABLE `sub_admin`
 ADD PRIMARY KEY (`restaurant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `employee_list`
--
ALTER TABLE `employee_list`
MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `food_category`
--
ALTER TABLE `food_category`
MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `food_details`
--
ALTER TABLE `food_details`
MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `member_list`
--
ALTER TABLE `member_list`
MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sub_admin`
--
ALTER TABLE `sub_admin`
MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
