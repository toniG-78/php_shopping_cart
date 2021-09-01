# Shopping_cart

Shopping Cart with Php and MySqli Database.

✨Before you execute this project run a local server environment like MAMP.

✨Now create the database:

```sql
CREATE DATABASE yourdatabasename;
```

✨Now create two tables:

```sql
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
);
```

✨ Now insert some values in the database:

```sql
INSERT INTO `categories` VALUES(1, 'Toys');
INSERT INTO `categories` VALUES(2, 'Electronics');
INSERT INTO `categories` VALUES(3, 'Clothing');

INSERT INTO `products` VALUES(1, 1, 'Beach Toys', 'Beach toys description here.', 8.99, 'product_beachtoys.jpg');
INSERT INTO `products` VALUES(2, 1, 'Stuffed Bear', 'Stuffed bear description here.', 15.99, 'product_bear.jpg');
INSERT INTO `products` VALUES(3, 2, 'Computer Monitor', 'Computer monitor description here.', 299.99, 'product_computermonitor.jpg');
INSERT INTO `products` VALUES(4, 1, 'Stuffed Hippo', 'Stuffed Hippo description.', 13, 'product_hippo.jpg');
INSERT INTO `products` VALUES(5, 1, 'Stuffed Reindeer', 'Reindeer description here.', 14.49, 'product_reindeer.jpg');
INSERT INTO `products` VALUES(6, 2, 'Headphones', 'Headphones description here', 19.99, 'product_headphones.jpg');
```

✨ Now go to "init.php" and update your database variables:

```php
// connect to db
$server = 'localhost';
$user = 'root';
$password = 'root';
$db = 'php_shoppingcart';
$Database = new mysqli($server, $user, $password, $db);
```

👍👍👍
