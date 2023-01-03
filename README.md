# testsieger.de 

php8 Chalanges

---------

# Challenge Nº 1

> **Create a php8 class that gets the total size of a user's repositories**
 
 This class connects to the GitHub public API and retrieves a list of the developer's public repositories, it sums up the individual size to a total size that it then prints to the screen.

* GitHub API endpoint : https://api.github.com/users/{username}/repos
* For the given user **moisesgaspar22** the total amount should be **187242**

---------

# Challenge Nº 2

> **Create a php8 class that scraps testsieger.de homepage for product descriptions**

* Create a php8 class that scraps testsieger.de homepage and gets all the product descriptions from the main section `class="ts-home__featured-products ..."`
* The script should return a array of descriptions where each description is no longer than 50 characters 
* you sould use a pergmatch expression

* Te expected result should be something like 

<code>
array(16) {

  [0] =>
  string(50) "Apple iPad (2021) Quad-HD Auflösung 10,2 Zoll, Wi"

  [1] =>
  string(50) "LG OLED48A29LA 121 cm (48 Zoll) OLED Smart TV (Ult"

  [2] =>
  string(50) "Apple AirPods Pro 1. Generation (2021) mit MagSafe"

  [3] =>
  string(50) "Dyson Supersonic HD07 Haartrockner, Ionen-Technolo"

  [4] =>
  string(50) "Philips HD9860-90 Airfryer XXL Smart Sensing - das"

  [5] =>
  string(50) "Apple Watch Series 7 Smartwatch GPS, 41mm, Alumini"

  [6] =>
  string(50) "Dyson V12 Detect Slim Absolute Handstaubsauger 202"

  [7] =>
  string(50) "Philips Herren Rasierer S5579-50, Reinigungsstatio"

  [8] =>
  string(50) "Joop! Homme Eau de Toilette (EdT) Herrenduft 200 m"

  [9] =>
  string(50) "Tonies &#039;Toniebox Starterset&#039; rot mit Kre"

  [10] =>
  string(39) "Nintendo Switch OLED-Modell 64GB, Weiß"

  [11] =>
  string(50) "Philips Sonicare DiamondClean 9000 Premium HX9914/"

  [12] =>
  string(50) "Issey Miyake L&#039;Eau d&#039;Issey Eau de Toilet"

  [13] =>
  string(48) "Bose SoundLink Flex Bluetooth-Lautsprecher, blau"

  [14] =>
  string(50) "Krups Nespresso XN9031 Vertuo Plus Kaffeekapselmas"

  [15] =>
  string(50) "LEGO Star Wars 75304 &#039;Darth Vader™ Helm&#"
  
}</code>


# MySql 

> **Please explain the diferences** 

~~~~sql 
SELECT DISTINCT p.*, d.*
FROM products p
JOIN descriptions d ON p.EAN = d.EAN
WHERE p.updated_at > NOW() - INTERVAL 3 HOUR
~~~~

~~~~sql
SELECT DISTINCT p.*, d.*
FROM products p
INNER JOIN descriptions d ON p.EAN = d.EAN
WHERE p.updated_at > NOW() - INTERVAL 3 HOUR
~~~~
~~~~sql 
SELECT DISTINCT p.*, d.*
FROM products p
INNER JOIN descriptions d ON p.EAN = d.EAN
WHERE p.EAN IN (SELECT EAN FROM products WHERE updated_at > NOW() - INTERVAL 3 HOUR)
~~~~

* which from the above is the most performant and what can you do check fact it?

`If you want to determine the relative performance of the two versions of the query, you could try running them both and comparing the execution times using the EXPLAIN or EXPLAIN ANALYZE commands in MySQL. This will provide information about how the database is executing the queries and can help you identify any potential performance bottlenecks.`

----
> ## Write some code

* Write a query to find the products that have not been ordered.
~~~~sql 
SELECT p.product_name
FROM products p
LEFT JOIN orders o
ON p.product_id = o.product_id
WHERE o.product_id IS NULL;
~~~~
* Write a query to find the total number of products with a price greater than $50.
~~~~sql 
SELECT COUNT(*)
FROM products
WHERE price > 50;
~~~~
* Write a query to find the customer who has placed the most orders.
~~~~sql 
SELECT customer_name, COUNT(*) AS num_orders
FROM orders
GROUP BY customer_name
ORDER BY COUNT(*) DESC
LIMIT 1;
~~~~
* Write a query to find the total number of orders and the total number of customers.
~~~~sql 
SELECT 'Total Orders' AS metric, COUNT(*) AS value
FROM orders
UNION
SELECT 'Total Customers', COUNT(DISTINCT customer_name)
FROM orders;
~~~~
* Write a query to display the number of products in each category, along with the total number of products.
~~~~sql 
SELECT COUNT(*) AS total_products, category
FROM products
GROUP BY category
UNION
SELECT COUNT(*), 'Total'
FROM products;
~~~~
* Write a query to display a list of products and their average price, rounded to two decimal places.
~~~~sql 
SELECT product_name, ROUND(AVG(price), 2) AS avg_price
FROM products
GROUP BY product_name;
~~~~
* Write a query to find the top 10 customers by total purchase amount.
~~~~sql 
SELECT customer_name, SUM(order_total)
FROM orders
GROUP BY customer_name
ORDER BY SUM(order_total) DESC
LIMIT 10;
~~~~