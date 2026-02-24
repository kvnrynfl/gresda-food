-- Gresda Food & Beverage Database V2 
-- Fully seeded with original developer data, matching ID relations perfectly.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gresda_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` char(36) NOT NULL DEFAULT '',
  `user_id` char(36) NOT NULL DEFAULT '',
  `food_id` char(36) NOT NULL DEFAULT '',
  `qty` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `food_id` (`food_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `id` char(36) NOT NULL DEFAULT '',
  `order_id` varchar(100) NOT NULL,
  `user_id` char(36) NOT NULL DEFAULT '',
  `tgl_order` timestamp NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'Cart',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`id`, `order_id`, `user_id`, `tgl_order`, `status`, `total`, `created_at`) VALUES
('c4d89855-e840-4bc5-bfb2-51054adf131f', 'ORD-16VO00TGHMNK', '1bf85fa8-7c6e-46f5-8e1f-ed186ca8f64b', '2021-10-11 13:54:52', 'Finished', 330000.00, '2021-10-11 13:54:52'),
('30bb2c37-a863-41e6-8cc4-272506f88be3', 'ORD-16VDICBP7HPHK', 'b2afcaeb-b6d2-4097-bb45-53007d358366', '2021-10-11 14:32:06', 'Finished', 170000.00, '2021-10-11 14:32:06'),
('3655f9cc-3fd4-4be1-9078-c9f51b05fd41', 'ORD-167DSCRBUDJUO', '2b8a42fb-3dc5-42c0-afb9-9ba56bd9bc99', '2021-10-11 14:40:32', 'Finished', 80000.00, '2021-10-11 14:40:32'),
('d6eb8d5d-d6d1-47b7-a637-16fe987ed232', 'ORD-16IRGHP0NI8EA', 'd817e654-c978-4cd0-a878-6872888472b3', '2021-10-11 15:15:53', 'Finished', 75000.00, '2021-10-11 15:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` char(36) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `active` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `name`, `category`, `active`) VALUES
('e608880c-c129-46d9-bcad-99ecb038f84c', 'Prime Steak', 'prime-steak', 'Yes'),
('f0931810-9e36-4ba0-927d-8d260f6e90ea', 'Speciality Steak', 'speciality-steak', 'Yes'),
('a4c5e2cd-7640-4b18-9cf5-5e9bcb0c1b47', 'Western Delight', 'western-delight', 'Yes'),
('ad6c9de9-4574-448a-aea8-bed1e2991b56', 'Burger', 'burger', 'Yes'),
('e32792ae-cf1e-4043-a8cf-b259a4f7a47a', 'Soup Salad', 'soup-salad', 'Yes'),
('51b2fdaa-a55a-4748-8c31-73c9d4e7f38f', 'Light Meal', 'light-meal', 'Yes'),
('392e3431-2a6d-49f8-9392-b882b8e247f4', 'Dessert', 'dessert', 'Yes'),
('04d0e653-8063-4734-9b0c-a958bb106ed6', 'Drink', 'drink', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_confirmorder`
-- This was historically used for payment proofs
--

CREATE TABLE `tbl_confirmorder` (
  `id` char(36) NOT NULL DEFAULT '',
  `order_id` varchar(100) NOT NULL,
  `user_id` char(36) NOT NULL DEFAULT '',
  `payment` varchar(10) NOT NULL,
  `rekening_name` varchar(25) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tgl_pay` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_confirmorder`
--

INSERT INTO `tbl_confirmorder` (`id`, `order_id`, `user_id`, `payment`, `rekening_name`, `image_name`, `alamat`, `tgl_pay`, `created_at`) VALUES
('f2b17126-434d-49ac-ae44-c0ddd266db6b', 'ORD-16VO00TGHMNK', '1bf85fa8-7c6e-46f5-8e1f-ed186ca8f64b', 'Bank BCA', 'Kevin Reynaufal', '4196.png', 'Komplek baleendah permai blok Z no 5', '2021-10-11', '2021-10-11 13:56:08'),
('5b8f30d4-f278-4c1a-aea9-3f46d4847c85', 'ORD-16VDICBP7HPHK', 'b2afcaeb-b6d2-4097-bb45-53007d358366', 'Bank BNI', 'Irfan Rizky', '3095.png', 'Komplek Baleendah Permai Jalan Padi Endah 5 No 200 RT 03/RW 25', '2021-10-11', '2021-10-11 14:34:22'),
('c405da65-8473-4288-8b4c-2c956438e61e', 'ORD-167DSCRBUDJUO', '2b8a42fb-3dc5-42c0-afb9-9ba56bd9bc99', 'Bank BRI', 'Fahri Arsyah', '6399.png', 'Jl Cibuntu Selatan RT 02 / RW 10', '2021-10-11', '2021-10-11 14:41:51'),
('845b76b9-8a9c-4771-942b-bd321b1c119e', 'ORD-16IRGHP0NI8EA', 'd817e654-c978-4cd0-a878-6872888472b3', 'Dana', 'Naufal Andya', '3038.png', 'JL. Wuluku No 24', '2021-10-11', '2021-10-11 15:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `id` char(36) NOT NULL DEFAULT '',
  `customer_name` varchar(150) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_message` varchar(300) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`id`, `customer_name`, `customer_email`, `customer_message`) VALUES
('a7f6c7f8-07db-42c0-9c0a-d0a7b12c6881', 'Kevin Reynaufal', 'kevinreynaufal2004@gmail.com', 'Hallo... ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `detail_id` char(36) NOT NULL DEFAULT '',
  `order_id` varchar(100) NOT NULL,
  `food_id` char(36) NOT NULL DEFAULT '',
  `qty` int(10) NOT NULL,
  `price_at_time` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`),
  KEY `food_id` (`food_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`detail_id`, `order_id`, `food_id`, `qty`, `price_at_time`) VALUES
('ed52300f-0b3f-4397-afbc-f714ca99d9d1', 'ORD-16VO00TGHMNK', 'c808f4a4-74ee-4e83-8304-df54af4b7f03', 1, 50000.00),
('7496f56a-db7f-45cf-ab9b-39984bb49e0b', 'ORD-16VO00TGHMNK', 'e90996e6-3f36-4c8b-a5c0-ffd4edc6c6e5', 1, 280000.00),
('8f59710c-61b3-4223-b588-df2c1627ccb6', 'ORD-16VDICBP7HPHK', 'dc8a3e72-2c28-4e6e-8538-68ff07a8450b', 1, 110000.00),
('dd05a386-b623-49c3-a596-b27f34c768be', 'ORD-16VDICBP7HPHK', 'b0f0ee6e-7a1f-4b2f-a27b-d8f29f568066', 1, 60000.00),
('abe57da8-d857-4628-8539-0c4741b33538', 'ORD-167DSCRBUDJUO', '9bd8a94e-c6c6-44c1-8045-60ff48af7cfa', 1, 35000.00),
('5ead81fd-9f85-4b08-aedc-746c22b4cef1', 'ORD-167DSCRBUDJUO', '6e51deab-fa61-4446-bfdd-9fed4e8ba083', 1, 45000.00),
('831603d4-89c8-4fb1-b8ca-c8f22a665d68', 'ORD-16IRGHP0NI8EA', '48f96f74-8ce0-4b37-8c7f-63d70c5c149e', 1, 35000.00),
('6783ed3c-b6b9-4f87-aee8-e14e344bc74a', 'ORD-16IRGHP0NI8EA', '74488fc9-e858-48ba-89a1-d99c0c359ae8', 1, 40000.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_food`
--

CREATE TABLE `tbl_food` (
  `food_id` char(36) NOT NULL DEFAULT '',
  `category` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `active` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_food`
--

INSERT INTO `tbl_food` (`food_id`, `category`, `name`, `price`, `description`, `image_name`, `active`) VALUES
('b2527a9c-7407-411d-93d6-3ce36cd41ef2', 'prime-steak', 'Aussie Lamb Chop', 30000.00, 'Grill Imported Australian Lamb Chop Served With Butter On Top, Rosemary, Lemon Wedges, Choices Of Potato, Vegetable, And Sauce. 250GR', '9362.jpg', 'Yes'),
('9bd8a94e-c6c6-44c1-8045-60ff48af7cfa', 'prime-steak', 'Norwegian Salmon Steak', 35000.00, 'Grilled Imported Norwegian Salmon Served With Butter On Top, Rosemary, Lemon Wedges, Choices Of Potato, Vegetable And White Mushroom Sauce. 200GR', '1782.jpg', 'Yes'),
('48f96f74-8ce0-4b37-8c7f-63d70c5c149e', 'prime-steak', 'US Short Ribs BBQ', 35000.00, 'Grilled imported US short ribs glazed with our homemade sauce served with choices of potato, vegetable, and Korean barbeque sauce. 300GR ', '4161.jpg', 'Yes'),
('ee25bf38-3b0e-4b30-bdb8-987bb5a5e18a', 'prime-steak', 'Sirloin Meltique Wagyu', 40000.00, 'Grilled sirloin meltique wagyu served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR', '7260.jpg', 'Yes'),
('74488fc9-e858-48ba-89a1-d99c0c359ae8', 'prime-steak', 'Rib Eye Meltique Wagyu', 40000.00, 'Grilled rib eye meltique wagyu served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR', '480.jpg', 'Yes'),
('d48a3b8f-ed7e-4e71-aed6-777d9def9bb9', 'prime-steak', 'Tenderloin Meltique Wagyu ', 45000.00, 'Grilled tenderloin meltique wagyu served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR', '1733.jpg', 'Yes'),
('29d69e58-beb9-4ccf-b6db-5412295d3b2b', 'prime-steak', 'US Black Angus Sirloin Steak', 45000.00, 'Grilled imported US black angus sirloin served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR', '3724.jpg', 'Yes'),
('668da3b7-8cb5-481f-9912-d5d60102317b', 'prime-steak', 'US Black Angus Rib Eye Steak', 50000.00, 'Grilled imported US black angus rib eye served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR', '3616.jpg', 'Yes'),
('c808f4a4-74ee-4e83-8304-df54af4b7f03', 'prime-steak', 'US Black Angus Tenderloin Steak', 50000.00, 'Grilled imported US black angus tenderloin served with butter on top, rosemary, lemon wedges, choices of potato, vegetable and sauce. 200GR', '6350.jpg', 'Yes'),
('0314f630-d5c5-4188-ad66-106c19134993', 'speciality-steak', 'Aussie Tenderloin Grain Fed', 45000.00, 'Grilled imported Aussie tenderloin served with choices of potato, vegetable and sauce. 250GR', '3761.jpg', 'Yes'),
('6e51deab-fa61-4446-bfdd-9fed4e8ba083', 'speciality-steak', 'Garlic Roasted Chicken', 45000.00, 'It’s cut in a half 350gr garlic roasted chicken with our signature recipe served with choices of potato, vegetable and sauce.', '7372.jpg', 'Yes'),
('b0f0ee6e-7a1f-4b2f-a27b-d8f29f568066', 'speciality-steak', 'Aussie Sirloin Cheese Steak', 60000.00, 'Grilled imported Aussie sirloin 150gr topped with mushroom, smoked beef, mozzarella served with choices of potato, vegetable and sauce.', '7645.jpg', 'Yes'),
('7ff30549-270f-401c-a056-b0c5dd9565e1', 'speciality-steak', 'American Mix Grill', 65000.00, 'Grilled imported Aussie sirloin, boneless chicken breast, beef bratwurst, lamb chop served with choices of potato, vegetable and sauce.', '586.jpg', 'Yes'),
('3938b501-926e-4a81-98ba-2cb25e8897dc', 'speciality-steak', 'Seafood Platter', 85000.00, 'Grilled lobster, imported Norwegian salmon and dory served with choices of potato, vegetable and white mushroom sauce.', '900.jpg', 'Yes'),
('c8894a06-aa70-4371-b618-a863dae7a0dd', 'speciality-steak', 'Surf & Turf', 125000.00, 'Grilled imported Aussie tenderloin 250gr and lobster 300gr served with choices of potato, vegetable and white mushroom sauce.', '1794.jpg', 'Yes'),
('dc8a3e72-2c28-4e6e-8538-68ff07a8450b', 'speciality-steak', 'Garlic Butter Lobster', 110000.00, '600gr aromatic garlic butter lobster served with choices of potato, vegetable and combine with white mushroom sauce.', '4468.jpg', 'Yes'),
('2644dbff-e402-4f30-883c-5996bac15586', 'speciality-steak', 'Family BBQ / For 4 Person', 180000.00, '2 Slices Aussie Sirloin Steak, 2 pcs Dory Crispy, 4 Slices Grilled Chicken, 4 pcs Beef Bratwurst, served with 4 kind of sauce (Mushroom, Blackpepper, Barbeque, White Mushroom Sauce) Choices of Potato (French Fries / Wedges Potato), Choices of Vegetable (Balsamic Salad / Mix Vegetable) and 4 Iced Lemon Tea.', '1097.jpg', 'Yes'),
('e90996e6-3f36-4c8b-a5c0-ffd4edc6c6e5', 'speciality-steak', 'Meat Lovers Platter / For 6 Person', 280000.00, '2 Slices Aussie Tenderloin Steak, 2 Slices Aussie Sirloin Steak, 4 Slices Aussie Patty Steak, 4 pcs Beef Bratwurst served with 3 Kind of sauce (Blackpepper, Mushroom, Barbeque), Choices of Potato (French Fries / Wedges Potato) Choices of Vegetable (Balsamic Salad / Mix Vegetable) and 6 Iced Lemon Tea.', '4640.jpg', 'Yes'),
('28ef5a23-7918-4b63-a5d8-3e733fee4724', 'western-delight', 'Beef Pizzaiola', 40000.00, 'Breaded tenderloin topping mozarella cheese, caramelized onion and smoked beef, served with choices of potato, vegetable and sauce .', '7290.jpg', 'Yes'),
('a50f2b5d-564a-4e3f-8f4d-c4878ed975c5', 'western-delight', 'Beef Cordon Bleu', 40000.00, 'Breaded tenderloin filling with mozzarella cheese and smoked beef served with choices of potato, vegetable and sauce.', '913.jpg', 'Yes'),
('b3314ff5-f6be-4d1a-8641-229939549355', 'western-delight', 'Beef Schnitzel', 40000.00, 'Breaded tenderloin, sunny side up, served with choices of potato, vegetable and sauce.', '8513.jpg', 'Yes'),
('f6b9d2e8-e581-4aaf-b13f-00a3bcd0360e', 'western-delight', 'American Fish & Chip', 50000.00, 'Batter fillet dory crispy topped with mozzarella cheese served with choices of potato, vegetable and tartar sauce.', '8540.jpg', 'Yes'),
('3831cba4-6843-4bde-82c5-0ea8bf6bb93b', 'western-delight', 'John Dory', 40000.00, 'Breaded fillet dory 150 gr, served with choices of potato, vegetable and tartar sauce .', '3717.jpg', 'Yes'),
('fb76b51e-a79e-4280-b0ee-d3a1a7b97514', 'western-delight', 'Chicken Pizzaiola', 37000.00, 'Breaded boneless chicken leg topped with mozzarella cheese, caramelized onion and smoked beef served with choices of potato, vegetable and sauce.', '9348.jpg', 'Yes'),
('eaeab763-0c5f-4049-ba6c-311b789f2cfd', 'western-delight', 'Chicken Cordon Bleu', 35000.00, 'Breaded boneless chicken breast filling with mozzarella cheese and smoked beef, served with choices of potato, vegetable and sauce.', '2497.jpg', 'Yes'),
('f9441127-234c-45aa-a090-949043e2ab2d', 'western-delight', 'Fish Me To The Moon', 35000.00, 'Breaded fillet dory filling with mozzarella cheese and smoked beef, served with choices of potato, vegetable and sauce.', '9026.jpg', 'Yes'),
('58f0ecaf-a7be-42b8-b803-2c4e135c8aff', 'western-delight', 'Chicken Maryland', 35000.00, 'Breaded boneless chicken leg served with choices of potato, vegetable and sauce.', '8674.jpg', 'Yes'),
('0564c435-6030-4578-a454-a44cf25b7a8a', 'burger', 'Teriyaki Burger', 25000.00, 'Burger bun, chicken teriyaki, vegetable, mayonnaise and caramelized onion served with choices of potato.', '2699.jpg', 'Yes'),
('bff6a2c9-36b5-4efa-997b-d449ad876dd5', 'burger', 'Grill Chicken Burger', 25000.00, 'Brown burger bun, grilled chicken, American cheese, vegetables, caramelized onion, barbeque sauce, and mayonnaise, served with choices of potato .', '2672.jpg', 'Yes'),
('0318a245-3f92-46d0-ba33-a454883c753f', 'burger', 'Ohio Fish Burger', 25000.00, 'Burger bun, fillet dory crispy, American cheese, vegetable, caramelized onion, tartar sauce served with choices of potato.', '3361.jpg', 'Yes'),
('cf21e4b3-1f1a-4a4d-bc3a-91661e5b9993', 'burger', 'Old Fashioned Beef Burger', 30000.00, 'Burger bun, double beef patty, triple American cheese, vegetable, caramelized onion, barbeque sauce and mayonnaise, served with choices of potato.', '1985.jpg', 'Yes'),
('830a2929-5809-453d-ab59-b1c0082eb4e8', 'burger', 'Sloppy Joe Burger', 30000.00, 'Burger bun, double beef patty, American cheese, vegetable, caramelized onion, sloppy joe sauce and mayonnaise served with choices of potato.', '238.jpg', 'Yes'),
('5bc69968-d0d0-44ff-a7e1-0a8ebce6780e', 'burger', 'American Burger', 30000.00, 'Burger bun, double beef patty, double American cheese, smoked beef, sunny side up, vegetable, barbeque sauce and mayonnaise served with choices of potato.', '5887.jpg', 'Yes'),
('917215df-c523-4f38-9506-c344fc519880', 'soup-salad', 'Chicken Cream Soup', 15000.00, 'Cream soup with chicken and corn kernel served with garlic bread.', '2146.jpg', 'Yes'),
('fb69b431-c15b-418a-835d-f03dc32c765e', 'soup-salad', 'Smoked Beef Cream Soup', 15000.00, 'Cream soup with smoked beef and corn kernel served with garlic bread.', '5558.jpg', 'Yes'),
('d06d84dd-cf48-4a40-bcd8-7c4f86b209c0', 'soup-salad', 'Organic Garden Salad', 15000.00, 'Organic mix lettuce, dressing with balsamic, topped with smoke beef sliced, parmesan cheese served with garlic bread', '1763.jpg', 'Yes'),
('de865092-0b79-4fb1-97bd-a3d26fb1cccd', 'soup-salad', 'Caesar Chicken Salad', 20000.00, 'Organic romaine lettuce, grilled chicken, boiled egg, caesar dressing, parmesan cheese served with garlic bread.', '4568.jpg', 'Yes'),
('c7e79187-22de-42a6-98b3-2b8b162e02ad', 'soup-salad', 'US Prawn Salad', 25000.00, 'Organic lettuce, dressing with balsamic topped with grilled US prawn, parmesan cheese served with garlic bread.', '6562.jpg', 'Yes'),
('fbae13af-1ce3-4d5b-80b6-d7543182b4b2', 'soup-salad', 'Beef Salad', 25000.00, 'Organic lettuce, dressing with balsamic topped wih sauted beef, and parmesan cheese and served with garlic bread.', '7584.jpg', 'Yes'),
('f773f017-bf7b-41eb-992c-d40a17a44905', 'light-meal', 'French Fries', 15000.00, 'Fried potato straight cut 200gr.', '2960.jpg', 'Yes'),
('51e106bf-fc9a-4adf-b93e-67882c1f325f', 'light-meal', 'Chili Cheese Fries', 20000.00, 'French fries topped with bolognese sauce and American cheese.', '4478.jpg', 'Yes'),
('a8c1c729-a50e-47ee-83f7-802e5fc2db4e', 'light-meal', 'Chili Cheese Nachos', 20000.00, 'Corn tortilla topped with bolognese sauce and American cheese.', '2860.jpg', 'Yes'),
('b877ddee-c542-4851-b9d6-fa8036bf9213', 'light-meal', 'Fish & Chips', 23000.00, 'Batter fillet dory crispy served with french fries, lemon wedges and tartar sauce.', '971.jpg', 'Yes'),
('b7c4105e-9c76-48cb-aea1-1dd6a772d4dd', 'light-meal', 'Hot Wings', 23000.00, 'Fried chicken wings served with french fries and Korean barbeque sauce.', '430.jpg', 'Yes'),
('98517f40-6853-49d7-aa29-30adfee76bc8', 'light-meal', 'Sausage & Fries', 25000.00, 'Beef bratwurst served with french fries and barbeque sauce.', '271.jpg', 'Yes'),
('816c0617-1a6f-42e6-85ae-a166d0c5cbbe', 'dessert', 'Banana Split', 15000.00, '3 scoops ice cream, peach, cavendish topped with whipped cream and granola.', '2504.jpg', 'Yes'),
('65d4d1f5-7650-4e3a-b869-c0a17a7b4b30', 'dessert', 'Brownies Cheezie Sundae', 15000.00, 'Our homemade cheese brownies served with vanilla ice cream.', '1877.jpg', 'Yes'),
('e2dba56d-f311-4cb8-a909-235ad9bcb858', 'dessert', 'Fruity Granola', 25000.00, 'Granola, peach, strawberry, cavendish, dragon fruit served with honey and fresh milk.', '4567.jpg', 'Yes'),
('d9b80204-a9a0-42d9-8f89-4d4b27e9b3cc', 'drink', 'Midnight B2uty', 13000.00, 'Korean squash rasa Lychee & Grape', '2014.jpg', 'Yes'),
('7f3b5c6f-3625-49d7-9703-834661b854f3', 'drink', 'Exotic Kiss', 13000.00, 'Korean squash rasa Lime', '3956.jpg', 'Yes'),
('c7d57c7c-3def-407f-ad59-86e79f8414d2', 'drink', 'Blackjack Fire', 13000.00, 'Korean squash rasa Bubblegum', '3556.jpg', 'Yes'),
('42d134a4-df63-4cf3-bfc7-e5129264914c', 'drink', 'Inspirit Destiny', 13000.00, 'Korean squash rasa Huneydew & Mango', '5834.jpg', 'Yes'),
('7204b608-6904-4467-b4d4-d5aaffc2d40c', 'drink', 'Boice Intuition', 13000.00, 'Korean squash rasa Vanila', '514.jpg', 'Yes'),
('7e52d786-53d7-4f7e-ba06-5cab8bf15ce7', 'drink', 'Bulletproof Army', 13000.00, 'Korean squash rasa Honeydew & Strawberry', '6700.jpg', 'Yes'),
('beca7c23-4910-490a-986b-d00c89a6fe9c', 'drink', 'Electric f(x)', 13000.00, 'Korean squash rasa Blueberry & Lime', '4250.jpg', 'Yes'),
('97009a9f-c7dc-4ba4-8be0-edc7bf5c645b', 'drink', 'Sone Fantasy', 13000.00, 'Korean squash rasa Strawberry', '6912.jpg', 'Yes'),
('58d9fc75-1869-4321-8d20-b35b357eb7ca', 'drink', 'I Got7 Love', 13000.00, 'Korean squash rasa Lemon & Strawberry', '8590.jpg', 'Yes'),
('a0202a01-ec21-415b-8b1f-8a35027cf5c7', 'drink', 'Hottest Legend', 13000.00, 'Korean squash rasa Blue Pineapple', '7951.jpg', 'Yes'),
('bbab1a38-254d-4f70-99da-6fbc61a02e94', 'drink', 'Elf Miracle', 13000.00, 'Korean squash rasa Blueberry', '6208.jpg', 'Yes'),
('1c1cbc0f-b67b-424c-834a-6518b0b5684f', 'drink', 'Shawol Oxygen', 13000.00, 'Korean squash rasa Lychee', '3693.jpg', 'Yes'),
('7bc73e94-88ab-43c5-b2a9-78b128093f64', 'drink', 'Daisy Twinkle', 13000.00, 'Korean squash rasa Respberry', '1762.jpg', 'Yes'),
('d0576d58-b0ce-48ef-a47c-0560105b29dd', 'drink', 'Lively Vip', 13000.00, 'Korean squash rasa Lemon', '8277.jpg', 'Yes'),
('623897e3-e904-4ba6-8806-d8d9967ae2b9', 'drink', 'Super Starlight', 13000.00, 'Korean squash rasa Grape & Blue Curacao', '1216.jpg', 'Yes'),
('9e7bd3fc-7fc0-4ce2-af19-f3213af8ff26', 'drink', 'Blink on Fire', 13000.00, 'Korean squash rasa Strawberry Mocca', '8704.jpg', 'Yes'),
('fd122162-2c55-4381-b28b-4967bc8a6cd4', 'drink', 'Oh My Carat', 13000.00, 'Korean squash rasa Cotton Candy', '6224.jpg', 'Yes'),
('9626dfbe-88b5-44d6-bbb3-2bfed917bd01', 'drink', 'Once Likey', 13000.00, 'Korean squash rasa Strawberry Lime', '9211.jpg', 'Yes'),
('f916ce33-0767-48a2-960e-02ccdcf0c428', 'drink', 'Baby Aroha', 13000.00, 'Korean squash rasa Respberry Lime', '1092.jpg', 'Yes'),
('73408225-9ca4-4f9c-8929-0bcb829c03e2', 'drink', 'Summer Buddy', 13000.00, 'Korean squash rasa Rose Berry', '9538.jpg', 'Yes'),
('e456bede-7480-4efc-84a2-a157ab80d918', 'drink', 'Wannable Boomerang', 13000.00, 'Korean squash rasa Lemon & Mango', '2471.jpg', 'Yes'),
('f48bc1b4-e93a-4017-acc8-414bebb0139f', 'drink', 'Limitless NCTzen', 13000.00, 'Korean squash rasa Honeydew & Pineapple', '9912.jpg', 'Yes'),
('ff3e3a99-5ef3-4be5-967b-a4062ee41f73', 'drink', 'Ikonic Bling', 13000.00, 'Korean squash rasa Fruit Punch', '2309.jpg', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `id` char(36) NOT NULL DEFAULT '',
  `metode` varchar(25) NOT NULL,
  `rekening_number` varchar(25) NOT NULL,
  `image_name` text NOT NULL,
  `an` varchar(25) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`id`, `metode`, `rekening_number`, `image_name`, `an`) VALUES
('d5e42f99-b255-4e27-a0f0-6d46dcf6443c', 'Bank BCA', '12345678', 'bca.png', 'Gresda Food'),
('9b90299b-9490-4170-8d64-1e803d453d00', 'Bank BNI', '23456781', 'bni.png', 'Gresda Food'),
('192f2844-98c3-4793-9f72-bbfc234f73a7', 'Bank BRI', '34567812', 'bri.png', 'Gresda Food'),
('44737210-d2b2-47f5-8d06-52d38e850f64', 'Dana', '45678123', 'dana.png', 'Gresda Food'),
('735e367c-cd1b-4884-862d-51519cdeae04', 'Gopay', '56781234', 'gopay.png', 'Gresda Food'),
('81e8a2f7-eb7a-41f4-acd3-f8f4a5e2d685', 'ShopeePay', '67812345', 'shopeepay.png', 'Gresda Food');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_review`
--

CREATE TABLE `tbl_review` (
  `id` char(36) NOT NULL DEFAULT '',
  `order_id` varchar(100) NOT NULL,
  `user_id` char(36) NOT NULL DEFAULT '',
  `rating` decimal(10,1) NOT NULL,
  `message` varchar(280) NOT NULL,
  `tgl_review` date DEFAULT NULL,
  `active` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_review`
--

INSERT INTO `tbl_review` (`id`, `order_id`, `user_id`, `rating`, `message`, `tgl_review`, `active`) VALUES
('61cbcc7c-1f2e-4b95-8fa8-4c6af0f079dd', 'ORD-16VO00TGHMNK', '1bf85fa8-7c6e-46f5-8e1f-ed186ca8f64b', 5.0, 'Waktu datang kesini udah langsung di sambut pelayan yang ramah, trus hidangan makananya juga enak, ditambah suasana dan pemandangan yang indah, Serasa makan di restoran mahal...', '2021-10-11', 'Yes'),
('fac54d46-3549-4efb-8668-9ccbfebe91ed', 'ORD-16VDICBP7HPHK', 'b2afcaeb-b6d2-4097-bb45-53007d358366', 4.5, 'Pertama diajakin sama pacar kesini kirain menu nya bakal mahal karena vibes tempatnya yang classy banget, ehh ternyata menu nya murah murah dan enak. Pokoknya recomended banget inimah,', '2021-10-11', 'Yes'),
('d0cf5abd-961a-4d30-a6b3-8a2664e830ab', 'ORD-167DSCRBUDJUO', '2b8a42fb-3dc5-42c0-afb9-9ba56bd9bc99', 4.5, 'Awalnya saya ragu sih karena ini rumah makan yang bisa di bilang high, setelah saya dan mantan saya melihat menu ternyata harganya sangat murah sekali dan makanan nya pun enak, akhirnya restoran ini adalah tempat terakhir saya dan mantan saya berjalan berdua, ', '2021-10-11', 'Yes'),
('1d98e45c-6ae7-4bc3-ac0d-be7fa1a5361a', 'ORD-16IRGHP0NI8EA', 'd817e654-c978-4cd0-a878-6872888472b3', 3.5, 'Pelayanannya cukup cepat tidak membuat kita menunggu terlalu lama, dan untuk makanan disini cukup enak hanya saja kurang banyak karena saya anak kost :)', '2021-10-11', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
-- (Merged admin and users table with role concept)
--

CREATE TABLE `tbl_users` (
  `id` char(36) NOT NULL DEFAULT '',
  `full_name` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img_user` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `full_name`, `username`, `email`, `password`, `img_user`, `role`) VALUES
('c6bfd833-8167-44f2-916a-d9f24590099b', 'Administrator', 'superadmin', 'superadmin@gresdafood.com', '$2a$12$rgvc/gwskWyjbAzfuVWBG.Y.y/mJ/dpkAoW19/9YCEvS/QSjZ/Kiu', '1731.jpg', 'admin'),
('1bf85fa8-7c6e-46f5-8e1f-ed186ca8f64b', 'Kevin Reynaufal', 'Kevin Reynaufal', 'kevinreynaufal2004@gmail.com', '$2a$12$ZCul5FGz74xNekXa/VEJPuE63RNVUryJi9BRvglpGYgHTnTnZkAG.', '1731.jpg', 'customer'),
('b2afcaeb-b6d2-4097-bb45-53007d358366', 'Irfan Rizqy', 'Irfan Rizqy ', 'irfanrizqy123@gmail.com', '$2a$12$ZCul5FGz74xNekXa/VEJPuE63RNVUryJi9BRvglpGYgHTnTnZkAG.', '1759.jpg', 'customer'),
('2b8a42fb-3dc5-42c0-afb9-9ba56bd9bc99', 'Fahri Arsyah', 'Fahri Arsyah', 'fahriarsyah123@gmail.com', '$2a$12$ZCul5FGz74xNekXa/VEJPuE63RNVUryJi9BRvglpGYgHTnTnZkAG.', '9622.jpg', 'customer'),
('d817e654-c978-4cd0-a878-6872888472b3', 'Naufal Andya', 'Naufal Andya', 'naufalandya123@gmail.com', '$2a$12$ZCul5FGz74xNekXa/VEJPuE63RNVUryJi9BRvglpGYgHTnTnZkAG.', '6078.jpg', 'customer');

COMMIT;

DELIMITER $$
CREATE TRIGGER before_insert_users BEFORE INSERT ON tbl_users FOR EACH ROW BEGIN IF NEW.id = '' THEN SET NEW.id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_category BEFORE INSERT ON tbl_category FOR EACH ROW BEGIN IF NEW.id = '' THEN SET NEW.id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_food BEFORE INSERT ON tbl_food FOR EACH ROW BEGIN IF NEW.food_id = '' THEN SET NEW.food_id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_cart BEFORE INSERT ON tbl_cart FOR EACH ROW BEGIN IF NEW.id = '' THEN SET NEW.id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_orders BEFORE INSERT ON tbl_orders FOR EACH ROW BEGIN IF NEW.id = '' THEN SET NEW.id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_confirmorder BEFORE INSERT ON tbl_confirmorder FOR EACH ROW BEGIN IF NEW.id = '' THEN SET NEW.id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_contact BEFORE INSERT ON tbl_contact FOR EACH ROW BEGIN IF NEW.id = '' THEN SET NEW.id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_payment BEFORE INSERT ON tbl_payment FOR EACH ROW BEGIN IF NEW.id = '' THEN SET NEW.id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_review BEFORE INSERT ON tbl_review FOR EACH ROW BEGIN IF NEW.id = '' THEN SET NEW.id = UUID(); END IF; END$$
CREATE TRIGGER before_insert_order_details BEFORE INSERT ON tbl_order_details FOR EACH ROW BEGIN IF NEW.detail_id = '' THEN SET NEW.detail_id = UUID(); END IF; END$$
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
