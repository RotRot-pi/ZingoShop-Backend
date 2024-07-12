




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
SELECT 
    cart.cart_order_id,
    (items.items_price - (items.items_price * items.items_discount / 100)) AS item_price_at_purchase, -- Discounted price
    SUM(items.items_price - items.items_price * items.items_discount / 100) AS items_discount_price,
    cart.cart_id,
    cart.cart_user_id,
    cart.cart_item_id,
    cart.cart_item_count,
    items.items_id,
    items.items_name,
    items.items_name_ar,
    items.items_price,
    items.items_discount,
    items.items_active,
    items.items_count,
    items.items_image,
    items.items_description,
    items.items_description_ar,
    items.items_datetime,
    items.items_category,
    ordersView.order_address_id,
    ordersView.order_user_id,
    ordersView.order_type,
    ordersView.order_delivery_price,
    ordersView.order_coupon_id,
    ordersView.order_date_time,
    ordersView.order_price,
    ordersView.order_totalprice,
    ordersView.order_payment_type,
    ordersView.order_status,
    ordersView.order_rating,
    ordersView.order_notating,
    ordersView.order_delivery,
    ordersView.address_city,
    ordersView.address_name,
    ordersView.address_street,
    ordersView.address_lat,
    ordersView.address_long
FROM 
    cart
INNER JOIN 
    items ON items.items_id = cart.cart_item_id
INNER JOIN 
    ordersView ON ordersView.order_id = cart.cart_order_id
WHERE 
    cart.cart_order_id != 0 
GROUP BY 
    cart.cart_order_id, cart.cart_item_id; -- Group by order_id AND cart_item_id
-- CREATE OR REPLACE VIEW ordersDetailsView AS 
-- SELECT 
--     cart.cart_order_id, 
--     SUM(items.items_price - items.items_price * items.items_discount / 100) AS items_discount_price,
--     cart.cart_id,
--     cart.cart_user_id,
--     cart.cart_item_id,
--     cart.cart_item_count,
--     items.items_id,
--     items.items_name,
--     items.items_name_ar,
--     items.items_price,
--     items.items_discount,
--     items.items_active,
--     items.items_count,
--     items.items_image,
--     items.items_description,
--     items.items_description_ar,
--     items.items_datetime,
--     items.items_category,
--     -- Select the remaining columns directly from ordersView 
--     ordersView.order_address_id,
--     ordersView.order_user_id,
--     ordersView.order_type,
--     ordersView.order_delivery_price,
--     ordersView.order_coupon_id,
--     ordersView.order_date_time,
--     ordersView.order_price,
--     ordersView.order_totalprice,
--     ordersView.order_payment_type,
--     ordersView.order_status,
--     ordersView.order_rating,
--     ordersView.order_notating,
--     ordersView.order_delivery,
--     ordersView.address_city,
--     ordersView.address_name,
--     ordersView.address_street,
--     ordersView.address_lat,
--     ordersView.address_long
-- FROM 
--     cart
-- INNER JOIN 
--     items ON items.items_id = cart.cart_item_id
-- INNER JOIN 
--     ordersView ON ordersView.order_id = cart.cart_order_id
-- WHERE 
--     cart.cart_order_id != 0 
-- GROUP BY 
--     cart.cart_order_id;
-- CREATE OR REPLACE VIEW ordersDetailsView AS 
-- SELECT SUM(items.items_price - items.items_price * items.items_discount / 100) as items_discount_price  ,cart.* ,items.* , ordersView.* FROM cart
-- INNER JOIN items ON items.items_id = cart.cart_item_id
-- WHERE cart.cart_order_id != 0 
-- -- GROUP BY ... ,cart.cart_order_id So every order is separated from each other
-- GROUP BY cart.cart_item_id ,cart.cart_user_id ,cart.cart_order_id;

-- Top Selling Items View
CREATE OR REPLACE VIEW itemsTopSellingView AS
SELECT COUNT(cart.cart_id) as countTimes , cart.* ,items.* FROM cart
INNER JOIN items ON items.items_id = cart.cart_item_id
WHERE cart.cart_order_id != 0 
GROUP BY cart.cart_item_id