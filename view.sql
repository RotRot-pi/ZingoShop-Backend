




-- Favorite View

CREATE OR REPLACE VIEW favoriteView AS
SELECT favorite.*, items.* , users.user_id FROM favorite 
INNER JOIN users ON users.user_id = favorite.favorite_user_id
INNER JOIN items ON items.items_id = favorite.favorite_item_id;

-- Orders View 

CREATE OR REPLACE VIEW ordersView AS
SELECT orders.* ,address.* FROM orders
LEFT JOIN address ON address.address_id = orders.order_address_id;

-- Orders Details View

CREATE OR REPLACE VIEW ordersDetailsView AS 
SELECT SUM(items.items_price - items.items_price * items.items_discount / 100) as items_discount_price  ,cart.* ,items.* , ordersView.* FROM cart
INNER JOIN items ON items.items_id = cart.cart_item_id
WHERE cart.cart_order_id != 0 
-- GROUP BY ... ,cart.cart_order_id So every order is separated from each other
GROUP BY cart.cart_item_id ,cart.cart_user_id ,cart.cart_order_id;

-- Top Selling Items View
CREATE OR REPLACE VIEW itemsTopSellingView AS
SELECT COUNT(cart.cart_id) as countTimes , cart.* ,items.* FROM cart
INNER JOIN items ON items.items_id = cart.cart_item_id
WHERE cart.cart_order_id != 0 
GROUP BY cart.cart_item_id