# Test description
## 1 Cart.xml
There is an xml file (cart.xml) with the following content:
```
<?xml version="1.0" encoding="UTF-8"?>
<cart>
<item>
	<sku>1111</sku>
	<qty>3</qty>
</item>
<item>
	<sku>2222</sku>
	<qty>1</qty>
</item>
<item>
	<sku>3333</sku>
	<qty>44</qty>
</item>
</cart>
```
It is necessary that:

1 - Cart.xml was created if it doesn't exist.

2 - When executing the command for adding a product “add [SKU] [QTY]” of the php file (example: php index.php add 1111 2), information about the article of the product and its quantity was written to the xml file (if there is a product, then increase the quantity, if there is no product, then add).

3 - When executing the “remove [SKU] [QTY]” product removal command, the information on product removal was updated (similar to 2). If the quantity of products <= 0, then you need to delete the corresponding entry in the XML.

4 - The script can work in console or via POST requests

see folder 1

## 2 First character to uppercase
Write the command in one line to convert the first character to uppercase. Example москва should be Москва

see file [3.php](https://github.com/mar4ehk0/test/blob/master/1/3.php)

## 3 Code review
The function of searching users by email has been given. Please describe what potential problems you see with this function.

see file [4.php](https://github.com/mar4ehk0/test/blob/master/1/4.php)

## 4 Functional programming

Please write an implementation of the **calc** function for the code below

```
$sum = function($a, $b)  { return $a + $b; };
calc(5)(3)(2)($sum);    // 10
calc(1)(2)($sum);       // 3
calc(2)(3)('pow');      // 8
```

see file [6.php](https://github.com/mar4ehk0/test/blob/master/1/6.php)

## 5 Pack user data

Suggest a way to package the following user data with the most compact result (binary result allowed):
```
$isAdmin = false;
$isModerator = true;
$isApproved = false;
$gender = 1; // possible values: 0, 1, 2
$showAdultContent = false;
```
see file [7.php](https://github.com/mar4ehk0/test/blob/master/1/7.php)
